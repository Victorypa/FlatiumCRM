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

        // Calculate room_services
        foreach ($room->room_services()->get() as $room_service) {
            if ($room->order->discount) {
                if ($room_service->service->can_be_discounted) {
                    $room_service->update([
                        'original_price' => (float) $room_service->quantity * (int) $room_service->service->price,
                        'price' => (float) $room_service->quantity * (int) $room_service->service->price * (1 - ((float) $room->order->discount/100))
                    ]);
                } else {
                    $room_service->update([
                        'original_price' => (float) $room_service->quantity * (int) $room_service->service->price,
                        'price' => (float) $room_service->quantity * (int) $room_service->service->price
                    ]);
                }
            }

            if ($room->order->markup) {
                $room_service->update([
                    'original_price' => (float) $room_service->quantity * (int) $room_service->service->price,
                    'price' => (float) $room_service->quantity * (int) $room_service->service->price * (1 + ((float) $room->order->markup/100))
                ]);
            }

            if (!$room->order->discount && !$room->order->markup) {
                if ($room_service->markup) {
                    $room_service->update([
                        'original_price' => (float) $room_service->quantity * (int) $room_service->service->price,
                        'price' => (float) $room_service->quantity * (int) $room_service->service->price * (1 + ((float) $room_service->markup/100))
                    ]);
                }
                if (!$room_service->markup) {
                    $room_service->update([
                        'original_price' => (float) $room_service->quantity * (int) $room_service->service->price,
                        'price' => (float) $room_service->quantity * (int) $room_service->service->price
                    ]);
                }
            }
        }

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
        $original_room_price = 0;
        $total_room_price = 0;

        foreach ($room->order->rooms()->get() as $room) {
            $original_room_price += $room->original_price;
            $total_room_price += $room->price;
        }

        $room->order()->update([
            'price' => $total_room_price,
            'original_price' => $original_room_price
        ]);
    }

}
