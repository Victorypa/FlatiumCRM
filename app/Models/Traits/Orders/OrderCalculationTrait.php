<?php

namespace App\Models\Traits\Orders;

use App\Models\Orders\Order;
use App\Models\Services\Service;

trait OrderCalculationTrait
{
    public function recalculateAfterDiscountOrMarkup()
    {
        $room_price = 0;

        foreach ($this->rooms()->get() as $room) {
            foreach ($room->room_services()->get() as $room_service) {

                if ($this->discount !== null) {
                    if ($room_service->service->can_be_deleted) {
                        $room_price += $room_service->service->price * (1 - (float) $this->discount / 100) * (float) $room_service->quantity;
                    } else {
                        $room_price += $room_service->service->price * (float) $room_service->quantity;
                    }
                }

                if ($this->markup !== null) {
                    $room_price += $room_service->service->price * (1 + (float) $this->markup / 100) * (float) $room_service->quantity;
                }

                if ($this->markup === null && $this->discount === null) {
                    $room_price += $room_service->service->price * (float) $room_service->quantity;
                }
            }

            $room->update([
                'price' => (float) $room_price
            ]);
        }

        $total_room_price = 0;
        $original_room_price = 0;

        foreach ($this->rooms()->get() as $room) {
            $total_room_price += (float) $room->price;
            $original_room_price += (float) $room->original_price;
        }

        $this->update([
            'price' => $total_room_price,
            'original_price' => $original_room_price
        ]);

    }
}
