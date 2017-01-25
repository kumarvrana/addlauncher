<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Productmeta extends Model
{
    protected $fillable = [ 'product_id', 'meta_key', 'meta_value'];
}
