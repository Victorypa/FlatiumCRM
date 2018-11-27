<?php

namespace App\Http\Controllers\Api\Orders\Rooms;

use App\Models\Orders\Order;
use Illuminate\Http\Request;
use App\Models\Orders\Rooms\Room;
use App\Models\Services\Service;
use App\Http\Controllers\Controller;

class RoomController extends Controller
{
    public function show(Order $order, Room $room)
    {
        $room->calculateRoomPrice($room);
        $room->calculateOrderPrice($room);

        $filterdRoom = Room::where('id', $room->id)
                       ->with([
                           'order', 'roomType',
                           'windows', 'order.rooms',
                           'room_services'
                           ])->first();

        return $filterdRoom;

    }

    public function store(Order $order, Request $request)
    {
        $room = $order->rooms()->create($request->all());

        return $room;
    }

    public function update(Order $order, Room $room, Request $request)
    {
        if ($room->windows->count()) {
            $window_area = 0;
            $door_length = 0;

            foreach ($room->windows as $window) {
                $window_area += (float) $window->length * (float) $window->width * (int) $window->quantity;
                if ($window->type === "door") {
                    $door_length += (float)$window->width;
                }
            }

            $room->update([
                'width' => $width = $request->width,
                'length' => $length = $request->length,
                'height' => $height = $request->height,
                'area' => $request->area,
                'perimeter' => $perimeter = 2 * ($width * $length) - $door_length,
                'wall_area' => $perimeter * $height - (float) $window_area,
            ]);

        } else {
            $room->update([
                'width' => $width = $request->width,
                'length' => $length = $request->length,
                'height' => $height = $request->height,
                'area' => $request->area,
                'perimeter' => $perimeter = $request->perimeter,
                'wall_area' => $perimeter * $height,
            ]);
        }
    }

    public function updateDescription(Order $order, Room $room, Request $request)
    {
        $room->update([
            'description' => $request->description
        ]);
    }

    public function destroy(Order $order, Room $room, Request $request)
    {
        $room->delete();

        if (count($room->order->rooms)) {
            $newRoom = $room->order->rooms->where('id', '!=', $room->id)->first();

            return response()->json(
                $newRoom
            );
        }
    }
}
