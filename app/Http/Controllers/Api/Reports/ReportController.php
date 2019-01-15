<?php

namespace App\Http\Controllers\Api\Reports;

use App\Models\Orders\Order;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ReportController extends Controller
{
    public function index()
    {
        return Order::with([
          'manager', 'rooms.room_services', 'rooms.room_services.materials',
          'finances', 'finished_order_acts'
        ])->get();
    }
}
