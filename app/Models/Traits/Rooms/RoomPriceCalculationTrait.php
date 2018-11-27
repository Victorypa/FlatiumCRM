<?php

namespace App\Models\Traits\Rooms;

use App\Models\Services\Service;
use App\Models\Orders\Rooms\Room;

trait RoomPriceCalculationTrait
{
    public function calculateRoomPrice(Room $room)
    {
        $original_room_price = 0;
        $total_room_price = 0;

        foreach ($room->services()->get() as $service) {
            $total_room_price += (float) $service->pivot->price;
            $original_room_price += (float) Service::where('id', $service->id)->first()->price * $service->pivot->quantity;
        }

        $room->update([
            'price' => $total_room_price,
            'original_price' => $original_room_price
        ]);

        return $room;
    }

    public function calculateOrderPrice(Room $room)
    {
        $total_price = 0;
        $original_price = 0;

        $rooms = $room->order->rooms->where('room_type_id', '!=', 4);

        foreach ($rooms as $new_room) {
            $total_price += (float) $new_room->price;
            $original_price += (float) $new_room->original_price;
        }

        $room->order->update([
            'price' => $total_price,
            'original_price' => $original_price
        ]);

        return $room->order->get();
    }

}
