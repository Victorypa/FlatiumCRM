<?php

namespace App\Http\Controllers\Api\Orders\Rooms\Services;

use Illuminate\Http\Request;
use App\Models\Orders\Order;
use App\Models\Orders\Rooms\Room;
use App\Models\Services\Service;
use App\Http\Controllers\Controller;
use App\Models\Orders\Rooms\Services\RoomService;

class RoomServiceController extends Controller
{
    public function index(Order $order, Room $room, Request $request)
    {
        return RoomService::where('room_id', $room->id)->get();
    }

    public function show(Order $order, Room $room, Service $service, Request $request)
    {
        return RoomService::where([
            ['room_id', $room->id],
            ['service_id', $service->id]
        ])->first();
    }

    public function store(Order $order, Room $room, Request $request)
    {
        $room->room_services()->create($request->all());

        $room->calculateRoomPrice($room);

        return response()->json([
            $room
        ]);
    }

    public function update(Order $order, Room $room, Service $service, Request $request)
    {
        $room_service = $room->room_services()->where('service_id', $service->id)->update($request->all());

        if ($request->has('markup')) {
            return response("markup exists", 200);
        }

        $room->calculateRoomPrice($room);
    }

    public function destroy(Order $order, Room $room, Service $service)
    {
        $room_service = $room->room_services()->where('service_id', $service->id)->delete();

        if ($room_service) {
            return response('deleted service', 200);
        }
    }
}
