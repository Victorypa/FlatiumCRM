<?php

namespace App\Http\Controllers\Api\Orders\Financial;

use App\Models\Orders\Order;
use Illuminate\Http\Request;
use App\Models\Orders\Financial\Finance;
use App\Http\Controllers\Controller;

class FinanceController extends Controller
{
    public function index(Order $order)
    {
      return $order->finances()->get();
    }

    public function store(Order $order, Request $request)
    {
        $order->finances()->create([
            'finance_type' => $request->type,
            'price' => $request->income,
            'reason' => $request->income_reason,
            'inputed_at' => strtotime($request->income_date)
        ]);
    }

    public function update(Order $order, Finance $finance, Request $request)
    {
        $finance->update([
          'can_be_showed' => $request->can_be_showed
        ]);
    }

    public function destroy(Order $order, Finance $finance)
    {
        $finance->delete();
    }
}
