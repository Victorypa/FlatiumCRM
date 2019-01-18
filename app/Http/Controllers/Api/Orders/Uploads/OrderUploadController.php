<?php

namespace App\Http\Controllers\Api\Orders\Uploads;

use Storage;
use App\Models\Orders\Order;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Orders\Uploads\Folder;
use App\Models\Orders\Uploads\OrderUpload;

class OrderUploadController extends Controller
{
    protected $imageExtensions = ['gif', 'jpg', 'jpeg', 'png', 'flv', 'pjpeg'];

    public function index(Order $order, Folder $folder)
    {
      return OrderUpload::where('folder_id', $folder->id)->with(['folder'])->get();
    }

    public function store(Order $order, Request $request)
    {
        $folder = Folder::orderBy('created_at', 'desc')->first();

        if ($request->hasFile('uploadedFile')) {

            if (in_array($request->file('uploadedFile')->getClientOriginalExtension(), $this->imageExtensions)) {
                Storage::putFileAs(
                    "/public/{$folder->name}/photos",
                    $request->file('uploadedFile'),
                    $fileName = $request->file('uploadedFile')->getClientOriginalName()
                );

                $folder->order_uploads()->create([
                    'path' => $fileName,
                    'type' => 'photo'
                ]);
            } else {
                Storage::putFileAs(
                    "/public/{$folder->name}/docs",
                    $request->file('uploadedFile'),
                    $fileName = $request->file('uploadedFile')->getClientOriginalName()
                );

                $folder->order_uploads()->create([
                    'path' => $fileName,
                    'type' => 'doc'
                ]);
            }

        }
    }
}
