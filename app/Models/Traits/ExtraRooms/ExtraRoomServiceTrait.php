<?php

namespace App\Models\Traits\ExtraRooms;
use App\Models\Orders\Acts\Rooms\ExtraRoom;

trait ExtraRoomServiceTrait
{
    public function getExistedExtraRoomServicesIds(ExtraRoom $room)
    {
        $existed_extra_room_service_ids = [];

        foreach ($room->extra_room_services as $extra_room_service) {
            array_push($existed_extra_room_service_ids, $extra_room_service->service_id);
        }

        return $existed_extra_room_service_ids;
    }
}
