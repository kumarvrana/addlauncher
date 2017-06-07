<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Magazineprice extends Model
{
    protected $fillable = [
        'magazine_id', 'price_key', 'price_value' ,'number_value','duration_value', 'option_type','ad_code', 'variation_status'
    ];

    public function printmedia()
    {
        return $this->belongsTo('App\Newspapers', 'magazine_id', 'id');
    }

    public static function getMagazinePriceCart($id, $option)
    {
        $selectDisplayOpt = explode("+", $option);
               
        $magazine_price = static::where([
                                    ['magazine_id', '=', $id],
                                    ['price_key', '=', $selectDisplayOpt[1]],
                                ])->get(array('price_key','price_value','number_value','option_type','ad_code','variation_status'))->first()->toArray();
        return $magazine_price;
    }
}
