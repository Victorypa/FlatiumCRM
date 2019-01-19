<?php

namespace App\Http\Controllers\Api\Orders\Financial;

use Storage;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Orders\Financial\Finance;
use App\Models\Orders\Order;

class FinanceFileController extends Controller
{
    public function store(Order $order, Request $request)
    {
        $finance = Finance::latest()->get();
    }
}
