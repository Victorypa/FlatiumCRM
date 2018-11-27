<?php

namespace App\Http\Controllers\Api\Orders\Acts\Rooms\ExtraWindows;

use App\Models\Orders\Order;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Orders\Acts\ExtraOrderAct;
use App\Models\Orders\Acts\Rooms\ExtraRoom;
use App\Models\Orders\Acts\Rooms\Windows\ExtraRoomWindow;

class ExtraRoomExtraWindowController extends Controller
{
    public function index(Order $order, ExtraOrderAct $extra_order_act, ExtraRoom $extra_room)
    {
        return response()->json([
            $extra_room->extra_windows()->orderBy('type', 'asc')->get()
        ]);
    }

    public function store(Order $order, ExtraOrderAct $extra_order_act, ExtraRoom $extra_room, Request $request)
    {
            if ($request->length !== null && $request->width !== null && $request->quantity !== null) {
                $extra_window = $extra_room->extra_windows()->create([
                    'type' => $request->type,
                    'length' => $request->length,
                    'width' => $request->width,
                    'quantity' => $request->quantity
                ]);
            }

            if ($request->type = 'window') {
                $window_area = $extra_window->length * $extra_window->width * $extra_window->quantity;

                $extra_room->update([
                    'wall_area' => $extra_room->wall_area - $window_area
                ]);
            } else {
                $door_area = $extra_window->length * $extra_window->width * $extra_window->quantity;

                $door_width = $request->width;

                $extra_room->update([
                    'wall_area' => $extra_room->wall_area - $door_area,
                    'perimeter' => $extra_room->perimeter - $door_width
                ]);
            }

            // $this->RoomServicesPricesCalculation($room);

    }

    public function update(Order $order, ExtraOrderAct $extra_order_act, ExtraRoom $extra_room, ExtraRoomWindow $extra_room_window, Request $request)
    {
        if ($request->length !== null && $request->width !== null && $request->quantity !== null) {
            $extra_room_window->update([
                'extra_room_id' => $extra_room->id,
                'length' => (float) $request->length,
                'width' => (float) $request->width,
                'quantity' => (float) $request->quantity
            ]);

            return response()->json(['successfully updated']);
        }

        // $this->RoomServicesPricesCalculation($room);
    }

    public function destroy(Order $order, ExtraOrderAct $extra_order_act, ExtraRoom $extra_room, ExtraRoomWindow $extra_room_window, Request $request)
    {
        $extra_room_window->delete();

        if ($this->windowArea($extra_room) != 0) {
            $extra_room->update([
                'area' => $extra_room->room->area,
                'perimeter' => $perimeter = $extra_room->room->perimeter,
                'wall_area' => $perimeter * $extra_room->room->height - $this->windowArea($extra_room)
            ]);
        } else {
            $extra_room->update([
                'area' => $extra_room->room->area,
                'perimeter' => $extra_room->room->perimeter,
                'wall_area' => $extra_room->room->wall_area
            ]);
        }

    }

    protected function windowArea(ExtraRoom $extra_room)
    {
        $windows_area = 0;

        foreach ($extra_room->extra_windows as $window) {
            $windows_area += $window->length * $window->width * $window->quantity;
        }

        return $windows_area;
    }
}
