<?php

namespace App\Http\Controllers\Api\Orders\Steps\RoomSteps\Services;

use Illuminate\Http\Request;
use App\Models\Orders\Order;
use App\Models\Orders\Rooms\Room;
use App\Http\Controllers\Controller;
use App\Models\Orders\Steps\OrderStep;

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
                $room_step->services()->updateExistingPivot($service_id, [
                    'quantity' => $quantity
                ]);
            }
        }
    }
}
