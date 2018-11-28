<?php

namespace App\Http\Controllers\Api\Orders;

use App;
use PDF;
use Storage;
use App\Models\Services\Service;
use App\Models\Orders\Order;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Controllers\Api\Orders\Traits\OrderExportTrait;
use App\Models\Exports\{
    OrdersExportWithMaterials, OrdersExportWithoutMaterials
};

class OrderController extends Controller
{
    use OrderExportTrait;

    public function index()
    {
        if(!file_exists(public_path('storage'))) {
           App::make('files')->link(storage_path('app/public'), public_path('storage'));
        }

        $orders = Order::orderBy('created_at', 'asc')->with(['rooms', 'finished_order_acts', 'extra_order_acts', 'extra_order_acts.extra_rooms'])->get();

        return response()->json($orders);
    }

    public function show(Order $order)
    {
        $filterdOrder = Order::where('id', $order->id)
                             ->with([
                                 'rooms', 'rooms.roomType', 'manager',
                                 'finished_order_acts',
                                 'rooms.finished_room', 'extra_order_acts',
                                 'finances', 'finished_order_acts', 'rooms.room_services',
                                 ])
                             ->first();

        return $filterdOrder;
    }

    public function update(Order $order, Request $request)
    {
        $order->update($request->all());
    }

    public function updateOrderDiscountOrMarkup(Order $order, Request $request)
    {
        $order->update([
            'discount' => $request->discount,
            'markup' => $request->markup
        ]);

        $this->recalculateAfterDiscountOrMarkup($order);
    }

    public function exportPdfWithoutMaterials(Order $order)
    {
        $filteredOrder = Order::where('id', $order->id)
                         ->with([
                             'rooms', 'rooms.roomType', 'rooms.room_services',
                             'manager'
                         ])->first();

        return $this->export($filteredOrder, 'export.pdf');
    }


    public function exportPdfWithMaterials(Order $order)
    {
        $filteredOrder = Order::where('id', $order->id)
                         ->with([
                             'rooms', 'rooms.roomType'
                         ])->first();

        return $this->exportWithMaterials($filteredOrder, 'export.pdf_material');
    }

    public function exportExcelWithoutMaterials(Order $order)
    {
        $filteredOrder = Order::where('id', $order->id)
                         ->with([
                             'rooms', 'rooms.roomType'
                         ])->first();

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


    protected function recalculateAfterDiscountOrMarkup(Order $order)
    {
        $room_service_price = 0;
        $room_price = 0;

        if ($order->discount !== null && $order->markup === null) {
            foreach ($order->rooms()->get() as $room) {
                foreach ($room->room_services()->get() as $room_service) {
                    if ($this->getServiceDetails($room_service->service_id, 'can_be_discounted')) {
                        $room_service_price += $this->getServiceDetails($room_service->service_id, 'price') * (1 - (float) $order->discount / 100) * (float) $room_service->quantity;
                    }

                    if (!$this->getServiceDetails($room_service->service_id, 'can_be_discounted')) {
                        $room_service_price += $this->getServiceDetails($room_service->service_id, 'price') * (float) $room_service->quantity;
                    }
                }
                $result = $room->update([
                    'price' => (float) $room_service_price
                ]);
                if ($result) {
                    $room_service_price = 0;
                }

                $room_price += (float) $room->price;
            }


            $order->update([
                'price' => (float) $room_price,
                'markup' => null
            ]);
        }

        if ($order->markup !== null && $order->discount === null) {
            foreach ($order->rooms()->get() as $room) {
                foreach ($room->room_services()->get() as $room_service) {
                    $room_service_price += $this->getServiceDetails($room_service->service_id, 'price') * (1 + (float) $order->markup / 100) * (float) $room_service->quantity;
                }
                $result = $room->update([
                    'price' => (float) $room_service_price
                ]);
                if ($result) {
                    $room_service_price = 0;
                }

                $room_price += (float) $room->price;
            }

            $order->update([
                'price' => (float) $room_price,
                'discount' => null
            ]);
        }
    }

    protected function getServiceDetails($service_id, $type)
    {
        $service = Service::where('id', $service_id)->first();

        switch ($type) {
            case 'price':
                return (float)$service->price;
                break;
            case 'can_be_discounted':
                return $service->can_be_discounted;
                break;
            default:
                return null;
                break;
        }
    }
}
