<?php

namespace App\Models\Traits\Orders;

use App\Models\Orders\Order;
use App\Models\Services\Service;

trait OrderCalculationTrait
{
    public function recalculateAfterDiscountOrMarkup()
    {
        $room_service_price = 0;
        $room_price = 0;

        if ($this->discount !== null && $this->markup === null) {
            foreach ($this->rooms()->get() as $room) {
                foreach ($room->room_services()->get() as $room_service) {
                    if ($this->getServiceDetails($room_service->service_id, 'can_be_discounted')) {
                        $room_service_price += $this->getServiceDetails($room_service->service_id, 'price') * (1 - (float) $this->discount / 100) * (float) $room_service->quantity;
                    }

                    if (!$this->getServiceDetails($room_service->service_id, 'can_be_discounted')) {
                        $room_service_price += $this->getServiceDetails($room_service->service_id, 'price') * (float) $room_service->quantity;
                    }
                }
                $result = $room->update([
                    'price' => (float) $room_service_price
                ]);
                if ($result) {
                    $room_service_price = 0;
                }

                $room_price += (float) $room->price;
            }


            $this->update([
                'price' => (float) $room_price,
                'markup' => null
            ]);
        }

        if ($this->markup !== null && $this->discount === null) {
            foreach ($this->rooms()->get() as $room) {
                foreach ($room->room_services()->get() as $room_service) {
                    $room_service_price += $this->getServiceDetails($room_service->service_id, 'price') * (1 + (float) $this->markup / 100) * (float) $room_service->quantity;
                }
                $result = $room->update([
                    'price' => (float) $room_service_price
                ]);
                if ($result) {
                    $room_service_price = 0;
                }

                $room_price += (float) $room->price;
            }

            $this->update([
                'price' => (float) $room_price,
                'discount' => null
            ]);
        }
    }

    protected function getServiceDetails($service_id, $type)
    {
        $service = Service::where('id', $service_id)->first();

        switch ($type) {
            case 'price':
                return (float)$service->price;
                break;
            case 'can_be_discounted':
                return $service->can_be_discounted;
                break;
            default:
                return null;
                break;
        }
    }
}
