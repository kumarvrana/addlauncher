<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Televisions extends Model
{
   protected $fillable = [
        'title', 'price', 'location', 'city', 'state', 'rank', 'landmark', 'genre', 'viewers' ,'description', 'image', 'references', 'status', 'display_options'
    ];
}
