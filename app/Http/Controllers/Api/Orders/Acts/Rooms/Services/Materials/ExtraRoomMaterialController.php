<?php

namespace App\Http\Controllers\Api\Orders\Acts\Rooms\Services\Materials;

use App\Models\Orders\Order;
use Illuminate\Http\Request;
use App\Models\Materials\Material;
use App\Http\Controllers\Controller;
use App\Models\Orders\Acts\ExtraOrderAct;
use App\Models\Orders\Acts\Rooms\ExtraRoom;

class ExtraRoomMaterialController extends Controller
{
    public function index(Order $order, ExtraOrderAct $extra_order_act, ExtraRoom $extra_room)
    {
        return response()->json([
            'extra_room_materials' => $extra_room->extra_materials()->with(['material_unit'])->get(),
            'extra_room' => $extra_room
        ]);
    }

    public function store(Order $order, ExtraOrderAct $extra_order_act, ExtraRoom $extra_room, Request $request)
    {
        $extra_room->extra_materials()->sync($request->extra_room_material_ids);

        foreach ($request->extra_room_material_quantities as $id => $quantity) {
            Material::find($id)->update([
                'quantity' => $quantity,
            ]);
        }

        foreach ($request->extra_room_material_rates as $id => $rate) {
            $extra_room->extra_materials()->updateExistingPivot($id, [
                'service_id' => $request->service_id,
                'rate' => $rate
            ]);
        }
    }
}
