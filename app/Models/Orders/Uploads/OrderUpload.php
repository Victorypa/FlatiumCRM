<?php

namespace App\Models\Orders\Uploads;

use App\Models\Orders\Order;
use Illuminate\Database\Eloquent\Model;

class OrderUpload extends Model
{
    protected $guarded = [];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
