<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\User;
use App\Cart;
use App\Order;
use Session;
use Stripe\Charge;
use Stripe\Stripe;
use Auth;
use Sentinel;
use Mail;
use App\PaymentSetting;

class CheckoutController extends Controller
{
     
    
     public function  getpayment()
     {
        if(!Session::has('cart')){
            return view('shop.shopping-cart');
        }
        $oldcart = Session::get('cart');
        $cart = new Cart($oldcart);
        $totalPrice = $cart->totalPrice;

        return view('shop.checkout', ['products' => $cart->items, 'total' => $totalPrice]);
 
    }
    public function postPaymentmethod(Request $request){
        if(!Session::has('cart')){
            return view('shop.shopping-cart');
        }
        $oldcart = Session::get('cart');
        $cart = new Cart($oldcart);
        $totalPrice = $cart->totalPrice;
        
       Switch($request['payment-method']){
           case 'Transfer Money':
                $settings = PaymentSetting::find(2);
                return view('shop.checkoutByCash', ['products' => $cart->items, 'total' => $totalPrice, 'payMethod' => $request['payment-method'], 'settings' => $settings]);
           break;
           case 'Stripe Payment':
                $settings = PaymentSetting::find(19);
                return view('shop.checkoutByStripe', ['products' => $cart->items, 'total' => $totalPrice, 'payMethod' => $request['payment-method'], 'settings' => $settings ]);
           break;
           case 'Cirtus Payment':
                
                 $settings = PaymentSetting::find(14);
                
                return view('shop.checkoutByCirtus', ['products' => $cart->items, 'total' => $totalPrice, 'payMethod' => $request['payment-method'], 'settings' => $settings]);
           break;
           default:
                 $settings = PaymentSetting::find(2);
                return view('shop.checkoutByCash', ['products' => $cart->items, 'total' => $totalPrice, 'payMethod' => $request['payment-method'], 'settings' => $settings]);
        }
        
    }
    public function postCheckoutCashtransfer(Request $request)
    {
       
        $user = Sentinel::getUser();
             
        if(!Session::has('cart')){
            return redirect()->route('cart.shoppingCart');
        }

        $oldcart = Session::get('cart');
        $cart = new Cart($oldcart);
       
        $order = new Order();
        $order->cart = serialize($cart);
        $order->name = $request->input('name');
        $order->address = $request->input('address')." ".$request->input('city')." ".$request->input('state')." ".$request->input('country')."-".$request->input('zip_code');
        $order->payment_id = $charge->id;
        $order->payment_method = 'cash transfer';
        $order->payment_status = 'Awaiting Payment';
        $order->order_status = 'Pending';
        Sentinel::getUser()->orders()->save($order);
        $last_orderID = $order->id;

        $order_data = Order::find($last_orderID);
        $this->sendEmail($user, $order_data);

       
        Session::forget('cart');
        return view('shop.thankYou', ['order' => $order_data]);

    }
    public function postCheckout(Request $request)
    {
       
        $user = Sentinel::getUser();
             
        if(!Session::has('cart')){
            return redirect()->route('cart.shoppingCart');
        }

        $oldcart = Session::get('cart');
        $cart = new Cart($oldcart);
        $settings = PaymentSetting::find(19);
        $setting = unserialize($settings->payment_secret);
        Stripe::setApiKey($setting['secretkey']);

        try{

        $charge = Charge::create(array(
                "amount" => $cart->totalPrice * 100,
                "currency" => "INR",
                "source" => $request->input('stripeToken'), // obtained with Stripe.js
                "description" => "Payment Done"
            ));

            $order = new Order();
            $order->cart = serialize($cart);
            $order->name = $request->input('name');
            $order->address = $request->input('address')." ".$request->input('city')." ".$request->input('state')." ".$request->input('country')."-".$request->input('zip_code');
            $order->payment_id = $charge->id;
            $order->payment_method = 'stripe';
            $order->payment_status = 'Awaiting Payment';
            $order->order_status = 'Pending';
            Sentinel::getUser()->orders()->save($order);
            $last_orderID = $order->id;

            $order_data = Order::find($last_orderID);
            $this->sendEmail($user, $order_data);

        }catch(Exception $e){
            return redirect()->back()->with('error', $e->getMessage());
        }
    

        Session::forget('cart');
        return redirect()->route('order.thankyou', ['order' => $order_data ]);
        //return view('shop.thankYou', ['order' => $order_data]);
         
    }

    public function paymentBycirtus(Request $request)
    {

        if(!Session::has('cart')){
            return redirect()->route('cart.shoppingCart');
        }

        $oldcart = Session::get('cart');
        $cart = new Cart($oldcart);

        if($request['TxStatus'] !== 'SUCCESS' && $request['pgRespCode'] !== 0 ){
            $fail_message = $request['pgRespCode'].":".$request['TxStatus']." ".$request['TxMsg'];
            return redirect()->back()->with('error', $fail_message);
        }

        if($request['TxStatus'] == 'SUCCESS' && $request['pgRespCode'] == 0 ){
            $order = new Order();
            $order->cart = serialize($cart);
            $order->name = $request['firstName'];
            $order->address = $request['addressStreet1']." ".$request['addressCity']." ".$request['addressState']." ".$request['addressCountry']." ".$request['addressZip'];
            $order->payment_id = $request['TxId'];
            $order->payment_method = 'citrus';
            $order->payment_status = 'Awaiting Payment';
            $order->order_status = 'Pending';
            Sentinel::getUser()->orders()->save($order);
            $last_orderID = $order->id;
            $order_data = Order::find($last_orderID);
            $this->sendEmail($user, $order_data);

        }

        Session::forget('cart');
        return redirect()->route('order.thankyou', ['order' => $order_data ]);
        //$this->getThankyoupage($order_data);
    }
     public function getThankyoupage($order)
     {
         $order_data = Order::find($order);
         return redirect()->route('order.thankyou', ['order' => $order_data]);
     }
     private function sendEmail($user, $order)
     {
         Mail::send('emails.order', [
             'user' => $user,
             'order' => $order
         ], function($message) use($user){
             $message->to($user->email);
             $message->subject("Hello $user->first_name Adlauncher order details.");
         });
     }
}
