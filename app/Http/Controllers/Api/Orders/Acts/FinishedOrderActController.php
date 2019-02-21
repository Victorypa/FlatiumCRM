<?php

namespace App\Http\Controllers\Api\Orders\Acts;

use PDF;
use Storage;
use DateTime;
use App\Models\Orders\Order;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Orders\Acts\FinishedOrderAct;

class FinishedOrderActController extends Controller
{
    public function index(Order $order)
    {
        return $order->finished_order_acts()->get();
    }

    public function show(Order $order, FinishedOrderAct $finished_order_act)
    {
        $filteredFinishedOrderAct = FinishedOrderAct::where('id', $finished_order_act->id)
                                    ->with([
                                        'order', 'finished_rooms', 'finished_rooms.room.roomType' ,
                                        'finished_rooms.finished_room_services', 'finished_rooms.room'
                                    ])
                                    ->first();

        return response()->json($filteredFinishedOrderAct);
    }

    public function store(Order $order, Request $request)
    {
        $finished_order_act = $order->finished_order_acts()->create([
            'name' => $request->state['name'],
            'description' => $request->state['description'],
            'begin_at' => new DateTime($request->state['begin_at']),
            'finish_at' => new DateTime($request->state['finish_at'])
        ]);

        $this->createFinishedRooms($finished_order_act);

        return response()->json($finished_order_act);

    }

    public function update(Order $order, FinishedOrderAct $finished_order_act, Request $request)
    {
        if ($request->state) {
            $finished_order_act->update([
                'begin_at' => new DateTime($request->state['begin_at']),
                'finish_at' => new DateTime($request->state['finish_at'])
            ]);
        } else {
            $finished_order_act->update($request->all());
        }

    }

    public function destroy(Order $order, FinishedOrderAct $finished_order_act)
    {
        if ($this->canBeDeleted($order, $finished_order_act)) {
            $finished_order_act->delete();
        }
    }

    public function exportPdf(Order $order, FinishedOrderAct $finished_order_act)
    {
        $filteredFinishedOrderAct = FinishedOrderAct::where('id', $finished_order_act->id)
                                    ->with([
                                        'order', 'finished_rooms', 'finished_rooms.finished_room_services',
                                        'finished_rooms.finished_room_services.service', 'finished_rooms.finished_room_services.service.unit',
                                        'finished_rooms.room', 'finished_rooms.room.roomType'
                                    ])
                                    ->first();

        return $this->export($filteredFinishedOrderAct, 'export.FinishedOrderActs.pdf');
    }

    protected function export($filteredFinishedOrderAct, $path)
    {
        $total_area = 0;
        foreach ($filteredFinishedOrderAct->order->rooms as $room) {
            $total_area += (float) $room->area;
        }

        $selected_price = 0;
        foreach ($filteredFinishedOrderAct->finished_rooms as $room) {
            $selected_price += (float) $room->price;
        }

        $name = str_random(12);

        $pdf = PDF::setOptions([['defaultFont' => 'DejaVu Sans']])
                  ->loadView($path, array(
                      'filteredFinishedOrderAct' => $filteredFinishedOrderAct,
                      'total_area' => $total_area,
                      'selected_price' => $selected_price
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

    protected function buildFilePath($name)
    {
       return 'pdfs/' . $name . '.pdf';
    }

    protected function createFinishedRooms(FinishedOrderAct $finished_order_act)
    {
        $finished_room_ids = [];

        foreach ($finished_order_act->finished_rooms as $finished_room) {
            array_push($finished_room_ids, $finished_room->room_id);
        }

        if (count($finished_room_ids) === 0) {
            foreach ($finished_order_act->order->rooms as $room) {
                $finished_order_act->finished_rooms()->create([
                    'room_id' => $room->id
                ]);
            }
        }
    }

    protected function canBeDeleted(Order $order, FinishedOrderAct $finished_order_act)
    {
        return $finished_order_act->toArray() === $order->finished_order_acts->toArray()[count($order->finished_order_acts->toArray()) - 1];
    }
}
