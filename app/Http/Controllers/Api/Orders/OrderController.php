<?php

namespace App\Http\Controllers\Api\Orders;

use App;
use PDF;
use Artisan;
use Storage;
use Carbon\Carbon;
use App\Models\Orders\Order;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Controllers\Api\Orders\Traits\OrderExportTrait;
use App\Models\Exports\{OrdersExportWithMaterials, OrdersExportWithoutMaterials};

class OrderController extends Controller
{
    use OrderExportTrait;

    public function index()
    {
        if(!file_exists(public_path('storage'))) {
           App::make('files')->link(storage_path('app/public'), public_path('storage'));
        }
        //
        Artisan::call('amo:data');

        $with = ['rooms', 'finished_order_acts', 'extra_order_acts'];

        return response()->json(
            Order::orderBy('created_at', 'asc')->with($with)->get()
        );
    }

    public function copy(Order $order)
    {
        switch (request('option')) {
            case '1':
                return $this->fullCopy($order);
                break;

            case '2':
                return $this->optionalCopy($order);
                break;
            default:
                return null;
                break;
        }

    }

    public function show(Order $order)
    {
        $order->recalculateAfterDiscountOrMarkup();

        $with = [
            'rooms', 'manager', 'finished_order_acts',
            'rooms.finished_room', 'extra_order_acts',
            'finances', 'finished_order_acts', 'rooms.room_services',
            'finances.finance_files'
        ];

        return Order::where('id', $order->id)->with($with)->first();
    }

    public function update(Order $order, Request $request)
    {
        $order->update($request->all());
    }

    public function destroy(Order $order)
    {
        if ($order->isCopy) {
            $order->delete();
        }
    }

    public function updateOrderDiscountOrMarkup(Order $order, Request $request)
    {
        $order->update([
            'discount' => $request->discount,
            'markup' => $request->markup
        ]);

        $order->recalculateAfterDiscountOrMarkup();
    }

    public function updateStatus(Order $order, Request $request)
    {
        $order->update([
            'processing' => $request->processing
        ]);
    }

    public function exportPdfWithoutMaterials(Order $order)
    {
        return $this->export(
            Order::where('id', $order->id)->with(['rooms', 'rooms.room_services', 'manager'])->first(),
            'export.pdf'
        );
    }


    public function exportPdfWithMaterials(Order $order)
    {
        return $this->exportWithMaterials(
            Order::where('id', $order->id)->with(['rooms', 'rooms.roomType'])->first(),
            'export.pdf_material'
        );
    }

    public function exportExcelWithoutMaterials(Order $order)
    {
        $filteredOrder = Order::where('id', $order->id)->with(['rooms'])->first();

        $name = str_random(12);

        Excel::store(new OrdersExportWithoutMaterials($filteredOrder), "public/$name.xlsx");

        return response()->json([
            "url" => url('/'),
            "data" => "$name.xlsx"
        ]);
    }

    public function exportExcelWithMaterials(Order $order)
    {
        $name = str_random(12);

        Excel::store(new OrdersExportWithMaterials($order), "public/$name.xlsx");

        return response()->json([
            "url" => url('/'),
            "data" => "$name.xlsx"
        ]);

    }

    protected function fullCopy(Order $order)
    {
        $newOrder = Order::create([
            'order_name' => "{$order->order_name} копия",
            'address' => "{$order->address} копия",
            'created_at' => Carbon::now(),
            'original_price' => $order->original_price,
            'price' => $order->price,
            'isCopy' => true
        ]);

        foreach ($order->rooms as $room) {
            $newRoom = $newOrder->rooms()->create([
                'room_type_id' => $room->room_type_id,
                'length' => $room->length,
                'width' => $room->width,
                'height' => $room->height,
                'price' => $room->price,
                'original_price' => $order->original_price,
                'description' => $room->description,
                'priority' => $room->priority
            ]);

            $newRoom->update([
                'area' => $room->area,
                'wall_area' => $room->wall_area,
                'perimeter' => $room->perimeter,
            ]);

            foreach ($room->windows as $window) {
                $newRoom->windows()->create([
                    'type' => $window->type,
                    'length' => $window->length,
                    'width' => $window->width,
                    'quantity' => $window->quantity
                ]);
            }

            foreach ($room->room_services as $room_service) {
                $newRoom->room_services()->create([
                    'service_id' =>  $room_service->service_id,
                    'service_type_id' => $room_service->service_type_id,
                    'service_unit_id' => $room_service->service_unit_id,
                    'quantity' => $room_service->quantity,
                    'price' => $room_service->price,
                    'priority' => $room_service->priority
                ]);
            }
        }

        return response()->json([
            $newOrder,
            $newOrder->rooms()->first()
        ]);
    }

    protected function optionalCopy(Order $order)
    {
        $newOrder = Order::create([
            'order_name' => "{$order->order_name} копия",
            'address' => "{$order->address} копия",
            'original_price' => $order->original_price,
            'price' => $order->price,
            'created_at' => Carbon::now(),
            'isCopy' => true
        ]);

        foreach ($order->rooms as $room) {
            $newRoom = $newOrder->rooms()->create([
                'room_type_id' => $room->room_type_id,
                'length' => $room->length,
                'width' => $room->width,
                'height' => $room->height,
                'price' => $room->price,
                'original_price' => $order->original_price,
                'description' => $room->description,
            ]);

            foreach ($room->windows as $window) {
                $newRoom->windows()->create([
                    'type' => $window->type,
                    'length' => $window->length,
                    'width' => $window->width,
                    'quantity' => $window->quantity
                ]);
            }


        }

        return response()->json([
            $newOrder,
            $newOrder->rooms()->first()
        ]);
    }
}
