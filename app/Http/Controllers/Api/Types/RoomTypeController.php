<?php

namespace App\Http\Controllers\Api\Types;

use App\Models\Types\RoomType;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class RoomTypeController extends Controller
{
    public function index()
    {
        return RoomType::get();
    }
}
