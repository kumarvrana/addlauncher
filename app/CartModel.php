<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Sentinel;
use Session;
use Auth;

class CartModel extends Model{

	protected $table = "carts";

	protected $fillable = ['user_id', 'value'];

	private $cartVariable;

	/**
	 * this function finds an instance of user_id in the 'carts' table 
	 * @param  [int] $user_id [current user_id]
	 * @return [object]          returns the user information 
	 */
	public function get_value_by_user_id($userId){
		$cartInfo = $this->where('user_id', $userId)->first();
		if(empty($cartInfo)){
			return false;
		}
		$cartVal = unserialize($cartInfo->value);
		return $cartVal;
	}

	/**
	 * Saving Cart value in database from session 
	 * @param  object $cart the cart value which is saved in session
	 */
	public function update_cart_in_db($userId){
		$cartModel = $this::where('user_id', $userId)->get();
		$cart = Session::get('cart');
		if($cartModel->isEmpty()){
			$cartModel = new CartModel;
			$cartModel->user_id = $userId;
			$cartModel->value = serialize($cart);
			$cartModel->save();
		}else{
			$this->update_cart($userId);
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
	 * This function invokes when user tries to login but user session **cart is empty**.
	 * It basically checks of the user have any old value in the cart database. 
	 * If there is any value the db cart value will be transfer to session value.
	 * @param  int $user is user_id to find the cart value in the database.
	 * @return void       NULL
	 */
	public function login_update_cart_from_db($user){
		$cart_model = $this::where('user_id', $user)->first();

		if(!empty($cart_model)){
			// Cart is not set but DB have the value
			$cart_value = unserialize($cart_model->value);
			Session::put('cart', $cart_value);
		}

	}

	/**
	 * This function invokes when use is tring to login and the **cart in session is not empty**.
	 * @param  int $user is user id to find the exsisting value in the cart.
	 * @return void       NULL
	 */
	public function login_update_db_from_cart($user){
		// Taking value from cart
		$cart = Session::get('cart');

		// searching for user cart in DB
		$cartModel = $this::where('user_id', $user)->first();
		
		if(empty($cartModel)){
			// Cart in DB is empty, have to make a new row!
			$cartModel_new = new CartModel;
			$cartModel_new->user_id = $user;
			$cartModel_new->value = serialize($cart);
			$cartModel_new->save();
		}else{
			// Cart in DB is not empty. Append the cart in DB with Session and add the DB cart in the session value! (May need to use the old_cart funtuonality in cart.php model)
			// Fetching cart value from the database.
			$this->cartVariable = unserialize($cartModel->value);
			// dd($this->cartVariable, $cart);
			foreach($cart->items as $key => $value){
				$this->addInCart($key, $value);
			}
			$cartModel->value = serialize($this->cartVariable);
			$cartModel->save();
			Session::put('cart', $this->cartVariable);
			// dd($this->cartVariable, $cart, $cartModel->value);
		}
	}

	// ./LOGIN CHECK FUNCTIONS END
	private function addInCart($key, $value){
		if(isset($this->cartVariable->items[$key])){
			// This product DOES exsits in database too.
			$this->cartVariable->totalPrice -= $this->cartVariable->items[$key]['price'];
			$this->cartVariable->totalPrice += $value['price'];
			$this->cartVariable->items[$key] = $value;
		}else{
			// This product DOESN'T exsits in database.
			$this->cartVariable->items[$key] = $value;
			$this->cartVariable->totalQty++;
			$this->cartVariable->totalPrice += $value['price'];
		}
	}
}