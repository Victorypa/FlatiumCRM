<?php

namespace App\Models\Location;

use Illuminate\Database\Eloquent\Model;

class Street extends Model
{
    protected $fillable = ['name'];

    public $timestamps = false;
}
