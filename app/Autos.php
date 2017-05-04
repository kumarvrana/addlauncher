<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Autos extends Model
{
     protected $fillable = [
         'autorikshaw_options', 'erikshaw_options', 'light_option', 'auto_number', 'title', 'price', 'location', 'city', 'state', 'rank', 'landmark', 'description', 'image', 'references', 'status','discount', 'autotype'
    ];
    public function autosprice()
    {
        return $this->hasMany('App\Autosprice', 'autos_id');
    }
}
