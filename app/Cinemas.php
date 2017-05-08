<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cinemas extends Model
{
     protected $fillable = [
        'title', 'price', 'location', 'city', 'state', 'rank', 'landmark', 'description', 'image', 'references', 'status', 'display_options', 'discount', 'cinemanumber', 'audiseats', 'audinumber', 'cinemacategory'
    ];

    public function cinemasprice()
    {
        return $this->hasMany('App\Cinemasprice', 'cinemas_id');
    }
}
