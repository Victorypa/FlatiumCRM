<?php

namespace App\Http\Controllers\Api\Types;

use App\Models\Units\MaterialUnit;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class MaterialUnitController extends Controller
{
    public function index()
    {
        return MaterialUnit::get();
    }
}
