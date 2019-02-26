<?php

namespace App\Http\Controllers\Api\Orders\Rooms\Services\Materials;

use App\Models\Orders\Order;
use Illuminate\Http\Request;
use App\Models\Orders\Rooms\Room;
use App\Models\Materials\Material;
use App\Models\Services\Service;
use App\Http\Controllers\Controller;
use App\Models\Orders\Rooms\Services\RoomService;

class RoomServiceMaterialController extends Controller
{
    public function index(Order $order, Room $room, Service $service)
    {
        $room_service = RoomService::where([['room_id', $room->id], ['service_id', $service->id]])->first();

        return response()->json([
            'actual_service_materials' => $room_service->materials()->with(['material_unit'])->get(),
            'room' => $room
        ]);
    }

    public function store(Order $order, Room $room, Service $service, Request $request)
    {
        $room_service = RoomService::where([
            ['room_id', $room->id], ['service_id', $service->id]
        ])->first();

        $room_service->materials()->attach($request->material_id);

        $room_service->materials()->updateExistingPivot($request->material_id, [
                'rate' => $request->rate
            ]);

        return response('added material', 200);
    }

    public function remove(Order $order, Room $room, Service $service, Request $request)
    {
        $room_service = RoomService::where([
            ['room_id', $room->id], ['service_id', $service->id]
        ])->first();

        $room_service->materials()->detach($request->material_id);
    }
}
