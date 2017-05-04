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

class UserController extends Controller
{

    public function __construct()
    {
        $this->middleware('admin', ['only' => ['getUsers']]);
    }

    public function getUsers()
    {
        
        $users = User::latest()->limit(10)->offset(0)->get();
       $users->transform(function($user, $key){
            $user->cart = unserialize($user->cart);
            return $user;
        });
       
        return view('backend.admin.users', ['users' => $users]);
    }
    
    public function getSignup(){
        return view('user.signup');
    }

    public function postSignup(Request $request){

        $this->validate( $request, [
            'email' => 'email|required|unique:users',
            'password' => 'required|min:5'
        ]);

        $user = new User([
            'email' => $request->input('email'),
            'password' => bcrypt($request->input('password'))
        ]);

        $user->save();

       // Auth::login();

        return redirect()->route('user.profile');

    }

    public function getSignin(){
        return view('user.signin');
    }

    public function postSignin(Request $request){

        $this->validate( $request, [
            'email' => 'email|required',
            'password' => 'required|min:5'
        ]);

        $user = new User([
            'email' => $request->input('email'),
            'password' => bcrypt($request->input('password'))
        ]);

        if(Auth::attempt(['email' => $request->input('email'), 'password' => $request->input('password')])){
            return redirect()->route('user.profile');
        }

        return redirect()->back();

    }

    public function getProfile(){
        $orders = Auth::user()->orders;
        $orders->transform(function($order, $key){
            $order->cart = unserialize($order->cart);
            return $order;
        });
        return view('user.profile', ['orders' => $orders]);
    }

    public function getLogout(){
        Auth::logout();
        return view('user.signin');
    }
}
