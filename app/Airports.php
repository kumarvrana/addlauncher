<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Airports extends Model
{
     protected $fillable = [
        'title', 'price', 'location', 'city', 'state', 'rank', 'landmark', 'description', 'image', 'references', 'status', 'display_options', 'light_option', 'airportnumber','discount'
    ];

    public function airportsprice()
    {
        return $this->hasMany('App\Airportsprice', 'airports_id');
    }

}
