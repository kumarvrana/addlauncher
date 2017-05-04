<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cars extends Model
{
     protected $fillable = [
        'title', 'price', 'location', 'city', 'state', 'rank', 'landmark', 'description', 'image', 'references', 'status', 'cartype', 'display_options','numberofcars','discount'
    ];

    public function carsprice()
    {
        return $this->hasMany('App\Carsprice', 'cars_id');
    }

}
