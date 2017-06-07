<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Metros extends Model
{
     protected $fillable = [
        'title', 'price', 'location', 'city', 'state', 'rank', 'landmark', 'description', 'image', 'references', 'status', 'display_options', 'light_option', 'media','metro_line','discount','slug','reference_mail'
    ];

    public function metrosprice()
    {
        return $this->hasMany('App\Metrosprice', 'metros_id');
    }

}
