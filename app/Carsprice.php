<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Carsprice extends Model
{
    protected $fillable = [
        'cars_id', 'price_key', 'price_value', 'number_key', 'number_value', 'duration_key', 'duration_value', 'option_type','ad_code'
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

    public function FilterCarsAds($filterOption)
    {
        $minpriceFilter = (!empty($filterOption['minpricerange'])) ? $filterOption['minpricerange'] : 0;
        $maxpriceFilter = (!empty($filterOption['maxpricerange'])) ? $filterOption['maxpricerange'] : 500000;
        $locationFilter = (!empty($filterOption['locationFilter'])) ? $filterOption['locationFilter'] : null;
        $categoryFilter = (!empty($filterOption['category'])) ? $filterOption['category'] : null;
        $typeFilter = (!empty($filterOption['type'])) ? $filterOption['type'] : null;
        $whereVariables = array();
        $whereID = array();
        
        if(isset($minpriceFilter) || isset($maxpriceFilter)){
            $whereVariables[] = ['price_value', '>=', $minpriceFilter];
            $whereVariables[] = ['price_value', '<=', $maxpriceFilter];
        }
        if(isset($categoryFilter)){
            //foreach($categoryFilter as $category){
                 $categoryFilter = "%$categoryFilter%";
                 $whereVariables[] = ['price_key', 'LIKE', $categoryFilter];
           // }
        }

        if(isset($typeFilter)){
            //foreach($typeFilter as $type){
                 $typeFilter = "%$typeFilter%";
                 $whereVariables[] = ['option_type', 'LIKE', $typeFilter];
           // }
        }

        if(isset($locationFilter)){
            $locationFilter = "%$locationFilter%";
            $cars = $this->getLocationfilter($locationFilter);
            if(count($cars)){
                foreach($cars as $car){
                     $whereID[] = $car->id;
                }
           
            }
            
        }
        //dd($whereVariables);
        if(isset($locationFilter)){
            $carpriceOptions = Carsprice::where($whereVariables)->whereIn('cars_id', $whereID)->get(array('cars_id','price_key', 'price_value', 'number_key', 'number_value', 'duration_key', 'duration_value'));
        }else{
            $carpriceOptions = Carsprice::where($whereVariables)->get(array('cars_id','price_key', 'price_value', 'number_key', 'number_value', 'duration_key', 'duration_value'));
        }
        
              
        return $carpriceOptions;
       
    }

    public function getLocationfilter($location)
    {
        return Cars::where('location', 'LIKE', $location)->orWhere('city', 'LIKE', $location)->get();
    }
}