<?php

namespace App\Http\Controllers\Api\Orders\Rooms\Services\Materials;

use App\Models\Orders\Order;
use Illuminate\Http\Request;
use App\Models\Orders\Rooms\Room;
use App\Models\Materials\Material;
use App\Models\Services\Service;
use App\Http\Controllers\Controller;

class ActualServiceMaterialController extends Controller
{
    public function index(Order $order, Room $room, Service $service)
    {
        $service_material_ids = [];
        $service_material_rates = [];

        if ($service->materials->count() !== 0 && $service->actual_materials->count() === 0) {
            foreach ($service->materials as $material) {
                array_push($service_material_ids, $material->id);
                $service_material_rates[$material->id] = $material->pivot->rate;
            }
            $service->actual_materials()->sync($service_material_ids);

            foreach ($service_material_rates as $id => $rate) {
                $service->actual_materials()->updateExistingPivot($id, [
                    'rate' => $rate
                ]);
            }
        }

        return response()->json([
            'actual_service_materials' => $service->actual_materials()->with(['material_unit'])->get(),
            'room' => $room
        ]);
    }

    public function store(Order $order, Room $room, Service $service, Request $request)
    {

        $service->actual_materials()->sync($request->service_material_ids);

        foreach ($request->service_material_quantities as $id => $quantity) {
            Material::find($id)->update([
                'quantity' => $quantity,
            ]);
        }

        foreach ($request->service_material_rates as $id => $rate) {
            $service->actual_materials()->updateExistingPivot($id, [
                'rate' => $rate
            ]);
        }
    }
}
