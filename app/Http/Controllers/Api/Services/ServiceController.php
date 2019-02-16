<?php

namespace App\Http\Controllers\Api\Services;

use Illuminate\Http\Request;
use App\Models\Services\Service;
use App\Http\Controllers\Controller;

class ServiceController extends Controller
{
    public function index()
    {
        return response()->json(
            Service::orderBy('name', 'asc')->with(['materials'])->get()
        );
    }

    public function show(Service $service)
    {
        return Service::where('id', $service->id)->with(['materials'])->first();
    }

    public function store(Request $request)
    {
        return Service::create([
            'service_type_id' => $request->service_type_id,
            'name' => $request->name,
            'unit_id' => $request->unit_id,
            'price' => $request->price,
            'can_be_deleted' => true,
            'can_be_discounted' => $request->can_be_discounted
        ]);
    }

    public function update(Service $service, Request $request)
    {
        $service->update($request->all());

        return response('updated', 200);
    }

    public function destroy(Service $service)
    {
        if ($service->can_be_deleted) {
            $service->delete();

            return response()->json([
                'message' => 'you have deleted '
            ]);
        } else {
            return response()->json([
                'message' => 'you cannot delete it '
            ]);
        }
    }
}
