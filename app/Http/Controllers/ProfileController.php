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

class ProfileController extends Controller
{
    public function getProfile(){
        $orders = Sentinel::getUser()->orders;
        $orders->transform(function($order, $key){
            $order->cart = unserialize($order->cart);
            return $order;
        });
        return view('shop.user.profile', ['orders' => $orders]);
    }
}
