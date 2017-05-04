<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Metros extends Model
{
     protected $fillable = [
        'title', 'price', 'location', 'city', 'state', 'rank', 'landmark', 'description', 'image', 'references', 'status', 'display_options', 'light_option', 'metronumber','discount'
    ];

    public function metrosprice()
    {
        return $this->hasMany('App\Metrosprice', 'metros_id');
    }

}
