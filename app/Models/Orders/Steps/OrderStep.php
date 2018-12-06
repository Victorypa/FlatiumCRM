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
            $order_step->color = $order_step->randomHexColorGeneration()['color'];
            $order_step->opacity_color = $order_step->randomHexColorGeneration()['opacity_color'];
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
        $colors = [
            '#ff7979' => 'rgba(255, 121, 121, 0.1)',
            '#badc58' => 'rgba(186, 220, 88, 0.1)',
            '#f0932b' => 'rgba(240, 147, 43, 0.1)',
            '#eb4d4b' => 'rgba(235, 77, 75, 0.1)',
            '#6ab04c' => 'rgba(106, 176, 76, 0.1)',
            '#7ed6df' => 'rgba(126, 214, 223, 0.1)',
            '#e056fd' => 'rgba(224, 86, 253, 0.1)',
            '#686de0' => 'rgba(104, 109, 224, 0.1)',
            '#30336b' => 'rgba(48, 51, 107, 0.1)',
            '#be2edd' => 'rgba(190, 46, 221, 0.1)',
            '#22a6b3' => 'rgba(34, 166, 179, 0.1)',
            '#4834d4' => 'rgba(72, 52, 212, 0.1)'

        ];

        return [
            'color' => array_rand($colors),
            'opacity_color' => $colors[array_rand($colors)]
        ];
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
