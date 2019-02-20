<?php

namespace App\Models\Orders\Acts\Rooms;

use App\Models\Services\Service;
use App\Models\Orders\Rooms\Room;
use Illuminate\Database\Eloquent\Model;
use App\Models\Orders\Acts\FinishedOrderAct;
use App\Models\Orders\Acts\Rooms\Services\FinishedRoomService;

class FinishedRoom extends Model
{
    protected $guarded = [];

    public function FinishedOrderAct()
    {
        return $this->belongsTo(FinishedOrderAct::class);
    }

    public function room()
    {
        return $this->belongsTo(Room::class);
    }

    public function finished_room_services()
    {
        return $this->hasMany(FinishedRoomService::class);
    }
}
