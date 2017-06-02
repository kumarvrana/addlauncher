<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Airports;
class Airportsprice extends Model
{
    protected $fillable = [
        'airports_id', 'area', 'displayoption', 'dimensions', 'optionprice', 'units','ad_code'
    ];

     public function airport()
    {
        return $this->belongsTo('App\Airports', 'airports_id', 'id');
    }

   
     public static function getAirportByFilter($airportOption)
    {
        
         $airportOption1 = '%'.$airportOption.'%';
        
        $airportpriceOptions = static::where('displayoption', 'LIKE', $airportOption1)
                                ->get(array('id', 'airports_id', 'area', 'displayoption', 'dimensions', 'optionprice', 'units', 'ad_code'));
        
       
        return $airportpriceOptions;
    }

    public static function getAirportspriceCart($id, $option)
    {
                      
        $airport_price = static::where('id', $option)->get(array('area', 'displayoption', 'dimensions', 'optionprice', 'units', 'ad_code'))->first()->toArray();
        $airport_price['variation_id'] = (int) $option;
        return $airport_price;
    }
    

    public function FilterAirportsAds($filterOption)
    {
        $minpriceFilter = (!empty($filterOption['minpricerange'])) ? $filterOption['minpricerange'] : 0;
        $maxpriceFilter = (!empty($filterOption['maxpricerange'])) ? $filterOption['maxpricerange'] : 500000;
        $locationFilter = (!empty($filterOption['locationFilter'])) ? $filterOption['locationFilter'] : null;
        $categoryFilter = (!empty($filterOption['category'])) ? $filterOption['category'] : null;
        $whereVariables = array();
        $whereID = array();
        if(isset($minpriceFilter) || isset($maxpriceFilter)){
            $whereVariables[] = ['optionprice', '>=', $minpriceFilter];
            $whereVariables[] = ['optionprice', '<=', $maxpriceFilter];
        }
        if(isset($categoryFilter)){
             $categoryFilter = "%$categoryFilter%";
             $whereVariables[] = ['optionprice', 'LIKE', $categoryFilter];
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
            $airportpriceOptions = Airportsprice::where($whereVariables)->whereIn('airports_id', $whereID)->get(array('airports_id','area', 'displayoption', 'dimensions', 'optionprice', 'units', 'ad_code'));
        }else{
            $airportpriceOptions = Airportsprice::where($whereVariables)->get(array('id', 'airports_id','area', 'displayoption', 'dimensions', 'optionprice', 'units', 'ad_code'));
        }
        
              
        return $airportpriceOptions;
       
    }

    public function getLocationfilter($location)
    {
        return Airports::where('location', 'LIKE', $location)->orWhere('city', 'LIKE', $location)->get();
    }
   
}