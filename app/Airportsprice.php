<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Airports;
class Airportsprice extends Model
{
    protected $fillable = [
        'airports_id', 'price_key', 'price_value', 'number_key', 'number_value', 'duration_key', 'duration_value'
    ];

     public function airport()
    {
        return $this->belongsTo('App\Airports', 'airports_id', 'id');
    }

   
     public static function getAirportByFilter($airportOption)
    {
        
         $airportOption1 = '%'.$airportOption.'%';
        
        $airportpriceOptions = static::where('price_key', 'LIKE', $airportOption1)
                                ->get(array('airports_id', 'price_key', 'price_value', 'number_key', 'number_value', 'duration_key', 'duration_value'));
        
       
        return $airportpriceOptions;
    }

    public static function getAirportspriceCart($id, $option)
    {
        $selectDisplayOpt = explode("+", $option);
               
        $airport_price = static::where([
                                    ['airports_id', '=', $id],
                                    ['price_key', '=', $selectDisplayOpt[1]],
                                ])->get(array('price_key','price_value', 'number_key', 'number_value', 'duration_key', 'duration_value'))->first()->toArray();
        return $airport_price;
    }
    

    public function FilterAirportsAds($filterOption)
    {
        $priceFilter = (!empty($filterOption['pricerange'])) ? $filterOption['pricerange'] : null;
        $locationFilter = (!empty($filterOption['locationFilter'])) ? $filterOption['locationFilter'] : null;
        $categoryFilter = (!empty($filterOption['category'])) ? $filterOption['category'] : null;
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

        if(isset($locationFilter)){
            $locationFilter = "%$locationFilter%";
            $airports = $this->getLocationfilter($locationFilter);
            if(count($airports)){
                foreach($airports as $airport){
                     $whereID[] = $airport->id;
                }
           
            }
            
        }
        //dd($whereVariables);
        if(isset($locationFilter)){
            $airportpriceOptions = Airportsprice::where($whereVariables)->whereIn('airports_id', $whereID)->get(array('airports_id','price_key', 'price_value', 'number_key', 'number_value', 'duration_key', 'duration_value'));
        }else{
            $airportpriceOptions = Airportsprice::where($whereVariables)->get(array('airports_id','price_key', 'price_value', 'number_key', 'number_value', 'duration_key', 'duration_value'));
        }
        
              
        return $airportpriceOptions;
       
    }

    public function getLocationfilter($location)
    {
        return Airports::where('location', 'LIKE', $location)->orWhere('city', 'LIKE', $location)->get();
    }
   
}