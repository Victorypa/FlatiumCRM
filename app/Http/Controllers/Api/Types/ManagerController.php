<?php

namespace App\Http\Controllers\Api\Types;

use App\Models\Personal\Manager;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ManagerController extends Controller
{
    public function index()
    {
        return Manager::get();
    }
}
