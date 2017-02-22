<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Carsprice extends Model
{
    protected $fillable = [
        'cars_id', 'price_key', 'price_value'
    ];
}