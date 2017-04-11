<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Busstopsprice extends Model
{
    protected $fillable = [
        'busstops_id', 'price_key', 'price_value', 'number_key', 'number_value', 'duration_key', 'duration_value'
    ];
}