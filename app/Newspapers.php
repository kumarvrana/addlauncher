<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Newspapers extends Model
{
     protected $fillable = [
        'title', 'price', 'location', 'city', 'state', 'rank', 'landmark', 'description', 'image', 'references', 'status', 'circulations', 'language', 'general_options', 'other_options', 'classified_options'
    ];

}
