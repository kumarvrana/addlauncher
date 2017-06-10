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
        if(!Sentinel::check()){
           return redirect()->route('user.signin');
        }
        
        $CheckoldCart = Session::has('cart') ? Session::get('cart') : null;
        if($CheckoldCart == null){
            return redirect()->route('cart.shoppingCart');
        }
        if(count($CheckoldCart->items) < 1){
            return redirect()->route('cart.shoppingCart');
        }
        $user = Sentinel::check();
        $oldcart = Session::get('cart');
        $cart = new Cart($oldcart);
        $totalPrice = $cart->totalPrice;
        
        return view('shop.checkout', ['products' => $cart->items, 'total' => $totalPrice, 'user' => $user]);
 
    }

     public function getThankyoupage($order)
     {
          if(!Sentinel::check()){
              return redirect()->route('user.signin');
          }
          $order_data = Order::find($order);
          $order_data_id= $order_data->user_id;
          if($order_data->order_viewed){
               return redirect('/');
          }else{
              $order_data->order_viewed = 1;
              $order_data->save();
          }
          
          $user = Sentinel::getUser();
          $user_data_id=$user->id;
          
          if ( $order_data_id == $user_data_id ) {

               $aftercashpayment = PaymentSetting::find(2);
               return view('shop.thankyou', ['orders' => $order_data, 'settings'=> $aftercashpayment]);
               
          }
          else{
                return redirect('/');
          }
         
         

     }
    
    public function getPaymentmethod($paymentMethod)
    {
        if(!Sentinel::check()){
           return redirect()->route('user.signin');
        }

        $CheckoldCart = Session::has('cart') ? Session::get('cart') : null;
        if($CheckoldCart == null){
            return redirect()->route('cart.shoppingCart');
        }
        if(count($CheckoldCart->items) < 1){
            return redirect()->route('cart.shoppingCart');
        }
        $oldcart = Session::get('cart');
        $cart = new Cart($oldcart);
        $totalPrice = $cart->totalPrice;
        
       Switch($paymentMethod){
           case 'transfer-money':
                $settings = PaymentSetting::find(2);
                return view('shop.checkoutByCash', ['products' => $cart->items, 'total' => $totalPrice, 'payMethod' => $paymentMethod, 'settings' => $settings]);
           break;
           case 'stripe-payment':
                $settings = PaymentSetting::find(19);
                return view('shop.checkoutByStripe', ['products' => $cart->items, 'total' => $totalPrice, 'payMethod' => $paymentMethod, 'settings' => $settings ]);
           break;
           case 'cirtus-payment':
                
                 $settings = PaymentSetting::find(14);
                
                return view('shop.checkoutByCirtus', ['products' => $cart->items, 'total' => $totalPrice, 'payMethod' => $paymentMethod, 'settings' => $settings]);
           break;
           default:
                 $settings = PaymentSetting::find(2);
                return view('shop.checkoutByCash', ['products' => $cart->items, 'total' => $totalPrice, 'payMethod' => $paymentMethod, 'settings' => $settings]);
        }
        
    }
    public function postCheckoutSwitch(Request $request)
    {
       
        $paymentMethod = $request->input('adl-payment');
        switch($paymentMethod){
            case 'cash-transfer':
                $order = $this->postCheckoutCashtransfer($request->all());
            break;
            case 'stripe-payment':
                if($request->input('stripeToken') == ''){
                    return redirect()->back()->with('message', 'Stripe payment is not completed. Please Complete Stripe payement!');
                }
                $order = $this->postCheckout($request->all());
            break;
            case 'cirtus-payment':
                 $order = $this->paymentBycirtus($request->all());
            break;
        }
        return redirect()->route('order.thankyou', ['order' => $order]);
    }
    
    public function postCheckoutCashtransfer($requestForm)
    {
       
        if(!Sentinel::check()){
           return redirect()->route('user.signin');
        }

        $user = Sentinel::getUser();
             
        $CheckoldCart = Session::has('cart') ? Session::get('cart') : null;
        if($CheckoldCart == null){
            return redirect()->route('cart.shoppingCart');
        }
        if(count($CheckoldCart->items) < 1){
            return redirect()->route('cart.shoppingCart');
        }

        $oldcart = Session::get('cart');
        $cart = new Cart($oldcart);
       
        $order = new Order();
        $order->cart = serialize($cart);
        $order->name = $requestForm['first-name']." ". $requestForm['last-name'];
        $order->address = $requestForm['address']." ".$requestForm['street']." ".$requestForm['city']." ".$requestForm['country']." INDIA-".$requestForm['zip-code'];
        $order->payment_id = uniqid();
        $order->payment_method = 'cash transfer';
        $order->payment_status = 'Awaiting Payment';
        $order->order_status = 'Pending';
        Sentinel::getUser()->orders()->save($order);
       
        $order_data = Order::find($order->id);
        $this->sendEmail($user, $order_data);
       
        Session::forget('cart');
        return $order_data;
        
    }
    public function postCheckout($requestForm)
    {
        if(!Sentinel::check()){
           return redirect()->route('user.signin');
        }
        
        $user = Sentinel::getUser();
             
        $CheckoldCart = Session::has('cart') ? Session::get('cart') : null;
        if($CheckoldCart == null){
            return redirect()->route('cart.shoppingCart');
        }
        if(count($CheckoldCart->items) < 1){
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
                "source" => $requestForm['stripeToken'], // obtained with Stripe.js
                "description" => "Payment Done"
            ));

            $order = new Order();
            $order->cart = serialize($cart);
            $order->name = $requestForm['first-name']." ". $requestForm['last-name'];
            $order->address = $requestForm['address']." ".$requestForm['street']." ".$requestForm['city']." ".$requestForm['country']." INDIA-".$requestForm['zip-code'];
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
        return $order_data;
        
         
    }

    public function paymentBycirtus($requestForm)
    {
        if(!Sentinel::check()){
           return redirect()->route('user.signin');
        }
        
        $CheckoldCart = Session::has('cart') ? Session::get('cart') : null;
        if($CheckoldCart == null){
            return redirect()->route('cart.shoppingCart');
        }
        if(count($CheckoldCart->items) < 1){
            return redirect()->route('cart.shoppingCart');
        }

        $oldcart = Session::get('cart');
        $cart = new Cart($oldcart);

        if($requestForm['TxStatus'] !== 'SUCCESS' && $requestForm['pgRespCode'] !== 0 ){
            $fail_message = $requestForm['pgRespCode'].":".$requestForm['TxStatus']." ".$requestForm['TxMsg'];
            return redirect()->back()->with('error', $fail_message);
        }

        if($requestForm['TxStatus'] == 'SUCCESS' && $requestForm['pgRespCode'] == 0 ){
            $order = new Order();
            $order->cart = serialize($cart);
            $order->name = $requestForm['firstName'];
            $order->address = $requestForm['addressStreet1']." ".$requestForm['addressCity']." ".$requestForm['addressState']." ".$requestForm['addressCountry']." ".$requestForm['addressZip'];
            $order->payment_id = $requestForm['TxId'];
            $order->payment_method = 'citrus';
            $order->payment_status = 'Awaiting Payment';
            $order->order_status = 'Pending';
            Sentinel::getUser()->orders()->save($order);
            $last_orderID = $order->id;
            $order_data = Order::find($last_orderID);
            $this->sendEmail($user, $order_data);

        }

        Session::forget('cart');
        return $order_data;
        
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
