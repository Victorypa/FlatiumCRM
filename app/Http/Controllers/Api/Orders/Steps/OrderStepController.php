<?php

namespace App\Http\Controllers\Api\Orders\Steps;

use Illuminate\Http\Request;
use App\Models\Orders\Order;
use App\Http\Controllers\Controller;
use App\Models\Orders\Steps\OrderStep;

class OrderStepController extends Controller
{
    public function index(Order $order)
    {
        $with = ['order_steps', 'rooms', 'rooms.room_services'];

        return Order::where('id', $order->id)->with($with)->first();
    }

    public function show(Order $order, OrderStep $order_step)
    {
        $with = ['order'];

        return OrderStep::where('id', $order_step->id)->with($with)->first();
    }

    public function store(Order $order)
    {
        $order->order_steps()->create([
            'name' => 'Спринт'
        ]);
    }

    public function update(Order $order, OrderStep $order_step, Request $request)
    {
        $order_step->update($request->all());
    }

    public function destroy(Order $order, OrderStep $order_step)
    {
        $order_step->delete();
    }
}
