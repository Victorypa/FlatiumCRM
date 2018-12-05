<?php

namespace App\Models\Orders\Steps;

use App\Models\Orders\Order;
use Illuminate\Database\Eloquent\Model;
use App\Models\Orders\Steps\Rooms\RoomStep;

class OrderStep extends Model
{
    protected $guarded = [];

    protected $dates = ['begin_at', 'finish_at'];

    protected $with = ['room_steps', 'order'];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($order_step) {
            $order_step->color = $order_step->randomHexColorGeneration();
        });

        static::created(function ($order_step) {
            $order_step->createRoomSteps($order_step);
        });

        static::deleting(function ($order_step) {
            $order_step->room_steps->each->delete();
        });
    }

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function room_steps()
    {
        return $this->hasMany(RoomStep::class);
    }

    protected function randomHexColorGeneration()
    {
        $rand = str_pad(dechex(rand(0x000000, 0xFFFFFF)), 6, 0, STR_PAD_LEFT);

        return "#{$rand}";
    }

    protected function createRoomSteps($order_step)
    {
        if (count($order_step->room_steps) === 0) {
            foreach ($order_step->order->rooms as $room) {
                $order_step->room_steps()->create([
                    'room_id' => $room->id
                ]);
            }
        }
    }
}
