<?php

namespace App\Http\Controllers\Api\Services;

use App\Models\RoomType;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class RoomTypeController extends Controller
{
    public function index()
    {
        return RoomType::get();
    }
}
