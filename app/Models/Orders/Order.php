<?php

namespace App\Models\Orders;

use App\User;
use App\Models\Personal\Manager;
use App\Models\Orders\Rooms\Room;
use App\Models\Orders\Steps\OrderStep;
use App\Models\Orders\Financial\Finance;
use App\Models\Traits\Orders\OrderCalculationTrait;
use Illuminate\Database\Eloquent\{Model, SoftDeletes};
use App\Models\Orders\Acts\{ExtraOrderAct, FinishedOrderAct};

class Order extends Model
{
    use SoftDeletes, OrderCalculationTrait;

    protected $guarded = [];

    public $timestamps = false;

    protected $dates = ['deleted_at', 'finish_at', 'created_at', 'updated_at'];

    public function order_steps()
    {
        return $this->hasMany(OrderStep::class);
    }

    public function finished_order_acts()
    {
        return $this->hasMany(FinishedOrderAct::class)->orderBy('created_at', 'asc');
    }

    public function extra_order_acts()
    {
        return $this->hasMany(ExtraOrderAct::class)->orderBy('created_at', 'asc');
    }

    public function finances()
    {
        return $this->hasMany(Finance::class);
    }

    public function manager()
    {
        return $this->belongsTo(Manager::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function rooms()
    {
        return $this->hasMany(Room::class);
    }

    public function createFirstOrderStep()
    {
        if (count($this->order_steps) === 0) {
            $this->order_steps()->create([
                'name' => 'Спринт'
            ]);
        }
    }
}
