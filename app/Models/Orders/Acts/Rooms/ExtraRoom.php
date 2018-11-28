<?php

namespace App\Models\Orders\Acts\Rooms;

use App\Models\Orders\Rooms\Room;
use Illuminate\Database\Eloquent\Model;
use App\Models\Orders\Acts\ExtraOrderAct;
use App\Models\Orders\Acts\Rooms\Windows\ExtraRoomWindow;
use App\Models\Orders\Acts\Rooms\Services\ExtraRoomService;

class ExtraRoom extends Model
{
    protected $guarded = [];

    public function ExtraOrderAct()
    {
        return $this->belongsTo(ExtraOrderAct::class);
    }

    public function extra_windows()
    {
        return $this->hasMany(ExtraRoomWindow::class);
    }

    public function room()
    {
        return $this->belongsTo(Room::class);
    }

    public function extra_room_services()
    {
        return $this->hasMany(ExtraRoomService::class);
    }
}
