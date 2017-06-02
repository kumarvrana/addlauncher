<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Billboards extends Model
{
     protected $fillable = [
        'title', 'size', 'location', 'city', 'state', 'rank', 'landmark', 'description', 'image', 'references', 'status', 'display_options', 'light_option', 'billboardnumber','discount','reference_mail'
    ];

    public function billboardsprice()
    {
        return $this->hasMany('App\Billboardsprice', 'billboards_id');
    }

}


