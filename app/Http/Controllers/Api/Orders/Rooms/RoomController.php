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

        return Room::where('id', $room->id)->with(['windows', 'order.rooms', 'room_services', 'room_services.materials'])->first();
    }

    public function store(Order $order, Request $request)
    {
        return $order->rooms()->create($request->all());
    }

    public function update(Order $order, Room $room, Request $request)
    {
      if ($request->has('width') && $request->has('length')) {
        $room->update([
          'width' => $width = $request->width,
          'length' => $length = $request->length,
          'area' => $width * $length,
        ]);
      }

      if ($request->has('height')) {
        $room->update([
          'height' => $request->height
        ]);
      }

      if ($request->has('area')) {
        $room->update([
          'area' => $request->width * $request->length,
        ]);
      }

      if ($request->has('perimeter')) {
        $room->update([
          'perimeter' => $request->perimeter,
        ]);
      }

      if ($request->has('wall_area')) {
        $room->update([
          'wall_area' => $request->wall_area,
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
