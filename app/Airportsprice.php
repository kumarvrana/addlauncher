<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Airportsprice extends Model
{
    protected $fillable = [
        'airports_id', 'price_key', 'price_value'
    ];
}