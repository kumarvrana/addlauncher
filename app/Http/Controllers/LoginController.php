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
        return view('user.signin');
    }

     public function postSignin(Request $request)
     {
        $this->validate( $request, [
           'email' => 'required|email',
           'password' => 'required'
        ]);
        try{
            if(Sentinel::authenticate($request->all()))
            {
                $slug = Sentinel::getUser()->roles()->first()->slug;

                if($slug == 'admin')
                    return redirect('/dashboard');
                elseif($slug == 'site-user')
                    return redirect('/');
            }
            else
            {
                return redirect()->back()->with(['error' => 'Wrong Credentials']);
            }
        } catch(ThrottlingException $e)
        {
            $delay = $e->getDelay();
            return redirect()->back()->with(['error' => "You are banned for $delay seconds."]);
        } catch(NotActivatedException $e)
        {
                return redirect()->back()->with(['error' => "You are not activated yet!"]);
        }
       

       
        
        //return redirect()->route('product.mainCats')->with('message', 'Sucessfully login!!');
        
     }

     public function postLogout()
     {
         Sentinel::logout();
         return redirect()->route('user.signin');
     }
}
