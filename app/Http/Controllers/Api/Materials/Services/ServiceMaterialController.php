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
        return $service->materials()->get();
    }

    public function store(Service $service, Request $request)
    {
        $service->materials()->attach($request->material['id']);
    }

    public function remove(Service $service, Request $request)
    {
        $service->materials()->detach($request->material_id);
    }

    public function update(Service $service, Request $request)
    {
        $service->materials()->updateExistingPivot($request->material_id, [
            'rate' => $request->rate
        ]);
    }
}
