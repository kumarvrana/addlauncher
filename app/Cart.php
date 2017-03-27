<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Session;
class Cart
{
    public $items = null;
    public $totalQty = 0;
    public $totalPrice = 0;
   
    public function __construct($oldCart){
        if($oldCart){
            $this->items = $oldCart->items;
            $this->totalQty = $oldCart->totalQty;
            $this->totalPrice = $oldCart->totalPrice;
        }
    }
    // add product to cart
    public function addorRemove($item, $id, $model){
            $adPlusId = $model.'_'.$item['price_key'].'_'.$id;
            $storedItem = ['qty' => 0, 'price' => $item['price_value'], 'item' => $item];
            if($this->items){
                if(array_key_exists($adPlusId, $this->items)){
                     $this->items[$adPlusId]['qty']--;
                     $this->items[$adPlusId]['price'] -= $this->items[$adPlusId]['item']['price_value'];
                     $this->totalQty--;
                     $this->totalPrice -= $this->items[$adPlusId]['item']['price_value'];
                     unset($this->items[$adPlusId]);
                    return;
                }
            }
            $storedItem['qty']++;
            $storedItem['price'] = $item['price_value'] * $storedItem['qty'];
            $this->items[$adPlusId] = $storedItem;
            $this->totalQty++;
            $this->totalPrice += $item['price_value'];
    }

    public function UpdateCartQty($item, $itemskey, $count)
    {
        $price = 0;
        $this->items[$itemskey]['qty'] = $count;
        $this->items[$itemskey]['price'] = $this->items[$itemskey]['item']['price_value'] * $count;

        foreach($this->items as $itm){
            $price += $itm['price'];
           
        }
        $this->totalPrice = $price;
   }
  
    public function removeCartItem($id)
    {
        if($this->items){
            if(array_key_exists($id, $this->items)){
                $this->items[$id]['qty']--;
                $this->items[$id]['price'] -= $this->items[$id]['item']['price_value'];
                $this->totalQty--;
                $this->totalPrice -= $this->items[$id]['item']['price_value'];
                unset($this->items[$id]);
            }
        }
    }
    public function reduceByOne($id){
        $this->items[$id]['qty']--;
        $this->items[$id]['price'] -= $this->items[$id]['item']['price'];
        $this->totalQty--;
        $this->totalPrice -= $this->items[$id]['item']['price'];
    }
}
