<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Shoppingmallsprice extends Model
{
    protected $fillable = [
        'shoppingmalls_id', 'price_key', 'price_value', 'number_key', 'number_value', 'duration_key', 'duration_value'
    ];

    public function shoppingmall()
    {
        return $this->belongsTo('App\Shoppingmalls', 'shoppingmalls_id', 'id');
    }

   
    //  public static function getShoppingmallByFilter($shoppingmallOption)
    // {
        
    //      $shoppingmallOption1 = '%'.$shoppingmallOption.'%';
        
    //     $shoppingmallpriceOptions = static::where('price_key', 'LIKE', $shoppingmallOption1)
    //                             ->get(array('shoppingmalls_id', 'price_key', 'price_value', 'number_key', 'number_value', 'duration_key', 'duration_value'));
        
       
    //     return $shoppingmallpriceOptions;
    // }

    public static function getShoppingmallspriceCart($id, $option)
    {
        $selectDisplayOpt = explode("+", $option);
               
        $shoppingmall_price = static::where([
                                    ['shoppingmalls_id', '=', $id],
                                    ['price_key', '=', $selectDisplayOpt[1]],
                                ])->get(array('price_key','price_value', 'number_key', 'number_value', 'duration_key', 'duration_value'))->first()->toArray();
        return $shoppingmall_price;
    }
    

    public function FilterShoppingmallsAds($filterOption)
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
            $shoppingmalls = $this->getLocationfilter($locationFilter);
            if(count($shoppingmalls)){
                foreach($shoppingmalls as $shoppingmall){
                     $whereID[] = $shoppingmall->id;
                }
           
            }
            
        }
        //dd($whereVariables);
        if(isset($locationFilter)){
            $shoppingmallpriceOptions = Shoppingmallsprice::where($whereVariables)->whereIn('shoppingmalls_id', $whereID)->get(array('shoppingmalls_id','price_key', 'price_value', 'number_key', 'number_value', 'duration_key', 'duration_value'));
        }else{
            $shoppingmallpriceOptions = Shoppingmallsprice::where($whereVariables)->get(array('shoppingmalls_id','price_key', 'price_value', 'number_key', 'number_value', 'duration_key', 'duration_value'));
        }
        
              
        return $shoppingmallpriceOptions;
       
    }

    public function getLocationfilter($location)
    {
        return Shoppingmalls::where('location', 'LIKE', $location)->orWhere('city', 'LIKE', $location)->get();
    }
}