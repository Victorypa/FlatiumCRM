<?php

namespace App\Models\Orders\Acts\Rooms\Windows;

use Illuminate\Database\Eloquent\Model;
use App\Models\Orders\Acts\Rooms\ExtraRoom;

class ExtraRoomWindow extends Model
{
    protected $guarded = [];

    public function extra_room()
    {
        return $this->belongsTo(ExtraRoom::class);
    }
}
