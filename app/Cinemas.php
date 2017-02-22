<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cinemas extends Model
{
     protected $fillable = [
        'title', 'price', 'location', 'city', 'state', 'rank', 'landmark', 'description', 'image', 'references', 'status', 'display_options', 'light_option', '	numberofcinema'
    ];

}
