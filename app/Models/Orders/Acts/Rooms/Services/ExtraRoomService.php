<?php

namespace App\Models\Orders\Acts\Rooms\Services;

use App\Models\Units\Unit;
use App\Models\Services\ServiceType;
use App\Models\Materials\Material;
use Illuminate\Database\Eloquent\Model;
use App\Models\Services\Service;
use App\Models\Orders\Acts\Rooms\ExtraRoom;

class ExtraRoomService extends Model
{
    protected $guarded = [];

    protected $with = ['service', 'service_type', 'unit'];

    public function room()
    {
        return $this->belongsTo(ExtraRoom::class);
    }

    public function materials()
    {
        return $this->belongsToMany(Material::class, 'extra_room_service_material')->withPivot('rate');
    }

    public function service()
    {
        return $this->belongsTo(Service::class);
    }

    public function service_type()
    {
        return $this->belongsTo(ServiceType::class);
    }

    public function unit()
    {
        return $this->belongsTo(Unit::class, 'service_unit_id');
    }
}
