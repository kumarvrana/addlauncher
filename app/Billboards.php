<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Billboards extends Model
{
     protected $fillable = [
        'title', 'category_type', 'width', 'height', 'area', 'location', 'city', 'state', 'rank', 'landmark', 'description', 'image', 'references', 'status', 'light_option', 'price', 'discount_price', 'slug', 'reference_mail', 'ad_code'
    ];

    public function getUniqueSlug($title)
    {
        $slug = str_slug($title);
        $slugCount = count(Billboards::whereRaw("slug REGEXP '^{$slug}(-[0-9]+)?$'")->get());
        return ($slugCount > 0) ? "{$slug}-{$slugCount}" : $slug;
    }

    public function getIDFromSlug($slug)
    {
        $printmedia = Billboards::Where('slug', '=', $slug)->first();
        return $printmedia->id;
    }
}


