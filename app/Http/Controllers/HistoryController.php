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

class HistoryController extends Controller
{
    public function getHistory($id)
    {
        
        $orders = Order::where('user_id', '=',$id)->latest()->paginate(10);
        $orders->transform(function($orders, $key){
            $orders->cart = unserialize($orders->cart);
            return $orders;
        });
        
        return view("backend.admin.history", ['orders' => $orders]);
    }

   
}
