<?php

namespace App\Http\Controllers;
use Illuminate\Http\Response;
use App\Http\Requests;
use Sentinel;
use Activation;
use App\User;
use App\AuthenticateUser;
use Cartalyst\Sentinel\Checkpoints\ThrottlingException;
use Cartalyst\Sentinel\Checkpoints\NotActivatedException;
use Socialite;
use Illuminate\Http\Request;
use Session;
use App\CartModel;
use Cart;
//use App\AuthUserListenerInterface;

class LoginController extends Controller{

     public function getSignin(){
        if(Sentinel::check())
             return redirect()->back();

         return view('shop.user.signin');
     }

     public function postSignin(Request $request){
       
        if(Sentinel::check())
             return redirect()->back();
                     
        $this->validate( $request, [
           'email' => 'required|email',
           'password' => 'required'
        ]);
       
        try{
            $rememberMe = false;
            if(isset($request->remember_me))
                $rememberMe = true;
            if($user = Sentinel::authenticate($request->all(), $rememberMe)){
                $slug = Sentinel::getUser()->roles()->first()->slug;
                
                $cart_model = new CartModel;
                if(Session::has('cart')){
                    // If user have something in cart before login (SESSION)
                    $cart_model->login_update_db_from_cart($user->id);
                }else{
                    // If user doesn't have anything in the cart (NO SESSION)
                    $cart_model->login_update_cart_from_db($user->id);
                }
                
                if($slug == 'admin')
                    return redirect('/dashboard');//return response()->json(['redirect' => '/dashboard']);
                elseif($slug == 'site-user')
                     return redirect('/');//return response()->json(['redirect' => '/']);
            }
            else
            {
                return redirect()->back()->with(['error' => 'Wrong Credentials']);//return response()->json(['error' => 'Wrong Credentials'], 500);
            }
        } catch(ThrottlingException $e)
        {
            $delay = $e->getDelay();
            return redirect()->back()->with(['error' => "You are banned for $delay seconds."]);//return response()->json(['error' => "You are banned for $delay seconds."], 500);
        } catch(NotActivatedException $e)
        {
               return redirect()->back()->with(['error' => "You are not activated yet!"]);//return response()->json(['error' => "You are not activated yet!"], 500);
        }
       
        
     }

     public function postLogout(Request $request)
     {
         Sentinel::logout();
         Session::forget('cart');
         return redirect()->route('user.signin');
     }

     
}
