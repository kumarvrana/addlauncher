<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Paymentsetting extends Model
{
     protected $fillable = [
        'payment_method', 'payment_secret'
    ];

}