<?php

namespace App\Models\Traits\Orders;

use App\Models\Orders\Order;
use Carbon\Carbon;

trait OrderCopyTrait
{
    public function optionalCopy()
    {
        $newOrder = Order::create([
            'order_name' => "{$this->order_name} копия",
            'address' => "{$this->address} копия",
            'original_price' => $this->original_price,
            'price' => $this->price,
            'created_at' => Carbon::now(),
            'isCopy' => true
        ]);

        foreach ($this->rooms as $room) {
            $newRoom = $newOrder->rooms()->create([
                'room_type_id' => $room->room_type_id,
                'length' => $room->length,
                'width' => $room->width,
                'height' => $room->height,
                'price' => $room->price,
                'original_price' => $this->original_price,
                'description' => $room->description,
            ]);

            foreach ($room->windows as $window) {
                $newRoom->windows()->create([
                    'type' => $window->type,
                    'length' => $window->length,
                    'width' => $window->width,
                    'quantity' => $window->quantity
                ]);
            }

        }

        return response()->json([
            $newOrder,
            $newOrder->rooms()->first()
        ]);
    }
}
