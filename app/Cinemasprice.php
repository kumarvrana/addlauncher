<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cinemasprice extends Model
{
    protected $fillable = [
        'cinemas_id', 'price_key', 'price_value', 'duration_key', 'duration_value', 'option_type','ad_code'
    ];

    public function cinema()
    {
        return $this->belongsTo('App\Cinemas', 'cinemas_id', 'id');
    }

    public static function getCinemasPriceCart($id, $option)
    {
        $selectDisplayOpt = explode("+", $option);
               
        $cinema_price = static::where([
                                    ['cinemas_id', '=', $id],
                                    ['price_key', '=', $selectDisplayOpt[1]],
                                ])->get(array('price_key','price_value', 'duration_key', 'duration_value'))->first()->toArray();
        return $cinema_price;
    }


	// public static function getCinemaByFilter($cinemaOption)
 //    {
        
 //         $cinemaOption1 = '%'.$cinemaOption.'%';
        
 //        $cinemapriceOptions = static::where('price_key', 'LIKE', $cinemaOption1)
 //                                ->get(array('cinemas_id', 'price_key', 'price_value', 'duration_key', 'duration_value'));
        
       
 //        return $cinemapriceOptions;
 //    }

	

    public function FilterCinemasAds($filterOption)
    {  
        $minpriceFilter = (!empty($filterOption['minpricerange'])) ? $filterOption['minpricerange'] : 0;
        $maxpriceFilter = (!empty($filterOption['maxpricerange'])) ? $filterOption['maxpricerange'] : 500000;
        $maxpriceFilter = (!empty($filterOption['maxpricerange'])) ? $filterOption['maxpricerange'] : 500000;
        $locationFilter = (!empty($filterOption['locationFilter'])) ? $filterOption['locationFilter'] : null;
        $whereVariables = array();
        $whereID = array();
        if(isset($minpriceFilter) || isset($maxpriceFilter)){
            $whereVariables[] = ['price_value', '>=', $minpriceFilter];
            $whereVariables[] = ['price_value', '<=', $maxpriceFilter];
        }

        if(isset($locationFilter)){
            $locationFilter = "%$locationFilter%";
            $cinemas = $this->getLocationfilter($locationFilter);
            if(count($cinemas)){
                foreach($cinemas as $cinema){
                     $whereID[] = $cinema->id;
                }
           
            }
            
        }
        //dd($whereVariables);
        if(isset($locationFilter)){
            $cinemapriceOptions = Cinemasprice::where($whereVariables)->whereIn('cinemas_id', $whereID)->get(array('cinemas_id','price_key', 'price_value', 'duration_key', 'duration_value'));
        }else{
            $cinemapriceOptions = Cinemasprice::where($whereVariables)->get(array('cinemas_id','price_key', 'price_value', 'duration_key', 'duration_value'));
        }
        
              
        return $cinemapriceOptions;
       
    }

    public function getLocationfilter($location)
    {
        return Cinemas::where('location', 'LIKE', $location)->orWhere('city', 'LIKE', $location)->get();
    }


    public function getAdditionalOptions($id)
    {
        $data = Cinemasprice::where([
            ['cinemas_id', '=', $id],
            ['option_type', '=', 'additional']
        ])->get();
        $fieldData = array();
        foreach($data as $pricecinema){
            $fieldData[] = ucwords(str_replace('_', ' ', substr($pricecinema->price_key, 6)));
        }

        return $fieldData;
    }

    public function getGeneralOptions($id)
    {
        
        $data = Cinemasprice::where([
            ['cinemas_id', '=', $id],
            ['option_type', '=', 'general']
        ])->get();
        $fieldData = array();
        foreach($data as $pricecinema){
            $fieldData[] = ucwords(str_replace('_', ' ', substr($pricecinema->price_key, 6)));
        }
        
        return $fieldData;
    }
}