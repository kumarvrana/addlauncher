<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Billboardsprice extends Model
{
    protected $fillable = [
        'billboards_id', 'price_key', 'price_value', 'number_key', 'number_value' , 'duration_key' , 'duration_value','ad_code'
    ];

     public function billboard()
    {
        return $this->belongsTo('App\Billboards', 'billboards_id', 'id');
    }

   
     public static function getBillboardByFilter($billboardOption)
    {
        
         $billboardOption1 = '%'.$billboardOption.'%';
        
        $billboardpriceOptions = static::where('price_key', 'LIKE', $billboardOption1)
                                ->get(array('billboards_id', 'price_key', 'price_value', 'number_key', 'number_value', 'duration_key', 'duration_value'));
        
       
        return $billboardpriceOptions;
    }

    public static function getBillboardspriceCart($id, $option)
    {
        $selectDisplayOpt = explode("+", $option);
               
        $billboard_price = static::where([
                                    ['billboards_id', '=', $id],
                                    ['price_key', '=', $selectDisplayOpt[1]],
                                ])->get(array('price_key','price_value', 'number_key', 'number_value', 'duration_key', 'duration_value'))->first()->toArray();
        return $billboard_price;
    }
    

    public function FilterBillboardsAds($filterOption)
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
            //}
        }

        if(isset($locationFilter)){
            $locationFilter = "%$locationFilter%";
            $billboards = $this->getLocationfilter($locationFilter);
            if(count($billboards)){
                foreach($billboards as $billboard){
                     $whereID[] = $billboard->id;
                }
           
            }
            
        }
        if(isset($locationFilter)){
            $billboardpriceOptions = Billboardsprice::where($whereVariables)->whereIn('billboards_id', $whereID)->get(array('billboards_id','price_key', 'price_value', 'number_key', 'number_value', 'duration_key', 'duration_value'));
        }else{
            $billboardpriceOptions = Billboardsprice::where($whereVariables)->get(array('billboards_id','price_key', 'price_value', 'number_key', 'number_value', 'duration_key', 'duration_value'));
        }
        
              
        return $billboardpriceOptions;
       
    }

    public function getLocationfilter($location)
    {
        return Billboards::where('location', 'LIKE', $location)->orWhere('city', 'LIKE', $location)->get();
    }

}