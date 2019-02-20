<?php

namespace App\Http\Controllers\Api\Orders\Acts\Rooms\Services;

use Illuminate\Http\Request;
use App\Models\Orders\Order;
use App\Models\Services\Service;
use App\Http\Controllers\Controller;
use App\Models\Orders\Acts\FinishedOrderAct;
use App\Models\Orders\Acts\Rooms\FinishedRoom;

class FinishedRoomServiceController extends Controller
{
    public function index(Order $order, FinishedOrderAct $finished_order_act, FinishedRoom $finished_room, Request $request)
    {
        // return response()->json([
        //     'selected_services' => $finished_room->finished_services()->get(),
        //     'finished_room' => $finished_room
        // ]);
    }

    public function store(Order $order, FinishedOrderAct $finished_order_act, Request $request)
    {
        $finished_room = FinishedRoom::where('id', $request->finished_room_id)->first();

        $finished_room_service = $finished_room->finished_room_services()->create([
            'service_id' => $request->service_id,
            'quantity' => $request->quantity,
            'price' => $request->price
        ]);

        // $this->updateFinishedRoomPrice($finished_room);

        return response()->json($finished_room_service);

    }

    public function update(Order $order, FinishedOrderAct $finished_order_act, Request $request)
    {
        $finished_room = FinishedRoom::where('id', $request->finished_room_id)->first();

        return $finished_room->finished_room_services()->where('service_id', $request->service_id)->update([
            'quantity' => $request->quantity,
            'price' => $request->price
        ]);
    }

    protected function updateFinishedRoomPrice(FinishedRoom $finished_room)
    {
        $price = 0;

        foreach ($finished_room->finished_services()->get() as $finished_service) {
            $price += (float) $finished_service->pivot->price;
        }

        $finished_room->update([
            'price' => $price
        ]);

        $total_price = $this->updateFinishedOrderActPrice($finished_room);

        return $total_price;
    }

    protected function updateFinishedOrderActPrice(FinishedRoom $finished_room)
    {
        $price = 0;

        foreach ($finished_room->FinishedOrderAct->finished_rooms as $finished_room) {
            $price += $finished_room->price;
        }
        $finished_room->FinishedOrderAct->update([
            'price' => $price
        ]);

        return $price;
    }
}
