<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Newspapersprice extends Model
{
    protected $fillable = [
        'newspaper_id', 'price_key', 'base_price' , 'addon_price', 'total_price', 'genre', 'pricing_type', 'color', 'option_type','ad_code', 'variation_status'
    ];

    public function printmedia()
    {
        return $this->belongsTo('App\Newspapers', 'newspaper_id', 'id');
    }

     public static function getNewspaperPriceCart($id, $option)
    {
        $selectDisplayOpt = explode("+", $option);
               
        $newspaper_price = static::where([
                                    ['newspaper_id', '=', $id],
                                    ['price_key', '=', $selectDisplayOpt[1]],
                                ])->get(array('price_key','base_price','addon_price','total_price','genre','pricing_type','color','option_type','ad_code','variation_status'))->first()->toArray();
        return $newspaper_price;
    }
}