<?php

namespace App\Models\Orders\Rooms;

use App\Models\Work\Work;
use App\Models\Orders\Order;
use Illuminate\Database\Eloquent\Model;
use App\Models\Orders\Rooms\Windows\Window;
use App\Models\Services\Service;
use App\Models\Services\Acts\ServiceAct;
use App\Models\Orders\Acts\Rooms\FinishedRoom;
use App\Models\Types\RoomType;
use App\Models\Materials\Material;
use App\Models\Orders\Rooms\Services\RoomService;
use App\Models\Traits\Rooms\{
    RoomCalculationTrait, RoomPriceCalculationTrait, RoomServiceTrait
};

class Room extends Model
{
    use RoomCalculationTrait, RoomPriceCalculationTrait, RoomServiceTrait;

    protected $guarded = [];

    protected $dates = ['deleted_at', 'finish_at'];

    protected $with = ['roomType', 'order'];

    public static function boot()
    {
        parent::boot();

        static::created(function($room) {
            $room->finished_rooms_automation($room, 'created');
            $room->extra_rooms_automation($room, 'created');
        });

        static::deleting(function($room) {
            $room->windows()->delete();
        });

        static::deleted(function ($room) {
            $room->addRoomPriceToOrder($room);
            $room->finished_rooms_automation($room, 'deleted');
            $room->extra_rooms_automation($room, 'deleted');
        });
    }

    public function room_services()
    {
        return $this->hasMany(RoomService::class);
    }

    public function finished_room()
    {
        return $this->hasMany(FinishedRoom::class);
    }

    public function windows()
    {
        return $this->hasMany(Window::class);
    }

    public function roomType()
    {
        return $this->belongsTo(RoomType::class);
    }

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function works()
    {
        return $this->belongsToMany(Work::class, 'room_work')
                    ->withPivot('begin_at', 'finish_at', 'begin_at_in_fact', 'finish_at_in_fact');
    }
}
