<?php

namespace App\Http\Controllers\Api\Services;

use Illuminate\Http\Request;
use App\Models\Services\Service;
use App\Http\Controllers\Controller;

class ServiceController extends Controller
{
    public function index()
    {
        $services = Service::orderBy('name', 'asc')->with(['unit', 'materials', 'service_type'])->get();

        return response()->json($services);
    }

    public function show(Service $service)
    {
        $filteredService = Service::where('id', $service->id)->with(['materials'])->first();

        return $filteredService;
    }

    public function store(Request $request)
    {
        $service = Service::create([
            'service_type_id' => $request->service_type_id,
            'name' => $request->name,
            'unit_id' => $request->unit_id,
            'price' => $request->price,
            'can_be_deleted' => true,
            'can_be_discounted' => $request->can_be_discounted
        ]);

        return $service;
    }

    public function update(Service $service, Request $request)
    {
        $service->update([
            'name' => $request->name,
            'price' => $request->price
        ]);

        return $service;
    }

    public function destroy(Service $service)
    {
        if ($service->can_be_deleted) {
            $service->delete();
        } else {
            return response()->json([
                'message' => 'you cannot delete it '
            ]);
        }
    }
}
