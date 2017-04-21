<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Generalsettings extends Model
{
     protected $fillable = [
        'sitename', 'tagline', 'logo', 'firstemail', 'secondemail', 'firstphone', 'secondphone', 'address', 'facebook', 'twitter', 'linkedin', 'google', 'youtube', 'instagram', 'reddit', 'rss'
    ];

}