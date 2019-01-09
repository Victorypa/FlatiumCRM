<?php

namespace App\Http\Controllers\Api\Orders\Uploads;

use App\Models\Orders\Order;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Orders\Uploads\Folder;

class OrderUploadController extends Controller
{
    protected $imageExtensions = ['gif', 'jpg', 'jpeg', 'png', 'flv', 'pjpeg'];

    public function store(Order $order, Request $request)
    {
        $folder = Folder::orderBy('created_at', 'desc')->first();

        if ($request->hasFile('uploadedFile')) {
            if (in_array($request->file('uploadedFile')->getClientOriginalExtension(), $this->imageExtensions)) {
                $path = $request->file('uploadedFile')->store(
                    "app/public/{$folder->name}/photos", 'local'
                );
            } else {
                $path = $request->file('uploadedFile')->store(
                    "app/public/{$folder->name}/docs", 'local'
                );
            }

        }
    }
}
