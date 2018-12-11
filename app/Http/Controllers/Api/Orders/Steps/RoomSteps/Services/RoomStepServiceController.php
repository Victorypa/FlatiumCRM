<?php

namespace App\Http\Controllers\Api\Orders\Steps\RoomSteps\Services;

use Illuminate\Http\Request;
use App\Models\Orders\Order;
use App\Models\Services\Service;
use App\Models\Orders\Rooms\Room;
use App\Http\Controllers\Controller;
use App\Models\Orders\Steps\OrderStep;
use App\Models\Orders\Steps\Rooms\RoomStep;

class RoomStepServiceController extends Controller
{
    public function index(Order $order, OrderStep $order_step)
    {

    }

    public function store(Order $order, OrderStep $order_step, Request $request)
    {
        foreach ($request->selected_service_ids as $room_id => $services) {
            $room_step = $order_step->room_steps()->where('room_id', $room_id)->first();
            $service_ids = [];
            $service_quantities = [];
            foreach ($services as $service) {
                array_push($service_ids, $service['service_id']);
                $service_quantities[$service['service_id']] = $service['quantity'];
            }
            $room_step->services()->sync($service_ids);

            foreach ($service_quantities as $service_id => $quantity) {
                $currentService = Service::where('id', $service_id)->first();
                if ($order->discount !== null) {
                    if ($currentService->can_be_discounted) {
                        $room_step->services()->updateExistingPivot($service_id, [
                            'quantity' => $quantity,
                            'price' => $quantity * $currentService->price * (1 - (float)$order->discount/100),
                            'service_type_id' => $currentService->service_type_id,
                            'service_unit_id' => $currentService->unit_id
                        ]);
                    } else {
                        $room_step->services()->updateExistingPivot($service_id, [
                            'quantity' => $quantity,
                            'price' => $quantity * $currentService->price,
                            'service_type_id' => $currentService->service_type_id,
                            'service_unit_id' => $currentService->unit_id
                        ]);
                    }
                }

                if ($order->markup !== null) {
                    $room_step->services()->updateExistingPivot($service_id, [
                        'quantity' => $quantity,
                        'price' => $quantity * $currentService->price * (1 + (float)$order->markup/100),
                        'service_type_id' => $currentService->service_type_id,
                        'service_unit_id' => $currentService->unit_id
                    ]);
                }

                if ($order->markup === null && $order->discount === null) {
                    $room_step->services()->updateExistingPivot($service_id, [
                        'quantity' => $quantity,
                        'price' => $quantity * $currentService->price,
                        'service_type_id' => $currentService->service_type_id,
                        'service_unit_id' => $currentService->unit_id
                    ]);
                }

            }
        }
    }

    public function destroy(Order $order, RoomStep $room_step, Service $service, Request $request)
    {
        $room_step->services()->detach($service->id);
    }

    protected function calculateOrderStepPrice(OrderStep $order_step)
    {

    }
}
