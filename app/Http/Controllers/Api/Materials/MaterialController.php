<?php

namespace App\Http\Controllers\Api\Materials;

use DB;
use Illuminate\Http\Request;
use App\Models\Services\Service;
use App\Models\Materials\Material;
use App\Http\Controllers\Controller;

class MaterialController extends Controller
{
    public function search(Request $request)
    {
        $query = $request->searchQuery;

        $materials = Material::whereRaw('LOWER(name) LIKE LOWER(?)', ["%" . $query . "%"])
                            ->orderBy('name', 'asc')
                            ->take(100)
                            ->get();

        return response()->json([
            'materials' => $materials,
            'searchQuery' => $query
        ]);
    }

    public function store(Request $request)
    {
        $service = Service::where('id', $request->service_id)->first();

        $material = Material::create([
            'material_unit_id' => $request->material_unit_id,
            'name' => $request->name,
            'price' => $price = $request->price,
            'quantity' => $quantity = (float) $request->quantity,
            'univalence' => number_format((float)($price / $quantity), 2, '.', ''),
            'can_be_deleted' => true
        ]);

        $service->materials()->syncWithoutDetaching(
            [$material->id => ['rate' => $request->rate]]
        );

        return response()->json([
            'message' => 'created successfully'
        ]);
    }

    public function update(Material $material, Request $request)
    {
        return $material->update($request->all());
    }

    public function destroy(Material $material)
    {
        if ($material->can_be_deleted) {
            $material->delete();
        } else {
            return response()->json([
                'message' => 'you cannot delete it '
            ]);
        }
    }
}
