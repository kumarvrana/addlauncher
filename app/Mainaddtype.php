<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Mainaddtype extends Model
{
    protected $fillable = [ 'image', 'title', 'label', 'description', 'slug' ];

     public static function mediatype($medianame)
    {
        $mediatype = static::where('title', '=', $medianame)->get()->first();

        return $mediatype;
    }

   
}
