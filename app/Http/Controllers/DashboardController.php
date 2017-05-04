<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Requests;
use App\User;
use App\Order;
use Auth;
use Image;
use App\Mainaddtype;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

class DashboardController extends Controller
{
    
    public function __construct()
    {
        $this->middleware('admin');
    }
    
    public function getDashboard()
    {
        $orders = Order::latest()->limit(10)->offset(0)->get();
        $orders->transform(function($order, $key){
            $order->cart = unserialize($order->cart);
            return $order;
        });
       
        return view('backend.admin.index', ['orders' => $orders]);
    }

   
}
