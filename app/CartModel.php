<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Sentinel;
use Session;

class CartModel extends Model{

	protected $table = "carts";

	protected $fillable = ['user_id', 'value'];

	/**
	 * this function finds an instance of user_id in the 'carts' table 
	 * @param  [int] $user_id [current user_id]
	 * @return [object]          returns the user information 
	 */
	public function get_value_by_user_id($user_id){
		$cart_info = $this->where('user_id', $user_id)->first();
		if(empty($cart_info)){
			return false;
		}
		$cart_val = unserialize($cart_info->value);
		return $cart_val;
	}

	/**
	 * Saving 
	 * @param  object $cart the cart value which is saved in session
	 */
	public function update_cart_in_db($user){
		$cart = Session::get('cart');

		$cart_model = $this::where('user_id', $user)->get();
		if($cart_model->isEmpty()){
			$cart_model = new CartModel;
			$cart_model->user_id = $user;
			$cart_model->value = serialize($cart);
			$cart_model->save();
		}else{
			$this->update_cart($user);
		}
	}

	public function update_cart($user){
		$updateCart = self::where('user_id', $user)->first();
		$updateCart->user_id = $user;
		$updateCart->value = serialize(Session::get('cart'));
		// dd(serialize(Session::get('cart')));
		// dd($updateCart);
		$updateCart->save();
	}

	// LOGIN CHECK FUNCTIONS

	/**
	 * This function invokes when use is tring to login and the **cart in session is not empty**.
	 * @param  int $user is user id to find the exsisting value in the cart.
	 * @return void       NULL
	 */
	public function login_update_db_from_cart($user){
		// Taking value from cart
		$cart = Session::get('cart');

		// searching for user cart in DB
		$cart_model = $this::where('user_id', $user)->first();
		
		if(empty($cart_model)){
			// Cart in DB is empty, have to make a new row!
			$cart_model_new = new CartModel;
			$cart_model_new->user_id = $user;
			$cart_model_new->value = serialize($cart);
			$cart_model_new->save();
		}else{
			// Cart in DB is not empty. Append the cart in DB with Session and add the DB cart in the session value! (May need to use the old_cart funtuonality in cart.php model)
			
			// Fetching cart value from the database.
			$db_cart_value = unserialize($cart_model->value);



			dd($db_cart_value);
		}
	}

	/**
	 * This function invokes when user tries to login but user session **cart is empty**.
	 * It basically checks of the user have any old value in the cart database. 
	 * If there is any value the db cart value will be transfer to session value.
	 * @param  int $user is user_id to find the cart value in the database.
	 * @return void       NULL
	 */
	public function login_update_cart_from_db($user){
		$cart_model = $this::where('user_id', $user)->first();
		// Cart is not set but DB have the value

		if(!empty($cart_model)){
			$cart_value = unserialize($cart_model->value);
			Session::put('cart', $cart_value);
		}

	}


	// ./LOGIN CHECK FUNCTIONS

	public function addInCart($item, $id, $model){
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
	}
}