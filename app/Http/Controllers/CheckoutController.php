<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Cart;
use App\Order;
use Session;
use Stripe\Charge;
use Stripe\Stripe;
use Auth;
use Sentinel;

class CheckoutController extends Controller
{
     public function getCheckout()
     {
        if(!Session::has('cart')){
            return view('shop.shopping-cart');
        }
        $oldcart = Session::get('cart');
        $cart = new Cart($oldcart);
        $totalPrice = $cart->totalPrice;

        return view('shop.checkout', ['products' => $cart->items, 'total' => $totalPrice]);
 
    }

    public function postCheckout(Request $request)
    {
        if(!Session::has('cart')){
            return redirect()->route('cart.shoppingCart');
        }

        $oldcart = Session::get('cart');
        $cart = new Cart($oldcart);

        Stripe::setApiKey('sk_test_WWbimeDRbYGvAPXN82kbumcR');

        try{

           $charge = Charge::create(array(
                "amount" => $cart->totalPrice * 100,
                "currency" => "INR",
                "source" => $request->input('stripeToken'), // obtained with Stripe.js
                "description" => "Test Charge"
            ));

            $order = new Order();
            $order->cart = serialize($cart);
            $order->name = $request->input('name');
            $order->address = $request->input('address');
            $order->payment_id = $charge->id;
            Sentinel::getUser()->orders()->save($order);

         }catch(Exception $e){
            return redirect()->route('checkout')->with('error', $e->getMessage());
        }

        Session::forget('cart');
        return redirect()->route('product.mainCats')->with('success', 'Successfully Order!');

    }
}
