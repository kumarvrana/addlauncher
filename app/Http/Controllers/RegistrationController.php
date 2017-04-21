<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Requests;
use Sentinel;
use Activation;
use App\User;
use Mail;

class RegistrationController extends Controller
{
    
    public function getSignup()
    {
        return view('shop.user.signup');
    }

     public function postSignup(Request $request)
     {
        
        $this->validate( $request, [
           'email' => 'required|email|unique:users',
           'first_name' => 'required',
           'last_name' => 'required',
           'phone_number' => 'required',
           'password' => 'required|min:8|confirmed'
           
        ]);

        $user = Sentinel::register($request->all());

        $activation = Activation::create($user);

        $role = Sentinel::findRoleBySlug('site-user');

        $role->users()->attach($user);

        $this->sendEmail($user, $activation->code);
       
        return redirect()->route('user.signin')->with('message', 'Sucessfully Register, but you have to activate your account!!');
        
     }

     private function sendEmail($user, $code)
     {
         Mail::send('emails.activation', [
             'user' => $user,
             'code' => $code
         ], function($message) use($user){
             $message->to($user->email);
             $message->subject("Hello $user->first_name activate your account.");
         });
     }
}
