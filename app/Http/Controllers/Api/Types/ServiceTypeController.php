<?php

namespace App\Http\Controllers\Api\Types;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Services\ServiceType;

class ServiceTypeController extends Controller
{
    public function index()
    {
        return ServiceType::get();
    }
}
