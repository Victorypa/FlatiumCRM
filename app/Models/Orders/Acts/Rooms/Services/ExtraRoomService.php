<?php

namespace App\Models\Orders\Acts\Rooms\Services;

use App\Models\Materials\Material;
use Illuminate\Database\Eloquent\Model;
use App\Models\Orders\Acts\Rooms\ExtraRoom;

class ExtraRoomService extends Model
{
    protected $guarded = [];

    public function room()
    {
        return $this->belongsTo(ExtraRoom::class);
    }

    public function materials()
    {
        return $this->belongsToMany(Material::class, 'extra_room_service_material')->withPivot('rate');
    }
}
