<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Billboardsprice extends Model
{
    protected $fillable = [
        'billboards_id', 'price_key', 'price_value', 'number_key', 'number_value' , 'duration_key' , 'duration_value'
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
         
        $billboardest = Billboardsprice::where(function($query) use($filterOption){
            
            $priceFilter = (!empty($filterOption['pricerange'])) ? $filterOption['pricerange'] : null;
            $locationFilter = (!empty($filterOption['locationFilter'])) ? $filterOption['locationFilter'] : [];
            $categoryFilter = (!empty($filterOption['category'])) ? $filterOption['category'] : [];

            if(isset($categoryFilter)){
               foreach($categoryFilter as $category){
                    $likeCat = "%$category%";
                    $query->where('price_key', 'LIKE', $likeCat);
                }
            }

       })->get(array('billboards_id','price_key', 'price_value', 'number_key', 'number_value', 'duration_key', 'duration_value'))->toArray();
       
        dd($billboardest);
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
            $billboards = $this->getLocationfilter($locationFilter);
            if(count($billboards)){
                foreach($billboards as $billboard){
                     $whereID[] = $billboard->id;
                }
           
            }
            
        }
        //dd($whereVariables);
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