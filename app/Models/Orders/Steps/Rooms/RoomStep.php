<?php

namespace App\Models\Orders\Steps\Rooms;

use App\Models\Services\Service;
use App\Models\Orders\Rooms\Room;
use App\Models\Orders\Steps\OrderStep;
use Illuminate\Database\Eloquent\Model;

class RoomStep extends Model
{
    protected $guarded = [];

    public function order_step()
    {
        return $this->belongTo(OrderStep::class);
    }

    public function room()
    {
        return $this->belongsTo(Room::class);
    }

    public function services()
    {
        return $this->belongsToMany(Service::class, 'room_step_service')->withPivot('quantity', 'price');
    }
}
