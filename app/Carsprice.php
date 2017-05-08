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

    public function FilterCarsAds($filterOption)
    {
        $priceFilter = (!empty($filterOption['pricerange'])) ? $filterOption['pricerange'] : null;
        $locationFilter = (!empty($filterOption['locationFilter'])) ? $filterOption['locationFilter'] : null;
        $categoryFilter = (!empty($filterOption['category'])) ? $filterOption['category'] : null;
        $typeFilter = (!empty($filterOption['type'])) ? $filterOption['type'] : null;
        $whereVariables = array();
        $whereID = array();
        if(isset($priceFilter)){
            $filter_priceCamparsion = preg_replace('/[0-9]+/', '', $priceFilter); // comparion operator
            if($filter_priceCamparsion != '<>'){
                $filter_price = preg_replace('/[^0-9]/', '', $priceFilter);
                $whereVariables[] = ['price_value', $filter_priceCamparsion, $filter_price];
            }else{
                $filter_price = preg_replace('/[^0-9]/', '_', $priceFilter);
                $filter_price = explode('_', $filter_price);
            
                $whereVariables[] = ['price_value', '>', $filter_price[0]];
                $whereVariables[] = ['price_value', '<=', $filter_price[2]];
            }
            
            
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