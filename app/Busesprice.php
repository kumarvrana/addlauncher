<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Busesprice extends Model
{
    protected $fillable = [
        'buses_id', 'price_key', 'price_value','number_key', 'number_value', 'duration_key', 'duration_value'
    ];

     public function bus()
    {
        return $this->belongsTo('App\Buses', 'buses_id', 'id');
    }

    public static function getBusByFilter($busOption)
    {
        
         $busOption1 = '%'.$busOption.'%';
        
        $buspriceOptions = static::where('price_key', 'LIKE', $busOption1)
                                ->get(array('buses_id', 'price_key', 'price_value', 'number_key', 'number_value', 'duration_key', 'duration_value'));
        
       
        return $buspriceOptions;
    }

    public static function getBusesPriceCart($id, $option)
    {
        $selectDisplayOpt = explode("+", $option);
               
        $bus_price = static::where([
                                    ['buses_id', '=', $id],
                                    ['price_key', '=', $selectDisplayOpt[1]],
                                ])->get(array('price_key','price_value', 'number_key', 'number_value', 'duration_key', 'duration_value'))->first()->toArray();
        return $bus_price;
    }
    

    public function FilterBusesAds($filterOption)
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
            // foreach($categoryFilter as $category){
                 $categoryFilter = "%$categoryFilter%";
                 $whereVariables[] = ['price_key', 'LIKE', $categoryFilter];
            // }
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
            $buspriceOptions = Busesprice::where($whereVariables)->whereIn('buses_id', $whereID)->get(array('buses_id','price_key', 'price_value', 'number_key', 'number_value', 'duration_key', 'duration_value'));
        }else{
            $buspriceOptions = Busesprice::where($whereVariables)->get(array('buses_id','price_key', 'price_value', 'number_key', 'number_value', 'duration_key', 'duration_value'));
        }
        
              
        return $buspriceOptions;
       
    }

    public function getLocationfilter($location)
    {
        return Buses::where('location', 'LIKE', $location)->orWhere('city', 'LIKE', $location)->get();
    }



}