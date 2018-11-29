<?php

namespace App\Http\Controllers\Api\Orders\Acts\Rooms\Services\Materials;

use Illuminate\Http\Request;
use App\Models\Orders\Order;
use App\Models\Services\Service;
use App\Models\Materials\Material;
use App\Http\Controllers\Controller;
use App\Models\Orders\Acts\ExtraOrderAct;
use App\Models\Orders\Acts\Rooms\ExtraRoom;
use App\Models\Orders\Acts\Rooms\Services\ExtraRoomService;

class ExtraRoomServiceMaterialController extends Controller
{
    public function index(Order $order, ExtraOrderAct $extra_order_act, ExtraRoom $extra_room, Service $service)
    {
        $service_material_ids = [];
        $service_material_rates = [];

        $extra_room_service = ExtraRoomService::where([['extra_room_id', $extra_room->id], ['service_id', $service->id]])->first();

         if ($service->materials->count() !== 0 && $extra_room_service->materials->count() === 0) {
             foreach ($service->materials as $material) {
                 array_push($service_material_ids, $material->id);
                 $service_material_rates[$material->id] = $material->pivot->rate;
             }

             $extra_room_service->materials()->sync($service_material_ids);

             foreach ($service_material_rates as $id => $rate) {
                $extra_room_service->materials()->updateExistingPivot($id, [
                    'rate' => $rate
                ]);
            }
         }

        return response()->json([
            'actual_service_materials' => $extra_room_service->materials()->with(['material_unit'])->get(),
            'room' => $extra_room
        ]);
    }

    public function store(Order $order, ExtraOrderAct $extra_order_act, ExtraRoom $extra_room, Service $service, Request $request)
    {
        $extra_room_service = ExtraRoomService::where([['extra_room_id', $extra_room->id], ['service_id', $service->id]])->first();

        $extra_room_service->materials()->sync($request->service_material_ids);

        foreach ($request->service_material_quantities as $id => $quantity) {
            Material::find($id)->update([
                'quantity' => $quantity,
            ]);
        }

        foreach ($request->service_material_rates as $id => $rate) {
            $extra_room_service->materials()->updateExistingPivot($id, [
                'rate' => $rate
            ]);
        }
    }
}
