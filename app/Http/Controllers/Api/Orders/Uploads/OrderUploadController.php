<?php

namespace App\Http\Controllers\Api\Orders\Uploads;

use App\Models\Orders\Order;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class OrderUploadController extends Controller
{
    public function index(Order $order)
    {
        $filteredOrder = Order::where('id', $order->id)->with(['order_uploads'])->first();

        return $filteredOrder;
    }

    public function store(Order $order, Request $request)
    {
        if ($request->file('file')->isValid()) {
            dd($request->file->path(), $request->file->extension());
        }
        // $file = $request->file('file');
        // dd($file->getClientOriginalName);
        // dd($order);
    }
}
