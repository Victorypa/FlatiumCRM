<?php

namespace App\Models\Services;

use App\Models\Units\Unit;
use App\Models\Orders\Rooms\Room;
use App\Models\Materials\Material;
use App\Models\Services\ServiceType;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    protected $guarded = [];

    public $timestamps = false;

    public static function boot()
    {
        parent::boot();

        static::deleting(function($service) {
            $service->materials()->detach();
            $service->rooms()->detach();
        });

    }

    public function service_type()
    {
        return $this->belongsTo(ServiceType::class);
    }

    public function unit()
    {
        return $this->belongsTo(Unit::class);
    }

    public function rooms()
    {
        return $this->belongsToMany(Room::class, 'room_service');
    }

    public function materials()
    {
        return $this->belongsToMany(Material::class, 'service_material')->withPivot('rate');
    }

    public function actual_materials()
    {
        return $this->belongsToMany(Material::class, 'actual_service_material')->withPivot('rate');
    }
}
