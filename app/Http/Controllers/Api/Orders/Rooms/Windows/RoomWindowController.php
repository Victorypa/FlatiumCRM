<?php

namespace App\Http\Controllers\Api\Orders\Rooms\Windows;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Orders\Rooms\Room;
use App\Models\Orders\Order;
use App\Models\Services\Service;
use App\Models\Orders\Rooms\Windows\Window;

class RoomWindowController extends Controller
{
    public function index(Order $order, Room $room)
    {
        return response()->json([
            $room->windows()->orderBy('type', 'asc')->get()
        ]);
    }

    public function store(Order $order, Room $room, Request $request)
    {
        $window = $room->windows()->create([
            'type' => $request->type,
            'length' => $request->length,
            'width' => $request->width,
            'quantity' => $request->quantity
        ]);

        if ($request->type === 'window') {
            $window_area = $window->length * $window->width * $window->quantity;
            $room->update([
                'wall_area' => $room->wall_area - $window_area
            ]);
        }
        if ($request->type === 'door') {
            $door_area = $window->length * $window->width * $window->quantity;
            $door_width = $request->width;
            $room->update([
                'wall_area' => $room->wall_area - $door_area,
                // 'perimeter' => $room->perimeter - $door_width
                'perimeter' => $room->perimeter
            ]);
        }

    }

    public function update(Order $order, Room $room, Window $window, Request $request)
    {
        if ($request->length !== null && $request->width !== null && $request->quantity !== null) {
            $window->update([
                'room_id' => $room->id,
                'length' => $request->length,
                'width' => $request->width,
                'quantity' => $request->quantity
            ]);

            if ($this->windowArea($room) != 0) {
                $room->update([
                    'area' => $room->width * $room->length,
                    'perimeter' => $room->perimeter,
                    // 'perimeter' => $perimeter = 2 * ($room->length + $room->width),
                    'wall_area' => $room->perimeter * $room->height - $this->windowArea($room)
                ]);
            } else {
                $room->update([
                    'area' => $room->width * $room->length,
                    'perimeter' => $room->perimeter,
                    // 'perimeter' => $perimeter = 2 * ($room->length + $room->width),
                    'wall_area' => $room->perimeter * $room->height
                ]);
            }

            return response()->json(['successfully updated']);
        }
    }

    public function destroy(Order $order, Room $room, Window $window)
    {
        $window->delete();

        if ($this->windowArea($room) != 0) {
            $room->update([
                'area' => $room->width * $room->length,
                'perimeter' => $room->perimeter,
                'wall_area' => $room->perimeter * $room->height - $this->windowArea($room)
            ]);
        } else {
            $room->update([
                'area' => $room->width * $room->length,
                'perimeter' => $room->perimeter,
                'wall_area' => $room->perimeter * $room->height
            ]);
        }
    }


    protected function windowArea(Room $room)
    {
        $windows_area = 0;

        foreach ($room->windows as $window) {
            $windows_area += $window->length * $window->width * $window->quantity;
        }

        return $windows_area;
    }
}
