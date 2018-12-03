<?php

namespace App\Models\Orders\Acts;

use App\Models\Orders\Order;
use Illuminate\Database\Eloquent\Model;
use App\Models\Orders\Acts\Rooms\ExtraRoom;

class ExtraOrderAct extends Model
{
    protected $guarded = [];

    protected $dates = ['begin_at', 'finish_at'];

    protected $with = ['extra_rooms', 'order'];

    public function extra_rooms()
    {
        return $this->hasMany(ExtraRoom::class);
    }

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
