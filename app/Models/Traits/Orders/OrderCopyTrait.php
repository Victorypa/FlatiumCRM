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
                'priority' => $room->priority
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

    public function fullCopy()
    {
        $newOrder = Order::create([
            'order_name' => "{$this->order_name} копия",
            'address' => "{$this->address} копия",
            'created_at' => Carbon::now(),
            'original_price' => $this->original_price,
            'price' => $this->price,
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
                'priority' => $room->priority
            ]);

            $newRoom->update([
                'area' => $room->area,
                'wall_area' => $room->wall_area,
                'perimeter' => $room->perimeter,
            ]);

            foreach ($room->windows as $window) {
                $newRoom->windows()->create([
                    'type' => $window->type,
                    'length' => $window->length,
                    'width' => $window->width,
                    'quantity' => $window->quantity
                ]);
            }

            foreach ($room->room_services as $room_service) {
                $newRoom->room_services()->create([
                    'service_id' =>  $room_service->service_id,
                    'service_type_id' => $room_service->service_type_id,
                    'service_unit_id' => $room_service->service_unit_id,
                    'quantity' => $room_service->quantity,
                    'price' => $room_service->price,
                    'priority' => $room_service->priority
                ]);
            }
        }

        return response()->json([
            $newOrder,
            $newOrder->rooms()->first()
        ]);
    }
}
