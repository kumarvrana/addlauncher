<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Televisionsprice extends Model
{
    protected $fillable = [
        'television_id', 'time_band_key', 'time_band_value', 'rate_key', 'rate_value', 'exposure_key', 'exposure_value', 'genre','ad_code'
    ];

     public function television()
    {
        return $this->belongsTo('App\Televisions', 'television_id', 'id');
    }


    /*
     * @filter by television type and television options
     * $televisiontype, $televisionOption
     * return all televisions by type and option
    */
    public static function getTelevisionsPriceCart($id, $option)
    {
        $selectDisplayOpt = explode("+", $option);
        $television_price = static::where([
                                        ['television_id', '=', $id],
                                        ['rate_key', '=', $selectDisplayOpt[1]],
                                    ])
                                    ->get(array('rate_key', 'rate_value', 'time_band_key', 'time_band_value', 'exposure_key', 'exposure_value'))
                                    ->first()->toArray();


        return $television_price;
           
    }

    public function FilterTelevisionsAds($filterOption)
    {
        $minpriceFilter = (!empty($filterOption['minpricerange'])) ? $filterOption['minpricerange'] : 0;
        $maxpriceFilter = (!empty($filterOption['maxpricerange'])) ? $filterOption['maxpricerange'] : 500000;
        $categoryFilter = (!empty($filterOption['category'])) ? $filterOption['category'] : null;
        $whereVariables = array();
        $whereID = array();
        if(isset($minpriceFilter) || isset($maxpriceFilter)){
            $whereVariables[] = ['rate_value', '>=', $minpriceFilter];
            $whereVariables[] = ['rate_value', '<=', $maxpriceFilter];
        }
        if(isset($categoryFilter)){
            //foreach($categoryFilter as $category){
                 $categoryFilter = "%$categoryFilter%";
                 
                 $whereVariables[] = ['rate_key', 'LIKE', $categoryFilter];
           // }
        }

        if(isset($locationFilter)){
            $locationFilter = "%$locationFilter%";
            
            $televisions = $this->getLocationfilter($locationFilter);
            if(count($televisions)){
                foreach($televisions as $television){
                     $whereID[] = $television->id;
                }
           
            }

         
            
        }
        //dd($whereVariables);
        if(isset($locationFilter)){
            $televisionpriceOptions = Televisionsprice::where($whereVariables)->whereIn('television_id', $whereID)->get(array('television_id','rate_key', 'rate_value', 'time_band_key', 'time_band_value', 'exposure_key', 'exposure_value'));
        }else{
            $televisionpriceOptions = Televisionsprice::where($whereVariables)->get(array('television_id','rate_key', 'rate_value', 'time_band_key', 'time_band_value', 'exposure_key', 'exposure_value'));
        }
        
              
        return $televisionpriceOptions;
       
    }

    public function getLocationfilter($location)
    {
        return Televisions::where('location', 'LIKE', $location)->orWhere('city', 'LIKE', $location)->get();
        
    }

    
}