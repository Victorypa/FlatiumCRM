<?php

namespace App\Http\Controllers\Api\Types;

use App\Models\Units\Unit;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UnitController extends Controller
{
    public function index()
    {
        return Unit::get();
    }
}
