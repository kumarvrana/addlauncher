<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Cart;
use Session;

class CartController extends Controller
{
    
    // get the shoping getCart
    public function getCart()
    {
        if(!Session::has('cart')){
            return view('shop.shopping-cart');
        }else{
            $oldcart = Session::get('cart');
            $cart = new Cart($oldcart);
            return view('shop.shopping-cart', ['products' => $cart->items, 'totalPrice' => $cart->totalPrice ]);
        }
    }
    
    //remove item from the cart using index id
    public function removeItemFromCart($id)
    {
        $oldCart = Session::has('cart') ? Session::get('cart') : null;
        $cart = new Cart($oldCart);
        $cart->removeCartItem($id);

        Session::put('cart', $cart);
        
        return redirect()->back();
    }
}
