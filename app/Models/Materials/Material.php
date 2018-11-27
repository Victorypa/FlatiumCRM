<?php

namespace App\Models\Materials;

use App\Models\Services\Service;
use App\Models\Units\MaterialUnit;
use Illuminate\Database\Eloquent\Model;

class Material extends Model
{
    protected $fillable = [
        'material_unit_id', 'univalence', 'can_be_deleted',
        'flat_id', 'name', 'number', 'price', 'quantity'
    ];

    public $timestamps = false;

    public static function boot()
    {
        static::updating(function($material) {
            $material->univalence = $material->calculateUnivalence($material);
        });

        static::deleting(function($material) {
            if ($material->can_be_deleted) {
                $material->services()->detach();
            }
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
