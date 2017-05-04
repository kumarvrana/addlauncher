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

}