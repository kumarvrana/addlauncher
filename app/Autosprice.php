<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Autosprice extends Model
{
    protected $fillable = [
        'autos_id', 'price_key', 'price_value'
    ];
}