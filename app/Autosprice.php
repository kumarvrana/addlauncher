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
        $selectDisplayOpt = explode("+", $option);
               
        $auto_price = static::where([
                                    ['autos_id', '=', $id],
                                    ['price_key', '=', $selectDisplayOpt[1]],
                                ])->get(array('price_key','price_value', 'number_key', 'number_value', 'duration_key', 'duration_value'))->first()->toArray();
        return $auto_price;
           
    }

    public function FilterAutosAds($filterOption)
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
            //foreach($typeFilter as $category){
                 $typeFilter = "%$typeFilter%";
                 $whereVariables[] = ['option_type', 'LIKE', $typeFilter];
           // }
        }

        if(isset($locationFilter)){
            $locationFilter = "%$locationFilter%";
            $autos = $this->getLocationfilter($locationFilter);
            if(count($autos)){
                foreach($autos as $auto){
                     $whereID[] = $auto->id;
                }
           
            }
            
        }
        //dd($whereVariables);
        if(isset($locationFilter)){
            $autopriceOptions = Autosprice::where($whereVariables)->whereIn('autos_id', $whereID)->get(array('autos_id','price_key', 'price_value', 'number_key', 'number_value', 'duration_key', 'duration_value'));
        }else{
            $autopriceOptions = Autosprice::where($whereVariables)->get(array('autos_id','price_key', 'price_value', 'number_key', 'number_value', 'duration_key', 'duration_value'));
        }
        
              
        return $autopriceOptions;
       
    }

    public function getLocationfilter($location)
    {
        return Autos::where('location', 'LIKE', $location)->orWhere('city', 'LIKE', $location)->get();
    }
   
}