<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Televisions extends Model
{
   protected $fillable = [
        'title', 'price', 'location', 'city', 'state', 'rank', 'landmark', 'genre', 'viewers' ,'description', 'image', 'references', 'status', 'discount','news_options','television_number','reference_mail'
    ];

    public function televisionsprice()
    {
        return $this->hasMany('App\Televisionsprice', 'television_id');
    }
}
