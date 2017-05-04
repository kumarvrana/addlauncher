<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Shoppingmalls extends Model
{
     protected $fillable = [
       'title', 'price', 'location', 'city', 'state', 'rank', 'landmark', 'description', 'image', 'references', 'status', 'display_options', 'external_branding', 'internal_branding', 'light_option', 'numberofshoppingmalls','discount'
    ];

    public function shoppingmallsprice()
    {
        return $this->hasMany('App\Shoppingmallsprice', 'shoppingmalls_id');
    }

}
