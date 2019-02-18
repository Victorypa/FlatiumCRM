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

        foreach ($room->room_services()->get() as $room_service) {
            $total_room_price += (float) $room_service->price;
            $original_room_price += (float) $room_service->original_price;
        }

        $room->update([
            'price' => $total_room_price,
            'original_price' => $original_room_price
        ]);

        $this->calculateOrderPrice($room);

        return $room;
    }

    protected function calculateOrderPrice(Room $room)
    {

    }

}
