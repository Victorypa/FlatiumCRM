<?php

namespace App\Models\Orders\Steps;

use App\Models\Orders\Order;
use Illuminate\Database\Eloquent\Model;
use App\Models\Orders\Steps\Rooms\RoomStep;

class OrderStep extends Model
{
    protected $guarded = [];

    protected $dates = ['begin_at', 'finish_at'];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function room_steps()
    {
        return $this->hasMany(RoomStep::class);
    }
}
