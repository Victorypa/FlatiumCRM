<?php

namespace App\Http\Controllers\Api\Orders\Acts;

use PDF;
use Storage;
use DateTime;
use App\Models\Orders\Order;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Orders\Acts\ExtraOrderAct;

class ExtraOrderActController extends Controller
{
    public function show(Order $order, ExtraOrderAct $extra_order_act)
    {
        $filteredExtraOrderAct = ExtraOrderAct::where('id', $extra_order_act->id)
                                    ->with([
                                        'order', 'extra_rooms', 'extra_rooms.room',
                                        'extra_rooms.room.roomType', 'extra_rooms.extra_room_services',
                                        'extra_rooms.extra_room_services', 'order.rooms.order', 'extra_rooms.extra_room_services.service'
                                    ])
                                    ->first();

        return response()->json($filteredExtraOrderAct);
    }

    public function store(Request $request)
    {
        $extra_order_act = ExtraOrderAct::create([
            'order_id' => $request->order_id,
            'name' => $request->name
        ]);

        $this->createExtraRooms($extra_order_act);

        $filtered_extra_order_act = ExtraOrderAct::where('id', $extra_order_act->id)->with('extra_rooms')->first();

        return response()->json($filtered_extra_order_act);

    }

    public function update(Order $order, ExtraOrderAct $extra_order_act, Request $request)
    {
        $extra_order_act->update($request->all());
    }

    public function destroy(Order $order, ExtraOrderAct $extra_order_act)
    {
        if ($this->canBeDeleted($order, $extra_order_act)) {
            $extra_order_act->delete();
        }
    }

    public function exportWithoutMaterials(Order $order, ExtraOrderAct $extra_order_act)
    {
        $filteredExtraOrder = ExtraOrderAct::where('id', $extra_order_act->id)
                         ->with([
                            'order', 'extra_rooms', 'extra_rooms.extra_services',
                            'extra_rooms.extra_services.service_type', 'extra_rooms.extra_services.unit'
                         ])->first();

        return $this->export($filteredExtraOrder, 'export.ExtraOrderActs.pdf');
    }

    public function exportPDFWithMaterials(Order $order, ExtraOrderAct $extra_order_act)
    {
        $filteredExtraOrder = ExtraOrderAct::where('id', $extra_order_act->id)
                         ->with([
                            'order', 'extra_rooms', 'extra_rooms.extra_services', 'extra_rooms.extra_services.actual_materials',
                            'extra_rooms.extra_services.service_type', 'extra_rooms.extra_services.unit'
                         ])->first();

        return $this->exportWithMaterials($filteredExtraOrder, 'export.ExtraOrderActs.pdf_materials');
    }

    protected function exportWithMaterials($filteredExtraOrder, $path)
    {
        $total_area = 0;
        foreach ($filteredExtraOrder->extra_rooms as $extra_room) {
            $total_area += (float) $extra_room->area;
        }

        $name = str_random(12);

        $material_names = $this->getMaterials($filteredExtraOrder, 'name');
        $material_rates = $this->getMaterials($filteredExtraOrder, 'rate');
        $material_quantites = $this->getMaterials($filteredExtraOrder, 'quantity');
        $material_prices = $this->getMaterials($filteredExtraOrder, 'price');

        $material_total_price = 0;

        foreach ($material_rates as $id => $value) {
            $material_total_price += ceil($material_rates[$id] / $material_quantites[$id]) * $material_prices[$id];
        }

        $pdf = PDF::setOptions([['defaultFont' => 'DejaVu Sans']])
                  ->loadView($path, array(
                      'filteredExtraOrder' => $filteredExtraOrder,
                      'total_area' => $total_area,
                      'material_names' => $material_names,
                      'material_rates' => $material_rates,
                      'material_quantites' => $material_quantites,
                      'material_prices' => $material_prices,
                      'material_total_price' => $material_total_price
                  ))
                  ->setPaper('a4', 'portrait');


        $pdf = $pdf->save($path = storage_path("app/public/$name.pdf"));

        if (!$pdf) {
            return response()->json(['message' => 'some error']);
        }

        $response = Storage::disk('local')->put(
            $this->buildFilePath($name),
            file_get_contents($path)
        );

        if ($response) {
            return response()->json([
                "url" => url('/'),
                "data" => "$name.pdf"
            ]);
        }
    }

    protected function export($filteredExtraOrder, $path)
    {
        $total_area = 0;

        foreach ($filteredExtraOrder->extra_rooms as $room) {
            $total_area += (float)$room->area;
        }

        $name = str_random(12);

        $pdf = PDF::setOptions([['defaultFont' => 'DejaVu Sans']])
                  ->loadView($path, array('filteredExtraOrder' => $filteredExtraOrder, 'total_area' => $total_area))
                  ->setPaper('a4', 'portrait');


        $pdf = $pdf->save($path = storage_path("app/public/$name.pdf"));

        if (!$pdf) {
            return response()->json(['message' => 'some error']);
        }

        $response = Storage::disk('local')->put(
            $this->buildFilePath($name),
            file_get_contents($path)
        );

        if ($response) {
            return response()->json([
                "url" => url('/'),
                "data" => "$name.pdf"
            ]);
        }
    }


    // To do
    protected function getMaterials(ExtraOrderAct $extra_order_act, $type)
    {
        $material_ids = [];
        $material_names = [];
        $material_quantites = [];
        $material_rates = [];
        $material_prices = [];

        foreach ($extra_order_act->extra_rooms as $extra_room) {
            foreach ($extra_room->extra_services()->get() as $service) {
                foreach ($service->actual_materials as $material) {

                    array_push($material_ids, $material->id);
                    $material_names[$material->id] = $material->name;
                    $material_prices[$material->id] = (float) $material->price;

                    if ($material->quantity != null) {
                        $material_quantites[$material->id] = (float) $material->quantity;
                    } else {
                        $material_quantites[$material->id] = 0;
                    }

                    if ($material->pivot->rate != null) {
                        if (!array_key_exists($material->id, $material_rates)) {
                            $material_rates[$material->id] = (float) $material->pivot->rate;
                        }  else {
                            $material_rates[$material->id] += (float) $material->pivot->rate;
                        }
                    } else {
                        $material_rates[$material->id] = 0;
                    }
                }

            }

        }

        switch ($type) {
            case 'name':
                return $material_names;
                break;
            case 'rate':
                return $material_rates;
                break;
            case 'quantity':
                return $material_quantites;
                break;

            case 'price':
                return $material_prices;
                break;
            default:
                return;
                break;
        }
    }

    protected function createExtraRooms(ExtraOrderAct $extra_order_act)
    {
        $extra_room_ids = [];

        foreach ($extra_order_act->extra_rooms as $extra_room) {
            array_push($extra_room_ids, $extra_room->room_id);
        }

        if (count($extra_room_ids) === 0) {
            foreach ($extra_order_act->order->rooms as $room) {
                $extra_order_act->extra_rooms()->create([
                    'room_id' => $room->id,
                    'length' => $room->length,
                    'width' => $room->width,
                    'height' => $room->height,
                    'area' => $room->area,
                    'wall_area' => $room->wall_area,
                    'perimeter' => $room->perimeter,
                ]);
            }
        }
    }

    protected function canBeDeleted(Order $order, ExtraOrderAct $extra_order_act)
    {
        return $extra_order_act->toArray() === $order->extra_order_acts->toArray()[count($order->extra_order_acts->toArray()) - 1];
    }

    protected function buildFilePath($name)
    {
       return 'pdfs/' . $name . '.pdf';
    }
}
