<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Televisionsprice extends Model
{
    protected $fillable = [
        'television_id', 'time_band_key', 'time_band_value', 'rate_key', 'rate_value', 'exposure_key', 'exposure_value', 'genre'
    ];

     public function television()
    {
        return $this->belongsTo('App\Televisions', 'television_id', 'id');
    }


    /*
     * @filter by television type and television options
     * $televisiontype, $televisionOption
     * return all televisions by type and option
    */


    public static function getTelevisionByFilter($televisiontype, $televisionOption)
    {
        $televisionOption1 = '%'.$televisionOption.'%';
        $televisionpriceOptions = static::where([
                                    ['rate_key', 'LIKE', $televisionOption1],
                                    ['genre', '=', $televisiontype],
                                ])->get(array('television_id', 'rate_key', 'rate_value', 'time_band_key', 'time_band_value', 'exposure_key', 'exposure_value'));
        
       
        return $televisionpriceOptions;
    }

    public static function getTelevisionPriceCart($id, $option)
    {
        $television_price = static::where([
                                        ['television_id', '=', $id],
                                        ['rate_key', '=', $option],
                                    ])
                                    ->get(array('rate_key', 'rate_value', 'time_band_key', 'time_band_value', 'exposure_key', 'exposure_value'))
                                    ->first()->toArray();


        return $television_price;
           
    }
}