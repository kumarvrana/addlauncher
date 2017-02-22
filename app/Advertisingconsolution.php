<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Advertisingconsolution extends Model
{
     protected $fillable = [
        'title', 'price', 'location', 'city', 'state', 'rank', 'landmark', 'description', 'image', 'references', 'status', 'display_options', 'light_option', 'stopinnumber'
    ];

}
