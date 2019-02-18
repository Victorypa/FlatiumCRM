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
        return $room->room_services()->create($request->all());
    }

    public function update(Order $order, Room $room, Request $request)
    {
        foreach ($request->room_service_markups as $service_id => $markup) {
            $room_service = $room->room_services()->where('service_id', $service_id)->first();
            $room_service->markup = $markup;
            if ($room_service->markup !== null && $room_service->markup !== 0) {
                $room_service->original_price = $room_service->price * (1 + ((int)$markup/100));
            }
            $room_service->save();
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
