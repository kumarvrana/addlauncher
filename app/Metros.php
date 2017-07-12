<?php

namespace App;
use Illuminate\Database\Eloquent\Model;

class Metros extends Model
{
    
	protected $fillable = [
        'metroline_id', 'station_name', 'location', 'city', 'units', 'faces', 'width', 'height', 'area', 'price', 'discount_price', 'description', 'image', 'references', 'status', 'media','reference_mail', 'ad_code', 'source'
    ];

    public function metroline()
    {
        return $this->belongsTo('App\Metroline', 'metroline_id', 'id');
    }

}
