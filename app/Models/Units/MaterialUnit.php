<?php

namespace App\Models\Units;

use App\Models\Materials\Material;
use Illuminate\Database\Eloquent\Model;

class MaterialUnit extends Model
{
    protected $guarded = [];

    public $timestamps = false;

    public function materials()
    {
        return $this->hasMany(Material::class);
    }
}
