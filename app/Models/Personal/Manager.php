<?php

namespace App\Models\Personal;

use Illuminate\Database\Eloquent\Model;

class Manager extends Model
{
    protected $fillable = [
        'name', 'phone'
    ];

    public $timestamps = false;
}
