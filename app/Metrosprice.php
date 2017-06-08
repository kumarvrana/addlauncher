<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Metrosprice extends Model
{
    protected $fillable = [
        'metros_id', 'unit', 'number_face', 'dimension', 'base_price', 'printing_charge', 'totalvalue','price_key','ad_code'
    ];


    public function metro()
    {
        return $this->belongsTo('App\Metros', 'metros_id', 'id');
    }
    

    public static function getMetrospriceCart($id, $option)
    {
        $selectDisplayOpt = explode("+", $option);
               
        $metro_price = static::where([
                                    ['metros_id', '=', $id],
                                    ['price_key', '=', $selectDisplayOpt[1]],
                                ])->get(array('unit','number_face', 'dimension', 'base_price', 'printing_charge', 'totalprice','price_key'))->first()->toArray();
        return $metro_price;
    }
    

    public function FilterMetrosAds($filterOption)
    {
         
        $minpriceFilter = (!empty($filterOption['minpricerange'])) ? $filterOption['minpricerange'] : 0;
        $maxpriceFilter = (!empty($filterOption['maxpricerange'])) ? $filterOption['maxpricerange'] : 500000;
        $locationFilter = (!empty($filterOption['locationFilter'])) ? $filterOption['locationFilter'] : null;
        $categoryFilter = (!empty($filterOption['category'])) ? $filterOption['category'] : null;
        $whereVariables = array();
        $whereID = array();
        if(isset($minpriceFilter) || isset($maxpriceFilter)){
            $whereVariables[] = ['totalprice', '>=', $minpriceFilter];
            $whereVariables[] = ['totalprice', '<=', $maxpriceFilter];
        }
        if(isset($categoryFilter)){
            //foreach($categoryFilter as $category){
                 $categoryFilter = "%$categoryFilter%";
                 
                 $whereVariables[] = ['price_key', 'LIKE', $categoryFilter];
           // }
        }

        if(isset($locationFilter)){
            $locationFilter = "%$locationFilter%";
            
            $metros = $this->getLocationfilter($locationFilter);
            if(count($metros)){
                foreach($metros as $metro){
                     $whereID[] = $metro->id;
                }
           
            }

        }
        //dd($whereVariables);
        if(isset($locationFilter)){
            $metropriceOptions = Metrosprice::where($whereVariables)->whereIn('metros_id', $whereID)->get(array('metros_id','price_key', 'unit', 'number_face', 'dimension', 'base_price', 'printing_charge', 'totalprice'));
        }else{
            $metropriceOptions = Metrosprice::where($whereVariables)->get(array('metros_id','price_key', 'unit', 'number_face', 'dimension', 'base_price', 'printing_charge', 'totalprice'));
        }
        
              
        return $metropriceOptions;
       
    }

    public function getLocationfilter($location)
    {
        return Metros::where('location', 'LIKE', $location)->orWhere('city', 'LIKE', $location)->get();
    }
}