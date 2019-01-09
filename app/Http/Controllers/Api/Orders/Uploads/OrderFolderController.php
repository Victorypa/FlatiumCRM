<?php

namespace App\Http\Controllers\Api\Orders\Uploads;

use Storage;
use App\Models\Orders\Order;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Orders\Uploads\Folder;

class OrderFolderController extends Controller
{
    public function index(Order $order)
    {
        return Folder::where('order_id', $order->id)
                    ->with(['order_uploads'])
                    ->get();
    }

    public function store(Order $order, Request $request)
    {
        Folder::create([
            'name' => $folderName = $request->date
        ]);

        Storage::disk('local')->makeDirectory("app/public/{$folderName}");
    }
}
