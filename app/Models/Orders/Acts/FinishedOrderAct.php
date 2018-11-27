<?php

namespace App\Models\Orders\Acts;

use App\Models\Orders\Order;
use Illuminate\Database\Eloquent\Model;
use App\Models\Orders\Acts\Rooms\FinishedRoom;

class FinishedOrderAct extends Model
{
    protected $guarded = [];

    protected $dates = [
        'begin_at', 'finish_at'
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function finished_rooms()
    {
        return $this->hasMany(FinishedRoom::class);
    }
}
