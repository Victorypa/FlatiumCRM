<?php

namespace App\Models\Types;

use Illuminate\Database\Eloquent\Model;

class RoomType extends Model
{
    protected $fillable = [
        'type'
    ];

    public $timestamps = false;

    public function rooms()
    {
        return $this->hasMany(Room::class);
    }
}
