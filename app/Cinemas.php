<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cinemas extends Model
{
     protected $fillable = [
        'title', 'price', 'location', 'city', 'state', 'rank', 'landmark', 'description', 'image', 'references', 'status', 'display_options','additional_adsoption', 'discount', 'cinemanumber', 'audiseats', 'audinumber', 'cinemacategory', 'slug', 'reference_mail'
    ];

    public function cinemasprice()
    {
        return $this->hasMany('App\Cinemasprice', 'cinemas_id');
    }

    public function getUniqueSlug($title)
    {
        $slug = str_slug($title);
        $slugCount = count(Cinemas::whereRaw("slug REGEXP '^{$slug}(-[0-9]+)?$'")->get());
        return ($slugCount > 0) ? "{$slug}-{$slugCount}" : $slug;
    }

    public function getStatusAttribute()
    {
        switch($this->attributes['status']){
            case 1:
                $status = 'Available';
            break;
            case 2:
                $status = 'Sold Out';
            break;
            case 3:
                $status = 'Coming Soon';
            break;
        }
        return $status;
    }

    public function getIDFromSlug($slug)
    {
        $cinema = Cinemas::Where('slug', '=', $slug)->first();
        return $cinema->id;
    }
}
