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

    // public function search(Order $order, Room $room, Service $service, Request $request)
    // {
    //     $query = $request->searchQuery;
    //
    //     $materials = $service->materials()->whereRaw('LOWER(name) LIKE LOWER(?)', ["%" . $query . "%"])
    //                         ->orderBy('name', 'asc')
    //                         ->take(100)
    //                         ->get();
    //
    //     return response()->json([
    //         'materials' => $materials,
    //         'searchQuery' => $query
    //     ]);
    // }

    public function store(Order $order, Room $room, Service $service, Request $request)
    {
        $room_service = RoomService::where([['room_id', $room->id], ['service_id', $service->id]])->first();

        $room_service->materials()->sync($request->service_material_ids);

        foreach ($request->service_material_quantities as $id => $quantity) {
            Material::find($id)->update([
                'quantity' => $quantity,
            ]);
        }

        foreach ($request->service_material_rates as $id => $rate) {
            $room_service->materials()->updateExistingPivot($id, [
                'rate' => $rate
            ]);
        }
    }
}
