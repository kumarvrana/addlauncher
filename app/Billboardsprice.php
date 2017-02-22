<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Billboardsprice extends Model
{
    protected $fillable = [
        'billboards_id', 'price_key', 'price_value'
    ];
}