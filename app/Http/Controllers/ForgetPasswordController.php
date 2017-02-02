<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Mail;
use Sentinel;
use Reminder;
use App\User;

class ForgetPasswordController extends Controller
{
    
    public function getForgetPassword()
    {
        return view('user.forgetpassword');
    }

    public function postForgetPassword(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|email'
        ]);

        $user = User::whereEmail($request->email)->first();
        

        if(count($user) == 0){
            return redirect()->back()->with(['message' => 'Reset Code is sent successfully to your email.']);
        }

        //$sentinelUser = Sentinel::findById($user->id);

        
        $reminder = Reminder::exists($user) ?: Reminder::create($user);

        $this->sendMail($user, $reminder->code);

        return redirect()->back()->with(['message' => 'Reset Code is sent successfully to your email.']);

    }

    public function resetPassword($email, $code)
    {
        $user = User::byEmail($email);
        
        //$sentinelUser = Sentinel::findById($user->id);

        if(count($user) == 0)
            abort(404);
        
        if($reminder = Reminder::exists($user))
        {
            if($code == $reminder->code)
                return view('user.resetpassword');
            else
                return redirect('/');
        }    
        else
            return redirect('/');
    }

    public function postResetPassword(Request $request, $email, $code)
    {
        $this->validate($request,[
            'password' => 'required|min:8|confirmed',
            'password_confirmation' => 'required|min:8'
        ]);

         $user = User::byEmail($email);
        //$sentinelUser = Sentinel::findById($user->id);

        if(count($user) == 0)
            abort(404);
        
        if($reminder = Reminder::exists($user))
        {
            if($code == $reminder->code)
            {
                Reminder::complete($user, $code, $request->password);
                return redirect()->route('user.signin')->with('message', 'Please login with new password.');
            }           
            else
                return redirect('/');
        }    
        else
            return redirect('/');
    }

    private function sendMail($user, $code)
    {
        
        Mail::send('emails.forgetpassword', [
            'user' => $user,
            'code' => $code
        ], function($message) use($user){

            $message->to($user->email);

            $message->subject("Hello $user->first_name, reset your password.");

        });
    }
}
