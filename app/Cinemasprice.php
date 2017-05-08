<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cinemasprice extends Model
{
    protected $fillable = [
        'cinemas_id', 'price_key', 'price_value', 'duration_key', 'duration_value'
    ];

    public function cinema()
    {
        return $this->belongsTo('App\Cinemas', 'cinemas_id', 'id');
    }
}