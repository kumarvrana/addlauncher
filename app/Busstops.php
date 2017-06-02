<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Busstops extends Model
{
     protected $fillable = [
        'title', 'price', 'location', 'city', 'state', 'rank', 'landmark', 'description', 'image', 'references', 'status', 'display_options', 'light_option', 'stopinnumber','discount','reference_mail'
    ];


    public function busstopsprice()
    {
        return $this->hasMany('App\Busstopsprice', 'busstops_id');
    }

    public function getStatusAttribute()
    {
        switch($this->attributes['status']){
            case 1:
                $status = 'Available';
            break;
            case 2:
                $status = 'Sold Out';
            break;
            case 3:
                $status = 'Coming Soon';
            break;
        }
        return $status;
    }

}
