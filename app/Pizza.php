<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pizza extends Model
{
    protected $guarded = [];

    public function orders()
    {
        return $this->belongsToMany(Order::class);
    }

    public function dollarCurrency()
    {
        $rate = 114.40;
        
        return $this->price * number_format($rate / 100, 2);
    }
}
