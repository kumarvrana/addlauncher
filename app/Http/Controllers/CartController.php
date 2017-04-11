<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Cart;
use Session;
use Sentinel;

class CartController extends Controller
{
    
    // get the shoping getCart
    public function getCart()
    {
        if(!Sentinel::check()){
           return redirect()->route('user.signin');
        }
       
       if(!Session::has('cart')){
            return view('shop.shopping-cart');
        }else{
            $oldcart = Session::get('cart');
            $cart = new Cart($oldcart);
            $mediaType = array();
            foreach((array)$cart->items as $items){
                $key = array_search($items, (array)$cart->items);
                $mediaTypes = explode('_', $key);
                $mediaType[] = $mediaTypes[0];
            }
        
            return view('shop.shopping-cart', ['products' => $cart->items, 'totalPrice' => $cart->totalPrice, 'mediaTypes' => $mediaType]);
        }
        
    }
    
    //remove item from the cart using index id
    public function removeItemFromCart($id)
    {
        if(!Sentinel::check()){
           return redirect()->route('user.signin');
        }

        $oldCart = Session::has('cart') ? Session::get('cart') : null;
        $cart = new Cart($oldCart);
        $cart->removeCartItem($id);

        Session::put('cart', $cart);
        
        return redirect()->back();
    }
    // remove item form payment page bu using index id
    public function removeItemFromCartpayment($id, $page)
    {
        if(!Sentinel::check()){
           return redirect()->route('user.signin');
        }

        $oldCart = Session::has('cart') ? Session::get('cart') : null;
        $cart = new Cart($oldCart);
        $cart->removeCartItem($id);

        Session::put('cart', $cart);
        $checkEmptyCart = Session::get('cart');
        if(count($checkEmptyCart->items) < 1){
            return redirect()->route('cart.shoppingCart');
        }
        return redirect()->back();
    }
    //update cart quantity and duration by item id
    public function updateCart(){
        
        if(!Sentinel::check()){
           return redirect()->route('user.signin');
        }

        $itemId = $_REQUEST['item'];
        $count = $_REQUEST['count'];
        $oldCart = Session::has('cart') ? Session::get('cart') : null;
        $cart = new Cart($oldCart);

        $cart->UpdateCartQty((array)$cart, $itemId, $count);
        Session::put('cart', $cart);
        $cart = (array)$cart;
        
        return response()->json(['subtotal' => $cart['items'][$itemId]['price'], 'total' => $cart['totalPrice']], 200);
    }
}
