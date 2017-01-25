<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Mainaddtype extends Model
{
    protected $fillable = [ 'image', 'title', 'description' ];

    public function products(){
        return $this->hasMany('App\Product');
    }
}
