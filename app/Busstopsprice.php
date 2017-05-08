<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Busstopsprice extends Model
{
    protected $fillable = [
        'busstops_id', 'price_key', 'price_value', 'number_key', 'number_value', 'duration_key', 'duration_value'
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

}