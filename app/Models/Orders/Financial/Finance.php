<?php

namespace App\Models\Orders\Financial;

use App\Models\Orders\Order;
use Illuminate\Database\Eloquent\Model;

class Finance extends Model
{
    protected $guarded = [];

    public $timestamps = false;

    protected $dates = ['inputed_at'];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
