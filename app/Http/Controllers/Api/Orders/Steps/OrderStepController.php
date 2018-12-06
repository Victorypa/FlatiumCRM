<?php

namespace App\Http\Controllers\Api\Orders\Steps;

use Carbon\Carbon;
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
        if ($request->description) {
            $order_step->update([
                'description' => $request->description,
            ]);
        }
        if ($request->begin_at) {
            $order_step->update([
                'begin_at' => date('Y-m-d H:i:s', strtotime($request->begin_at)),
            ]);
        }

        if ($request->finish_at) {
            $order_step->update([
                'finish_at' => date('Y-m-d H:i:s', strtotime($request->finish_at))
            ]);
        }
    }

    public function destroy(Order $order, OrderStep $order_step)
    {
        $order_step->delete();
    }
}
