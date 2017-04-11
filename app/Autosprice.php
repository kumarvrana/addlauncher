<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Autosprice extends Model
{
    protected $fillable = [
        'autos_id', 'price_key', 'price_value', 'number_key', 'number_value', 'duration_key', 'duration_value', 'option_type'
    ];

     public function autoprice(){
        return $this->hasMany('App\Autos');
    }

}