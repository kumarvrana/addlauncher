<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cinemasprice extends Model
{
    protected $fillable = [
        'cinemas_id', 'price_key', 'price_value','number_key', 'number_value', 'duration_key', 'duration_value'
    ];

    public function cinema()
    {
        return $this->belongsTo('App\Cinemas', 'cinemas_id', 'id');
    }


	public static function getCinemaByFilter($cinemaOption)
    {
        
         $cinemaOption1 = '%'.$cinemaOption.'%';
        
        $cinemapriceOptions = static::where('price_key', 'LIKE', $cinemaOption1)
                                ->get(array('cinemas_id', 'price_key', 'price_value', 'number_key', 'number_value', 'duration_key', 'duration_value'));
        
       
        return $cinemapriceOptions;
    }

	public static function getCinemasPriceCart($id, $option)
    {
        $selectDisplayOpt = explode("+", $option);
               
        $cinema_price = static::where([
                                    ['cinemas_id', '=', $id],
                                    ['price_key', '=', $selectDisplayOpt[1]],
                                ])->get(array('price_key','price_value', 'number_key', 'number_value', 'duration_key', 'duration_value'))->first()->toArray();
        return $cinema_price;
    }

    public function FilterCinemasAds($filterOption)
    {  
        $priceFilter = (!empty($filterOption['pricerange'])) ? $filterOption['pricerange'] : null;
        $locationFilter = (!empty($filterOption['locationFilter'])) ? $filterOption['locationFilter'] : null;
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

        if(isset($locationFilter)){
            $locationFilter = "%$locationFilter%";
            $buses = $this->getLocationfilter($locationFilter);
            if(count($buses)){
                foreach($buses as $bus){
                     $whereID[] = $bus->id;
                }
           
            }
            
        }
        //dd($whereVariables);
        if(isset($locationFilter)){
            $buspriceOptions = Cinemasprice::where($whereVariables)->whereIn('buses_id', $whereID)->get(array('buses_id','price_key', 'price_value', 'number_key', 'number_value', 'duration_key', 'duration_value'));
        }else{
            $buspriceOptions = Cinemasprice::where($whereVariables)->get(array('buses_id','price_key', 'price_value', 'number_key', 'number_value', 'duration_key', 'duration_value'));
        }
        
              
        return $buspriceOptions;
       
    }

    public function getLocationfilter($location)
    {
        return Cinemas::where('location', 'LIKE', $location)->orWhere('city', 'LIKE', $location)->get();
    }

}