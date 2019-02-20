<?php

namespace App\Models\Orders\Acts\Rooms\Services;

use App\Models\Units\Unit;
use App\Models\Services\Service;
use App\Models\Services\ServiceType;
use Illuminate\Database\Eloquent\Model;
use App\Models\Orders\Acts\Rooms\FinishedRoom;

class FinishedRoomService extends Model
{
    protected $guarded = [];

    protected $with = ['service', 'service_type', 'unit'];

    public function finished_room()
    {
        return $this->belongsTo(FinishedRoom::class);
    }

    public function service_type()
    {
        return $this->belongsTo(ServiceType::class);
    }

    public function service()
    {
        return $this->belongsTo(Service::class);
    }

    public function unit()
    {
        return $this->belongsTo(Unit::class, 'service_unit_id');
    }
}
