<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Carsprice extends Model
{
    protected $fillable = [
        'cars_id', 'price_key', 'price_value', 'number_key', 'number_value', 'duration_key', 'duration_value', 'option_type'
    ];
}