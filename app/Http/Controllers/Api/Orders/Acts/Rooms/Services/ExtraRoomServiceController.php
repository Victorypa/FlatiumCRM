<?php

namespace App\Http\Controllers\Api\Orders\Acts\Rooms\Services;

use App\Models\Orders\Order;
use Illuminate\Http\Request;
use App\Models\Services\Service;
use App\Http\Controllers\Controller;
use App\Models\Orders\Acts\ExtraOrderAct;
use App\Models\Orders\Acts\Rooms\ExtraRoom;
use App\Models\Orders\Acts\Rooms\Services\ExtraRoomService;

class ExtraRoomServiceController extends Controller
{
    public function index(Order $order, ExtraOrderAct $extra_order_act, ExtraRoom $extra_room)
    {
        return ExtraRoomService::where('extra_room_id', $extra_room->id)->get();
    }

    public function show(Order $order, ExtraOrderAct $extra_order_act, ExtraRoom $extra_room, Service $extra_service, Request $request)
    {
        return ExtraRoomService::where([
            ['extra_room_id', $extra_room->id],
            ['service_id', $extra_service->id]
        ])->first();
    }

    public function store(Order $order, ExtraOrderAct $extra_order_act, ExtraRoom $extra_room, Request $request)
    {

        $extra_room->extra_room_services()->create([

        ]);

        // $this->calculateExtraRoomPrice($extra_room);


        // return response()->json([
        //     'extra_room' => $extra_room,
        //     'extra_order_act' => $updated_extra_order_act
        // ]);
    }

    protected function calculateExtraOrderActPrice(ExtraRoom $extra_room)
    {
        $total_price = 0;

        $extra_rooms = $extra_room->ExtraOrderAct->extra_rooms;

        foreach ($extra_rooms as $new_room) {
            $total_price += (int) $new_room->price;
        }

        $extra_room->ExtraOrderAct->update([
            'price' => $total_price
        ]);

        return $extra_room->ExtraOrderAct->first();
    }

    protected function calculateExtraRoomPrice(ExtraRoom $extra_room)
    {
        $total_room_price = 0;

        foreach ($extra_room->extra_room_services()->get() as $service) {
            $total_room_price += $service->price ;
        }

            $extra_room->update([
                'price' => $total_room_price
            ]);

            $total_room_price = 0;

            return $extra_room;
    }
}
