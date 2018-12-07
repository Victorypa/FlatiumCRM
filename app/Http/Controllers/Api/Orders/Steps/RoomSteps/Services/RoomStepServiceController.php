<?php

namespace App\Http\Controllers\Api\Orders\Steps\RoomSteps\Services;

use Illuminate\Http\Request;
use App\Models\Orders\Order;
use App\Http\Controllers\Controller;
use App\Models\Orders\Steps\OrderStep;

class RoomStepServiceController extends Controller
{
    public function index(Order $order, OrderStep $order_step)
    {

    }

    public function store(Order $order, OrderStep $order_step, Request $request)
    {
        
    }
}
