<?php

namespace App\Models\Traits\Rooms;

use App\Models\Orders\Rooms\Room;

trait RoomServiceTrait
{
    public function getExistedRoomServicesIds(Room $room)
    {
        $existed_room_service_ids = [];

        foreach ($room->room_services as $room_service) {
            array_push($existed_room_service_ids, $room_service->service_id);
        }

        return $existed_room_service_ids;
    }
}
