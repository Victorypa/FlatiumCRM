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
        $with = ['order_steps', 'order_steps.room_steps'];

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

    public function update(Order $order, OrderStep $order_step)
    {

    }

    public function destroy(Order $order, OrderStep $order_step)
    {

    }

    protected function randomHexColorGeneration()
    {
        $rand = str_pad(dechex(rand(0x000000, 0xFFFFFF)), 6, 0, STR_PAD_LEFT);

        return "#{$rand}";
    }
}
