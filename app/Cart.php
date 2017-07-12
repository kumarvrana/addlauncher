<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Session;
use Sentinel;
use \App\CartModel;

class Cart extends Model{
	public $items = null;
	public $totalQty = 0;
	public $totalPrice = 0;
   
	public function __construct($oldCart){

		if($user = Sentinel::check()){
			$db_cart = new CartModel;
			// $db_cart_value = $db_cart->get_value_by_user_id($user->id);
			// if($db_cart_value !== false){
			// 	$this->items = $db_cart_value->items;
			// 	$this->totalQty = $db_cart_value->totalQty;
			// 	$this->totalPrice = $db_cart_value->totalPrice;
			// }
			$db_cart->update_cart_in_db($user->id);
		}
		if($oldCart){
			$this->items = $oldCart->items;
			$this->totalQty = $oldCart->totalQty;
			$this->totalPrice = $oldCart->totalPrice;
		}


	}

	// add product to cart
	public function addorRemove($item, $id, $model, $flag){
		dd("addorRemove function called!");
		if($flag){
			$adPlusId = $model.'_'.$item['price_key'].'_'.$id;
			$storedItem = ['qty' => 0, 'price' => $item['price_value'], 'duration' => 1, 'item' => $item];
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
			$storedItem = ['qty' => 0, 'price' => $item['price'], 'duration' => 1 , 'item' => $item];
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

	public function UpdateCartQty($item, $itemskey, $count, $duration){
		dd("UpdateCartQty function called!");

		$checkKey = explode('_', $itemskey);
		if( $checkKey[1] == 'tricycle' ){
			$price = 0;
			$this->items[$itemskey]['qty'] = $count;
			$this->items[$itemskey]['duration'] = $duration;
			$this->items[$itemskey]['price'] = $this->items[$itemskey]['item']['price'] * $count * $duration;

			foreach($this->items as $itm){
				$price += $itm['price'];
			}
			$this->totalPrice = $price;
		}else{

			$price = 0;
			$this->items[$itemskey]['qty'] = $count;
			$this->items[$itemskey]['duration'] = $duration;
			$this->items[$itemskey]['price'] = $this->items[$itemskey]['item']['price_value'] * $count * $duration;

			foreach($this->items as $itm){
				$price += $itm['price'];
			}
			$this->totalPrice = $price;
		}
	   
   }

	public function removeCartItem($id){
		// dd("removeCartItem function called!");

		if($this->items){
			if(array_key_exists($id, $this->items)){
				$checkKey = explode('_', $id);
				if($checkKey[1] == 'tricycle'){
					$this->totalQty--;
					if($this->items[$id]['duration'] > 0){
						$this->totalPrice -= $this->items[$id]['item']['price'] * $this->items[$id]['qty'] * $this->items[$id]['duration'];
					}else{
						$this->totalPrice -= $this->items[$id]['item']['price'] * $this->items[$id]['qty'];
					}
					$this->items[$id]['qty']--;
					$this->items[$id]['price'] -= $this->items[$id]['item']['price'];
					unset($this->items[$id]);
				}else{
					$this->totalQty--;
					if($this->items[$id]['duration'] > 0){
						$this->totalPrice -= $this->items[$id]['item']['price_value'] * $this->items[$id]['qty'] * $this->items[$id]['duration'];
					}else{
						$this->totalPrice -= $this->items[$id]['item']['price_value'] * $this->items[$id]['qty']; 
					}
					
					$this->items[$id]['qty']--;
					$this->items[$id]['price'] -= $this->items[$id]['item']['price_value'];
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

	 // add television product to cart


	public function addorRemoveTelevision($item, $id, $model, $flag){   
			
		$adPlusId = $model.'_'.$item['rate_key'].'_'.$id;
		$storedItem = ['qty' => 0, 'price' => $item['rate_value'], 'duration' => 1, 'item' => $item];
		if($this->items){
			if(array_key_exists($adPlusId, $this->items)){
					$this->items[$adPlusId]['qty']--;
					$this->items[$adPlusId]['price'] -= $this->items[$adPlusId]['item']['rate_value'];
					$this->totalQty--;
					$this->totalPrice -= $this->items[$adPlusId]['item']['rate_value'];
					unset($this->items[$adPlusId]);
				return 'removed';
			}
		}
		$storedItem['qty']++;
		$storedItem['price'] = $item['rate_value'] * $storedItem['qty'];
		$this->items[$adPlusId] = $storedItem;
		$this->totalQty++;
		$this->totalPrice += $item['rate_value'];
		
		return 'added';  
	}



		public function UpdateTelevisionCartQty($item, $itemskey, $count, $duration)
		{
			$checkKey = explode('_', $itemskey);
			
			$price = 0;
			$this->items[$itemskey]['qty'] = $count;
			$this->items[$itemskey]['duration'] = $duration;
			$this->items[$itemskey]['price'] = $this->items[$itemskey]['item']['rate_value'] * $count * $duration;

			foreach($this->items as $itm){
				$price += $itm['price'];
			}
			$this->totalPrice = $price;
			
	   }
	  
		public function removeTelevisionCartItem($id)
		{
			if($this->items){
				if(array_key_exists($id, $this->items)){
					$checkKey = explode('_', $id);
					$this->totalQty--;
					if($this->items[$id]['duration'] > 0){
						$this->totalPrice -= $this->items[$id]['item']['rate_value'] * $this->items[$id]['qty'] * $this->items[$id]['duration'];    
					}else{
						$this->totalPrice -= $this->items[$id]['item']['rate_value'] * $this->items[$id]['qty'];
					}

					$this->items[$id]['qty']--;
					$this->items[$id]['price'] -= $this->items[$id]['item']['rate_value'];
					unset($this->items[$id]);
				
				}
			}
		}


		public function addorRemoveCinema($item, $id, $model, $flag)
		{  
		dd($item, $id, $model);         
		  $adPlusId = $model.'_'.$item['price_key'].'_'.$id;
			$storedItem = ['qty' => 0, 'length'=>1, 'price' => $item['price_value'], 'duration' => 1, 'item' => $item];
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

			return 'added';  
	}


	public function addorRemoveAirport($item, $id, $model){ 
		$adPlusId = $model.'_'.$item['variation_id'].'_'.$id;
		$storedItem = ['qty' => 0, 'price' => $item['optionprice'], 'duration' => 1, 'item' => $item];
		if($this->items){
			if(array_key_exists($adPlusId, $this->items)){
				$this->items[$adPlusId]['qty']--;
				$this->items[$adPlusId]['price'] -= $this->items[$adPlusId]['item']['optionprice'];
				$this->totalQty--;
				$this->totalPrice -= $this->items[$adPlusId]['item']['optionprice'];
				unset($this->items[$adPlusId]);
				return 'removed';
			}
		}
		$storedItem['qty']++;
		$storedItem['price'] = $item['optionprice'] * $storedItem['qty'];
		$this->items[$adPlusId] = $storedItem;
		$this->totalQty++;
		$this->totalPrice += $item['optionprice'];
		
		return 'added';
	}

	public function removeAirportCartItem($id){
		// dd("removeAirportCartItem");
		if($this->items){
			if(array_key_exists($id, $this->items)){
				$checkKey = explode('_', $id);
				$this->totalQty--;
				if($this->items[$id]['duration'] > 0){
					$this->totalPrice -= $this->items[$id]['item']['optionprice'] * $this->items[$id]['qty'] * $this->items[$id]['duration'];    
				}else{
					$this->totalPrice -= $this->items[$id]['item']['optionprice'] * $this->items[$id]['qty'];
				}

				$this->items[$id]['qty']--;
				$this->items[$id]['price'] -= $this->items[$id]['item']['optionprice'];
				unset($this->items[$id]);
			
			}
		}
	}

	public function UpdateAirportCartQty($item, $itemskey, $count, $duration){
		$checkKey = explode('_', $itemskey);
		
		$price = 0;
		$this->items[$itemskey]['qty'] = $count;
		$this->items[$itemskey]['duration'] = $duration;
		$this->items[$itemskey]['price'] = $this->items[$itemskey]['item']['optionprice'] * $count * $duration;

		foreach($this->items as $itm){
			$price += $itm['price'];
		}
		$this->totalPrice = $price;
		
   }

	public function addorRemovePrintmedia($item, $id, $printmedia, $flag)
	{ 
	   
		$adPlusId = $printmedia.'_'.$item['price_key'].'_'.$id;
		if($printmedia === 'magazine'){
			$mainprice = $item['price_value'];
			$storedItem = ['qty' => 0, 'price' => $mainprice, 'duration'=> 1,'item' => $item];
		}else{
			$mainprice = $item['total_price'] * 16;
			$storedItem = ['qty' => 0, 'price' => $mainprice, 'width' => 4, 'height' => 4,'item' => $item];
		}
		
		if($this->items){
			if(array_key_exists($adPlusId, $this->items)){
					if($printmedia === 'magazine'){
						$itemprice = $this->items[$adPlusId]['item']['price_value'];
					}else{
						$itemprice = $this->items[$adPlusId]['item']['total_price'] * $this->items[$adPlusId]['width'] * $this->items[$adPlusId]['height'];
					}
					$this->items[$adPlusId]['qty']--;
					$this->items[$adPlusId]['price'] -= $itemprice;
					$this->totalQty--;
					$this->totalPrice -= $itemprice;
					unset($this->items[$adPlusId]);
				return 'removed';
			}
		}
		$storedItem['qty']++;
		$storedItem['price'] = $mainprice * $storedItem['qty'];
		$this->items[$adPlusId] = $storedItem;
		$this->totalQty++;
		$this->totalPrice += $mainprice;
		
		return 'added';  
	}

	public function removePrintmediaCartItem($id, $printMedia)
	{
		if($this->items){
			if(array_key_exists($id, $this->items)){
				$mediaprice = ($printMedia === 'magazine') ? $this->items[$id]['item']['price_value'] : $mediaprice = $this->items[$id]['item']['total_price'];
				$this->totalQty--;
				$this->items[$id]['qty']--;
				if($printMedia === 'magazine'){
					$this->totalPrice -= $mediaprice;
					$this->items[$id]['price'] -= $mediaprice;
				}else{
					$this->totalPrice -= $mediaprice * $this->items[$id]['qty'] * $this->items[$id]['width'] * $this->items[$id]['height'];
					$this->items[$id]['price'] -= $mediaprice * $this->items[$id]['qty'] * $this->items[$id]['width'] * $this->items[$id]['height'];
				}
				unset($this->items[$id]);
			}
		}
	}

		public function UpdatePrintmediaCartQty($item, $itemskey, $parameter, $printMedia)
		{
			$count = $parameter['count'];
			if($printMedia === 'magazine'){
				$duration = $parameter['duration'];
				$mediaprice = $this->items[$itemskey]['item']['price_value'];
				$this->items[$itemskey]['duration'] = $duration;
				$this->items[$itemskey]['price'] = $mediaprice * $count;
			}else{
				$width = $parameter['width'];
				$height = $parameter['height'];
				$mediaprice = $this->items[$itemskey]['item']['total_price'];
				$this->items[$itemskey]['width'] = $width;
				$this->items[$itemskey]['height'] = $height;
				$this->items[$itemskey]['price'] = $mediaprice * $count * $width * $height;
			}
			$this->items[$itemskey]['qty'] = $count;
			$price = 0;
			foreach($this->items as $itm){
				$price += $itm['price'];
			}
			$this->totalPrice = $price;
			
	   }

	   public function addorRemoveMetro($item, $id, $model)
	{   
			
		$adPlusId = $model.'_'.$item['price_key'].'_'.$id;
		$storedItem = ['qty' => 0, 'price' => $item['totalprice'], 'duration' => 1, 'item' => $item];
		if($this->items){
			if(array_key_exists($adPlusId, $this->items)){
					$this->items[$adPlusId]['qty']--;
					$this->items[$adPlusId]['price'] -= $this->items[$adPlusId]['item']['totalprice'];
					$this->totalQty--;
					$this->totalPrice -= $this->items[$adPlusId]['item']['totalprice'];
					unset($this->items[$adPlusId]);
				return 'removed';
			}
		}
		$storedItem['qty']++;
		$storedItem['price'] = $item['totalprice'] * $storedItem['qty'];
		$this->items[$adPlusId] = $storedItem;
		$this->totalQty++;
		$this->totalPrice += $item['totalprice'];
		
		return 'added';  
	}

	public function removeMetroCartItem($id)
		{
			if($this->items){
				if(array_key_exists($id, $this->items)){
					$checkKey = explode('_', $id);
					$this->totalQty--;
					if($this->items[$id]['duration'] > 0){
						$this->totalPrice -= $this->items[$id]['item']['totalprice'] * $this->items[$id]['qty'] * $this->items[$id]['duration'];    
					}else{
						$this->totalPrice -= $this->items[$id]['item']['totalprice'] * $this->items[$id]['qty'];
					}

					$this->items[$id]['qty']--;
					$this->items[$id]['price'] -= $this->items[$id]['item']['totalprice'];
					unset($this->items[$id]);
				
				}
			}
		}

	public function UpdateMetroCartQty($item, $itemskey, $count, $duration)
	{
		$checkKey = explode('_', $itemskey);
			
		   $price = 0;
			$this->items[$itemskey]['qty'] = $count;
			$this->items[$itemskey]['duration'] = $duration;
			 $this->items[$itemskey]['price'] = $this->items[$itemskey]['item']['totalprice'] * $count * $duration;

			foreach($this->items as $itm){
				$price += $itm['price'];
			}
			$this->totalPrice = $price;

	   
   }    
}
