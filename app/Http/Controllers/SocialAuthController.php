<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Sentinel;
use Activation;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Providers\SocialAccountService;
use Socialite;
use Illuminate\Support\Facades\Auth;
use App\User;
class SocialAuthController extends Controller
{
    public function redirect($loginWith)
    {
        return Socialite::driver($loginWith)->redirect();   
    }   

    public function callback(SocialAccountService $service, $loginWith)
    {
        $user = $service->createOrGetUser(Socialite::driver($loginWith)->user(), $loginWith);

        Sentinel::loginAndRemember($user);

        return redirect()->to('/');
    }
}