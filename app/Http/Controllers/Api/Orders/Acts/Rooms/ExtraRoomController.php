<?php

namespace App\Http\Controllers\Api\Orders\Acts\Rooms;

use App\Models\Orders\Order;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Orders\Acts\Rooms\ExtraRoom;
use App\Models\Orders\Acts\ExtraOrderAct;

class ExtraRoomController extends Controller
{
    public function show(Order $order, ExtraOrderAct $extra_order_act, ExtraRoom $extra_room)
    {
        $filteredExtraRoom = ExtraRoom::where('id', $extra_room->id)
                                      ->with([
                                          'ExtraOrderAct', 'ExtraOrderAct.extra_rooms', 'ExtraOrderAct.order',
                                          'extra_room_services', 'room', 'room.roomType', 'extra_windows',
                                          'ExtraOrderAct.extra_rooms.room', 'ExtraOrderAct.extra_rooms.room.room_services',
                                          'ExtraOrderAct.extra_rooms.room.roomType', 'extra_room_services',
                                      ])->first();

        return $filteredExtraRoom;
    }
}
