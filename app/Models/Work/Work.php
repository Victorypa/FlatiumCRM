<?php

namespace App\Models\Work;

use App\Models\Orders\Rooms\Room;
use Illuminate\Database\Eloquent\Model;

class Work extends Model
{
    protected $fillable = [
        'name'
    ];

    public $timestamps = false;

    public function rooms()
    {
        return $this->belongsToMany(Room::class, 'room_work');
    }
}
