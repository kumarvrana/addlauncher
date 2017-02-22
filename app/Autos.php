<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Autos extends Model
{
     protected $fillable = [
         'display_options', 'front_pamphlets_reactanguler_options', 'front_stickers_options', 'hood_options', 'interior_options', 'light_option', 'auto_number', 'title', 'price', 'location', 'city', 'state', 'rank', 'landmark', 'description', 'image', 'references', 'status','discount'
    ];

}
