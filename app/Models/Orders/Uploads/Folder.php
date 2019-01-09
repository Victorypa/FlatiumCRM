<?php

namespace App\Models\Orders\Uploads;

use Illuminate\Database\Eloquent\Model;
use App\Models\Orders\Uploads\OrderUpload;

class Folder extends Model
{
    protected $guarded = [];

    public function order_uploads()
    {
        return $this->hasMany(OrderUpload::class);
    }
}
