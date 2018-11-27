<?php

namespace App\Http\Controllers\Api\Materials;

use DB;
use Illuminate\Http\Request;
use App\Models\Services\Service;
use App\Models\Materials\Material;
use App\Http\Controllers\Controller;

class MaterialController extends Controller
{
    public function index()
    {
        $materials = Material::orderBy('name', 'asc')->with(['material_unit'])->get();

        return $materials;
    }

    public function search(Request $request)
    {
        $query = $request->searchQuery;

        $materials = Material::whereRaw('LOWER(name) LIKE LOWER(?)', ["%" . $query . "%"])
                            ->orderBy('name', 'asc')
                            ->with(['material_unit'])
                            ->take(100)
                            ->get();

        return response()->json([
            'materials' => $materials,
            'searchQuery' => $query
        ]);
    }

    public function store(Request $request)
    {
        $service = Service::where('id', $request->service['id'])->first();

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

    public function destroy(Material $material)
    {
        if ($material->can_be_deleted) {
            $material->services()->detach();

            $material->delete();
        } else {
            return response()->json([
                'message' => 'you cannot delete it '
            ]);
        }
    }
}
