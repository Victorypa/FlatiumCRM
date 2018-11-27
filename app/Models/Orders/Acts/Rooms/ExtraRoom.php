<?php

namespace App\Models\Orders\Acts\Rooms;

use App\Models\Services\Service;
use App\Models\Orders\Rooms\Room;
use App\Models\Materials\Material;
use Illuminate\Database\Eloquent\Model;
use App\Models\Orders\Acts\ExtraOrderAct;
use App\Models\Orders\Acts\Rooms\Windows\ExtraRoomWindow;

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

    public function extra_services()
    {
        return $this->belongsToMany(Service::class, 'room_extra_service')->withPivot('quantity', 'price');
    }
}
