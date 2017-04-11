<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Shoppingmallsprice extends Model
{
    protected $fillable = [
        'shoppingmalls_id', 'price_key', 'price_value', 'number_key', 'number_value', 'duration_key', 'duration_value'
    ];
}