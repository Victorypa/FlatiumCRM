<?php

namespace App\Models\Orders\Rooms\Windows;

use App\Models\Orders\Rooms\Room;
use Illuminate\Database\Eloquent\Model;

class Window extends Model
{
    protected $guarded = [];

    public function room()
    {
        return $this->belongsTo(Room::class);
    }
}
