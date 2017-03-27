<?php

namespace App\Http\Controllers;
use Illuminate\Http\Response;
use App\Http\Requests;
use Sentinel;
use Activation;
use App\User;
use Cartalyst\Sentinel\Checkpoints\ThrottlingException;
use Cartalyst\Sentinel\Checkpoints\NotActivatedException;

use Illuminate\Http\Request;

class LoginController extends Controller
{
     public function getSignin()
    {
        return view('shop.user.signin');
    }

     public function postSignin(Request $request)
     {
       
        $this->validate( $request, [
           'email' => 'required|email',
           'password' => 'required'
        ]);
       
        try{
            $rememberMe = false;
            if(isset($request->remember_me))
                $rememberMe = true;
            if(Sentinel::authenticate($request->all(), $rememberMe))
            {
                $slug = Sentinel::getUser()->roles()->first()->slug;

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

     public function postLogout()
     {
         Sentinel::logout();
         return redirect()->route('user.signin');
     }
}
