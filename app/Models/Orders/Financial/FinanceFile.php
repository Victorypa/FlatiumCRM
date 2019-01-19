<?php

namespace App\Models\Orders\Financial;

use App\Models\Orders\Financial\Finance;
use Illuminate\Database\Eloquent\Model;

class FinanceFile extends Model
{
    protected $guarded = [];
    
    public function finance()
    {
        return $this->belongsTo(Finance::class);
    }
}
