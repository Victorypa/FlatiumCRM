<?php

namespace App\Models\Orders\Uploads;

use App\Models\Orders\Uploads\Folder;
use Illuminate\Database\Eloquent\Model;

class OrderUpload extends Model
{
    protected $guarded = [];

    public function folder()
    {
        return $this->belongsTo(Folder::class);
    }
}
