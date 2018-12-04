<?php

namespace App\Models\Orders\Steps;

use App\Models\Orders\Order;
use Illuminate\Database\Eloquent\Model;
use App\Models\Orders\Steps\Rooms\RoomStep;

class OrderStep extends Model
{
    protected $guarded = [];

    protected $dates = ['begin_at', 'finish_at'];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($order_step) {
            $order_step->color = $order_step->randomHexColorGeneration();
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
}
