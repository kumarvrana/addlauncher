<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Shoppingmallsprice extends Model
{
    protected $fillable = [
        'shoppingmalls_id', 'price_key', 'price_value', 'number_key', 'number_value', 'duration_key', 'duration_value','ad_code'
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