<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Mainaddtype extends Model
{
    protected $fillable = [ 'image', 'title', 'label', 'description', 'slug' ];

    public function products(){
        return $this->hasMany('App\Product');
    }
}
