<?php

namespace App\Models\Orders\Steps\Rooms;

use App\Models\Services\Service;
use App\Models\Orders\Rooms\Room;
use App\Models\Orders\Steps\OrderStep;
use Illuminate\Database\Eloquent\Model;

class RoomStep extends Model
{
    protected $guarded = [];

    protected $with = ['room', 'services'];

    protected static function boot()
    {
        parent::boot();

        static::deleted(function ($room_step) {
            $room_step->services()->detach();
        });
    }

    public function order_step()
    {
        return $this->belongsTo(OrderStep::class);
    }

    public function room()
    {
        return $this->belongsTo(Room::class);
    }

    public function services()
    {
        return $this->belongsToMany(Service::class, 'room_step_service')->withPivot('service_type_id', 'service_unit_id', 'quantity', 'price');
    }
}
