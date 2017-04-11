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
    public function addorRemove($item, $id, $model, $flag){
        
        if($flag){
            $adPlusId = $model.'_'.$item['price_key'].'_'.$id;
            $storedItem = ['qty' => 0, 'price' => $item['price_value'], 'item' => $item];
            if($this->items){
                if(array_key_exists($adPlusId, $this->items)){
                     $this->items[$adPlusId]['qty']--;
                     $this->items[$adPlusId]['price'] -= $this->items[$adPlusId]['item']['price_value'];
                     $this->totalQty--;
                     $this->totalPrice -= $this->items[$adPlusId]['item']['price_value'];
                     unset($this->items[$adPlusId]);
                    return 'removed';
                }
            }
            $storedItem['qty']++;
            $storedItem['price'] = $item['price_value'] * $storedItem['qty'];
            $this->items[$adPlusId] = $storedItem;
            $this->totalQty++;
            $this->totalPrice += $item['price_value'];
        }else{
           
            $adPlusId = $model.'_'.'tricycle'.'_'.$id;
            $storedItem = ['qty' => 0, 'price' => $item['price'], 'item' => $item];
            if($this->items){
                if(array_key_exists($adPlusId, $this->items)){
                     $this->items[$adPlusId]['qty']--;
                     $this->items[$adPlusId]['price'] -= $this->items[$adPlusId]['item']['price'];
                     $this->totalQty--;
                     $this->totalPrice -= $this->items[$adPlusId]['item']['price'];
                     unset($this->items[$adPlusId]);
                    return 'removed';
                }
            }
            $storedItem['qty']++;
            $storedItem['price'] = $item['price'] * $storedItem['qty'];
            $this->items[$adPlusId] = $storedItem;
            $this->totalQty++;
            $this->totalPrice += $item['price'];
        }
         return 'added';  
    }

    public function UpdateCartQty($item, $itemskey, $count)
    {
        $checkKey = explode('_', $itemskey);
        if( $checkKey[1] == 'tricycle' ){
             $price = 0;
            $this->items[$itemskey]['qty'] = $count;
            $this->items[$itemskey]['price'] = $this->items[$itemskey]['item']['price'] * $count;

            foreach($this->items as $itm){
                $price += $itm['price'];
            
            }
            $this->totalPrice = $price;
        }else{
            $price = 0;
            $this->items[$itemskey]['qty'] = $count;
            $this->items[$itemskey]['price'] = $this->items[$itemskey]['item']['price_value'] * $count;

            foreach($this->items as $itm){
                $price += $itm['price'];
            
            }
            $this->totalPrice = $price;
        }
       
   }
  
    public function removeCartItem($id)
    {
        if($this->items){
            if(array_key_exists($id, $this->items)){
                $checkKey = explode('_', $id);
                if($checkKey[1] == 'tricycle'){
                    $this->items[$id]['qty']--;
                    $this->items[$id]['price'] -= $this->items[$id]['item']['price'];
                    $this->totalQty--;
                    $this->totalPrice -= $this->items[$id]['item']['price'];
                    unset($this->items[$id]);
                }else{
                    $this->items[$id]['qty']--;
                    $this->items[$id]['price'] -= $this->items[$id]['item']['price_value'];
                    $this->totalQty--;
                    $this->totalPrice -= $this->items[$id]['item']['price_value'];
                    unset($this->items[$id]);
                }
               
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
