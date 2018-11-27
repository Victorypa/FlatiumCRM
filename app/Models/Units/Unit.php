<?php

namespace App\Models\Units;

use Illuminate\Database\Eloquent\Model;

class Unit extends Model
{
    protected $fillable = [
        'name'
    ];

    public $timestamps = false;
}
