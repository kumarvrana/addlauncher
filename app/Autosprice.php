<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Autosprice extends Model
{
    protected $fillable = [
        'autos_id', 'price_key', 'price_value', 'number_key', 'number_value', 'duration_key', 'duration_value', 'option_type'
    ];

     public function auto()
    {
        return $this->belongsTo('App\Autos', 'autos_id', 'id');
    }


    /*
     * @filter by auto type and auto options
     * $autotype, $autoOption
     * return all autos by type and option
    */


    public static function getAutoByFilter($autotype, $autoOption)
    {
        $autoOption1 = '%'.$autoOption.'%';
        $autopriceOptions = static::where([
                                    ['price_key', 'LIKE', $autoOption1],
                                    ['option_type', '=', $autotype],
                                ])->get(array('autos_id', 'price_key', 'price_value', 'number_key', 'number_value', 'duration_key', 'duration_value'));
        
       
        return $autopriceOptions;
    }

    public static function getAutoPriceForCart($id, $option)
    {
        $auto_price = static::where([
                                        ['autos_id', '=', $id],
                                        ['price_key', '=', $option],
                                    ])
                                    ->get(array('price_key', 'price_value','number_key',
                                     'number_value', 'duration_key', 'duration_value', 'option_type'))
                                    ->first()->toArray();


        return $auto_price;
           
    }
}