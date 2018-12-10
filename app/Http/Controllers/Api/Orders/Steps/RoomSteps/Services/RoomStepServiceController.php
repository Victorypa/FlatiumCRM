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
        $service_ids = [];

        foreach ($request->selected_service_ids as $room_id => $services) {
            $room_step = $order_step->room_steps()->where('room_id', $room_id)->first();
            dump($services);
            foreach ($services as $service) {
                $room_step->services()->sync($service['service_id']);
            }
        }
    }
}
