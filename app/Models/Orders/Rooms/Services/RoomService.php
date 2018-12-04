<?php

namespace App\Models\Orders\Rooms\Services;

use App\Models\Orders\Rooms\Room;
use App\Models\Materials\Material;
use App\Models\Services\ServiceType;
use Illuminate\Database\Eloquent\Model;

class RoomService extends Model
{
    protected $guarded = [];

    protected $with = ['service_type'];

    public function room()
    {
        return $this->belongsTo(Room::class);
    }

    public function materials()
    {
        return $this->belongsToMany(Material::class, 'room_service_material')->withPivot('rate');
    }

    public function service_type()
    {
        return $this->belongsTo(ServiceType::class);
    }
}
