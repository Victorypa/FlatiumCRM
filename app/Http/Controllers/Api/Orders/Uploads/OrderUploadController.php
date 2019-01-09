<?php

namespace App\Http\Controllers\Api\Orders\Uploads;

use App\Models\Orders\Order;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class OrderUploadController extends Controller
{
    public function store(Order $order)
    {
        dd($order);
    }
}
