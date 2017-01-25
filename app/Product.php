<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [ 'imagepath', 'title', 'description', 'price', 'location', 'state', 'city', 'mediatype_id', 'rank', 'landmark', 'reference', 'status' ];

    public function mainaddtype(){
        return $this->belongsTo('App\Mainaddtype');
    }
}
