<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cars extends Model
{
     protected $fillable = [
        'title', 'price', 'location', 'city', 'state', 'rank', 'landmark', 'description', 'image', 'references', 'status', 'display_options', 'external_branding', 'internal_branding', 'light_option', 'numberofcars'
    ];

}
