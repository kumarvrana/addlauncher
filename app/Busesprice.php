<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Busesprice extends Model
{
    protected $fillable = [
        'buses_id', 'price_key', 'price_value'
    ];
}