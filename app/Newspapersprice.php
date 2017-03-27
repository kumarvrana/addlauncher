<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Newspapersprice extends Model
{
    protected $fillable = [
        'newspapers_id', 'price_key', 'price_value', 'option_type'
    ];
}