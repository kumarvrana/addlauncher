<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Busstopsprice extends Model
{
    protected $fillable = [
        'busstops_id', 'price_key', 'price_value', 'number_key', 'number_value', 'duration_key', 'duration_value','ad_code'
    ];


     public function busstop()
    {
        return $this->belongsTo('App\Busstops', 'busstops_id', 'id');
    }


    public static function getBusstopsPriceCart($id, $option)
    {
        $selectDisplayOpt = explode("+", $option);
               
        $bstop_price = static::where([
                                    ['busstops_id', '=', $id],
                                    ['price_key', '=', $selectDisplayOpt[1]],
                                ])->get(array('price_key','price_value', 'number_key', 'number_value', 'duration_key', 'duration_value'))->first()->toArray();
        return $bstop_price;
    }

     public function FilterBusstopsAds($filterOption)
    {
        $minpriceFilter = (!empty($filterOption['minpricerange'])) ? $filterOption['minpricerange'] : 0;
        $maxpriceFilter = (!empty($filterOption['maxpricerange'])) ? $filterOption['maxpricerange'] : 500000;
        $locationFilter = (!empty($filterOption['locationFilter'])) ? $filterOption['locationFilter'] : null;
        $categoryFilter = (!empty($filterOption['category'])) ? $filterOption['category'] : null;
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

        if(isset($locationFilter)){
            $locationFilter = "%$locationFilter%";
            
            $busstops = $this->getLocationfilter($locationFilter);
            if(count($busstops)){
                foreach($busstops as $busstop){
                     $whereID[] = $busstop->id;
                }
           
            }

         
            
        }
        //dd($whereVariables);
        if(isset($locationFilter)){
            $busstoppriceOptions = Busstopsprice::where($whereVariables)->whereIn('busstops_id', $whereID)->get(array('busstops_id','price_key', 'price_value', 'number_key', 'number_value', 'duration_key', 'duration_value'));
        }else{
            $busstoppriceOptions = Busstopsprice::where($whereVariables)->get(array('busstops_id','price_key', 'price_value', 'number_key', 'number_value', 'duration_key', 'duration_value'));
        }
        
              
        return $busstoppriceOptions;
       
    }

    public function getLocationfilter($location)
    {
        return Busstops::where('location', 'LIKE', $location)->orWhere('city', 'LIKE', $location)->get();
        
    }

}