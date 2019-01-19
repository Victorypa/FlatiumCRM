<?php

namespace App\Models\Orders\Financial;

use App\Models\Orders\Order;
use Illuminate\Database\Eloquent\Model;
use App\Models\Orders\Financial\FinanceFile;

class Finance extends Model
{
    protected $guarded = [];

    public $timestamps = false;

    protected $dates = ['inputed_at'];

    public function finance_files()
    {
        return $this->hasMany(FinanceFile::class);
    }

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
