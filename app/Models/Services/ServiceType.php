<?php

namespace App\Models\Services;

use App\Models\Services\Service;
use Illuminate\Database\Eloquent\Model;

class ServiceType extends Model
{
    protected $fillable = [
        'name'
    ];

    public $timestamps = false;

    public function services()
    {
        return $this->hasMany(Service::class);
    }
}
