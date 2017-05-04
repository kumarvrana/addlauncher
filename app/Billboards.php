<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Billboards extends Model
{
     protected $fillable = [
        'title', 'price', 'location', 'city', 'state', 'rank', 'landmark', 'description', 'image', 'references', 'status', 'display_options', 'light_option', 'billboardnumber','discount'
    ];

    public function billboardsprice()
    {
        return $this->hasMany('App\Billboardsprice', 'billboards_id');
    }

}


