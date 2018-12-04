<?php

namespace App\Models\Traits\Rooms;

use App\Models\Orders\Rooms\Room;
use App\Models\Services\Service;

trait RoomCalculationTrait
{
    public static function bootRoomCalculationTrait()
    {
        static::creating(function($room) {
            $room->area = $room->getArea();
            $room->perimeter = $room->getPerimeter();
            $room->wall_area = $room->getWallArea();
        });
    }

    protected function getArea()
    {
        return $this->length * $this->width;
    }

    protected function getPerimeter()
    {
        return 2 * ($this->length + $this->width);
    }

    protected function getWallArea()
    {
        if ($this->windowArea() !== 0) {
            return $this->getPerimeter() * $this->height - $this->windowArea();
        } else {
            return $this->getPerimeter() * $this->height;
        }
    }

    protected function windowArea()
    {
        $windows_area = 0;

        foreach ($this->windows as $window) {
            $windows_area += $window->length * $window->width * $window->quantity;
        }

        return $windows_area;
    }

    protected function addRoomPriceToOrder($room)
    {
        $total_order_price = 0;
        $original_order_price = 0;

        foreach ($room->order->rooms as $new_room) {
            $total_order_price += (int) $new_room->price;
            $original_order_price += (int) $new_room->original_price;
        }

        $room->order->update([
            'price' => $total_order_price,
            'original_price' => $original_order_price
        ]);
    }

    protected function room_steps_automation(Room $room, String $type)
    {
        if ($type === 'created') {
            if (count($room->order->order_steps) !== 0) {
                foreach ($room->order->order_steps as $order_step) {
                    $order_step->room_steps()->create([
                        'room_id' => $room->id
                    ]);
                }
            }
        }

        if ($type === 'deleted') {
            if (count($room->order->order_steps) !== 0) {
                foreach ($room->order->order_steps as $order_step) {
                    $order_step->room_steps()->where('room_id', $room->id)->delete();
                }
            }
        }
    }

    protected function finished_rooms_automation(Room $room, String $type)
    {
        if ($type === 'created') {
            if (count($room->order->finished_order_acts) !== 0) {
                foreach ($room->order->finished_order_acts as $finished_order_act) {
                    $finished_order_act->finished_rooms()->create([
                        'room_id' => $room->id
                    ]);
                }
            }
        }

        if ($type === 'deleted') {
            if (count($room->order->finished_order_acts) !== 0) {
                foreach ($room->order->finished_order_acts as $finished_order_act) {
                    $finished_order_act->finished_rooms()->where('room_id', $room->id)->delete();
                }
            }
        }

    }

    protected function extra_rooms_automation(Room $room, String $type)
    {
        if ($type === 'created') {
            if (count($room->order->extra_order_acts) !== 0) {
                foreach ($room->order->extra_order_acts as $extra_order_act) {
                    $extra_order_act->extra_rooms()->create([
                        'room_id' => $room->id,
                        'length' => $room->length,
                        'width' => $room->width,
                        'height' => $room->height,
                        'area' => $room->area,
                        'wall_area' => $room->wall_area,
                        'perimeter' => $room->perimeter,
                    ]);
                }
            }
        }

        if ($type === 'deleted') {
            if (count($room->order->extra_order_acts) !== 0) {
                foreach ($room->order->extra_order_acts as $extra_order_act) {
                    $extra_order_act->extra_rooms()->where('room_id', $room->id)->delete();
                }
            }
        }
    }
}
