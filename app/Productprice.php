<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Productprice extends Model
{
    protected $fillable = [ 'product_id', 'price_key', 'price_value', 'productmeta_id'];
}
