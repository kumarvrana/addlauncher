<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Carsprice extends Model
{
    protected $fillable = [
        'cars_id', 'price_key', 'price_value', 'number_key', 'number_value', 'duration_key', 'duration_value', 'option_type'
    ];

     public function car()
    {
        return $this->belongsTo('App\Cars', 'cars_id', 'id');
    }


    /*
     * @filter by car type and car options
     * $cartype, $carOption
     * return all cars by type and option
    */


    public static function getCarByFilter($cartype, $carOption)
    {
        $carOption1 = '%'.$carOption.'%';
        $carpriceOptions = static::where([
                                    ['price_key', 'LIKE', $carOption1],
                                    ['option_type', '=', $cartype],
                                ])->get(array('cars_id', 'price_key', 'price_value', 'number_key', 'number_value', 'duration_key', 'duration_value'));
        
       
        return $carpriceOptions;
    }

    public static function getCarPriceForCart($id, $option)
    {
        $car_price = static::where([
                                        ['cars_id', '=', $id],
                                        ['price_key', '=', $option],
                                    ])
                                    ->get(array('price_key', 'price_value','number_key',
                                     'number_value', 'duration_key', 'duration_value', 'option_type'))
                                    ->first()->toArray();


        return $car_price;
           
    }
}