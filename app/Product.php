<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [ 'image', 'title', 'location', 'state', 'city', 'type_id', 'landmark', 'status', 'type_name' ];

   
}
