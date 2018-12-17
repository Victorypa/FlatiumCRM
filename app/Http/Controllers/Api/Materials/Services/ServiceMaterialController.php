<?php

namespace App\Http\Controllers\Api\Materials\Services;

use Illuminate\Http\Request;
use App\Models\Services\Service;
use App\Models\Materials\Material;
use App\Http\Controllers\Controller;

class ServiceMaterialController extends Controller
{
    public function index(Service $service)
    {
        return response()->json([
            'service_materials' => $service->materials()->get(),
            'service' => $service
        ]);
    }

    public function store(Service $service, Request $request)
    {
        $service->materials()->sync($request->service_material_ids);

        foreach ($request->service_material_quantities as $id => $quantity) {
            Material::find($id)->update([
                'quantity' => $quantity,
            ]);
        }

        foreach ($request->service_material_rates as $id => $rate) {
            $service->materials()->updateExistingPivot($id, [
                'rate' => $rate
            ]);
        }
    }
}
