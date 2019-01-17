<?php

namespace App\Http\Controllers\Api\Orders\Uploads;

use Storage;
use App\Models\Orders\Order;
use App\Models\Orders\Uploads\Folder;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

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
        $order->folders()->create([
            'name' => $folderName = $request->date
        ]);

        Storage::disk('local')->makeDirectory("/public/{$folderName}");
    }

    public function destroy(Order $order, Folder $folder)
    {
        $folder->delete();
    }
}
