<?php

namespace App\Models\Materials;

use App\Models\Services\Service;
use App\Models\Units\MaterialUnit;
use Illuminate\Database\Eloquent\Model;

class Material extends Model
{
    protected $guarded = [];

    public $timestamps = false;

    protected $with = ['material_unit'];

    public static function boot()
    {
        static::updating(function($material) {
            $material->univalence = $material->calculateUnivalence($material);
        });

        static::deleting(function($material) {
            $material->services()->detach();
        });
    }

    public function material_unit()
    {
        return $this->belongsTo(MaterialUnit::class);
    }

    public function services()
    {
        return $this->belongsToMany(Service::class, 'service_material');
    }

    protected function calculateUnivalence($material)
    {
        $amount =  $material->price / $material->quantity;

        return number_format((float)($amount), 2, '.', '');
    }
}
