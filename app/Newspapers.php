<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Newspapers extends Model
{
     protected $fillable = [
        'title', 'price', 'location', 'city', 'state', 'rank', 'landmark', 'description', 'image', 'references', 'status', 'printmedia_type', 'printmedia_name', 'genre', 'circulations', 'language', 'magazine_options', 'general_options', 'other_options', 'classified_options', 'pricing_options','discount','reference_mail'
    ];

    public function cinemasprice()
    {
        return $this->hasMany('App\Newspapersprice', 'newspapers_id');
    }


    public function getUniqueSlug($title)
    {
        $slug = str_slug($title);
        $slugCount = count(Cinemas::whereRaw("slug REGEXP '^{$slug}(-[0-9]+)?$'")->get());
        return ($slugCount > 0) ? "{$slug}-{$slugCount}" : $slug;
    }


    public function languages()
    {
        return $this->hasMany('App\Language');
    }

     public function getIDFromSlug($slug)
    {
        $printmedia = Newspapers::Where('slug', '=', $slug)->first();
        return $printmedia->id;
    }
}
