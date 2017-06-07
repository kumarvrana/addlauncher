<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Metrosprice extends Model
{
    protected $fillable = [
        'metros_id', 'unit', 'number_face', 'dimension', 'base_price', 'printing_charge', 'totalvalue','metroline','ad_code'
    ];


    public function metro()
    {
        return $this->belongsTo('App\Metros', 'metros_id', 'id');
    }

   public static function getMetroByFilter($metroline)
    {
        dd($metroline);
         $metroline1 = '%'.$metroline.'%';
        
        $metropriceOptions = static::where('metroline', 'LIKE', $metroline1)
                                ->get(array('metros_id', 'unit', 'number_face', 'dimension', 'base_price', 'printing_charge','totalprice'));
        
       
        return $metropriceOptions;
    }
    

    public static function getMetrospriceCart($id, $option)
    {
        $selectDisplayOpt = explode("+", $option);
               
        $metro_price = static::where([
                                    ['metros_id', '=', $id],
                                    ['price_key', '=', $selectDisplayOpt[1]],
                                ])->get(array('price_key','price_value', 'number_key', 'number_value', 'duration_key', 'duration_value'))->first()->toArray();
        return $metro_price;
    }
    

    public function FilterMetrosAds($filterOption)
    {
         
        $metroest = Metrosprice::where(function($query) use($filterOption){
            
            $priceFilter = (!empty($filterOption['pricerange'])) ? $filterOption['pricerange'] : null;
            $locationFilter = (!empty($filterOption['locationFilter'])) ? $filterOption['locationFilter'] : [];
            $categoryFilter = (!empty($filterOption['category'])) ? $filterOption['category'] : [];

            if(isset($categoryFilter)){
               foreach($categoryFilter as $category){
                    $likeCat = "%$category%";
                    $query->where('price_key', 'LIKE', $likeCat);
                }
            }

       })->get(array('metros_id','price_key', 'price_value', 'number_key', 'number_value', 'duration_key', 'duration_value'))->toArray();
       
        dd($metroest);
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
            foreach($categoryFilter as $category){
                 $categoryFilter = "%$category%";
                 $whereVariables[] = ['price_key', 'LIKE', $categoryFilter];
            }
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
            $metropriceOptions = Metrosprice::where($whereVariables)->whereIn('metros_id', $whereID)->get(array('metros_id','price_key', 'price_value', 'number_key', 'number_value', 'duration_key', 'duration_value'));
        }else{
            $metropriceOptions = Metrosprice::where($whereVariables)->get(array('metros_id','price_key', 'price_value', 'number_key', 'number_value', 'duration_key', 'duration_value'));
        }
        
              
        return $metropriceOptions;
       
    }

    public function getLocationfilter($location)
    {
        return Metros::where('location', 'LIKE', $location)->orWhere('city', 'LIKE', $location)->get();
    }
}