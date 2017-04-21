<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Mail;
use App\Generalsettings;
use Illuminate\Support\Facades\DB;



class ContactFormController extends Controller
{


    public function GetContactForm()
    {

         $generalsetting = DB::table('generalsettings')
                ->where('id', '=', 1)
                ->first();
        return view('partials.contact-us')->with('general', $generalsetting);
     }   
    //post and mail contact form
    public function PostContactForm(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email',
            'phone' => 'required|numeric',
            'message' => 'required'
        ]);

        $this->sendEmailVisiter($request->all());
        $this->sendEmailAdmin($request->all());

        return response()->json(['msg' => '<b>Thank You for Choosing us.</b> We will contact you shortly.'], 200);
        
    }
    private function sendEmailVisiter($requestContact)
    {    
         Mail::send('emails.contact', [
             'userEmail' => $requestContact['email'],
             'userName' => $requestContact['name']
         ], function($message) use($requestContact){
             $message->to($requestContact['email']);
             $message->subject("Hi Guest contact you shortly.");
         });
    }

    private function sendEmailAdmin($requestContact)
    {
         Mail::send('emails.contactAdmin', [
             'userEmail' => $requestContact['email'],
             'userName' => $requestContact['name'],
             'userPhone' => $requestContact['phone'],
             'userMessage' => $requestContact['message']
         ], function($message) use($requestContact){
             $message->to('aed.vinod@gmail.com');
             $message->replyTo($requestContact['email'], $requestContact['name']);
             $message->subject("Hi Admin please check query from Guest");
         });
    }
}
