<?php

namespace App\Models\Orders\Financial;

use Illuminate\Database\Eloquent\Model;
use App\Models\Orders\Financial\Finance;

class Profit extends Model
{
    protected $guarded = [];

    public function finance()
    {
        return $this->belongsTo(Finance::class);
    }
}
