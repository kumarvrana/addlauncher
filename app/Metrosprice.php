<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Metrosprice extends Model
{
    protected $fillable = [
        'metros_id', 'price_key', 'price_value', 'number_key', 'number_value', 'duration_key', 'duration_value'
    ];
}