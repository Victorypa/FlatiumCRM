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
                if (!$room_service->markup) {

                    if ($this->discount) {
                        if ($room_service->service->can_be_discounted) {
                            $room_service->update([
                                'price' => $room_service->original_price * (1 - (float) $this->discount / 100)
                            ]);
                        }
                    }

                    if ($this->markup) {
                        $room_service->update([
                            'price' => $room_service->original_price * (1 + (float) $this->markup / 100)
                        ]);
                    }

                    if (!$this->markup && !$this->discount) {
                        $room_service->update([
                            'price' => $room_service->original_price
                        ]);
                    }
                }
            }
            $room->calculateRoomPrice($room);
        }

    }
}
