<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Newspapers extends Model
{
     protected $fillable = [
        'title', 'price', 'location', 'city', 'state', 'rank', 'landmark', 'description', 'image', 'references', 'status', 'printmedia_type', 'printmedia_name', 'genre', 'circulations', 'language', 'magazine_options', 'general_options', 'other_options', 'classified_options', 'pricing_options','discount'
    ];

    public function languages()
    {
        return $this->hasMany('App\Language');
    }
}
