<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Sentinel;
use Activation;
use App\User;

class ActivationController extends Controller
{
    public function activate($email, $activationCode)
    {
        $user = User::whereEmail($email)->first();

        //$sentinelUser = Sentinel::findById($user->id);

        if(Activation::complete($user, $activationCode))
        {
            return redirect()->route('user.signin');
        }
        else
        {
            return redirect('/');
        }

    }
}
