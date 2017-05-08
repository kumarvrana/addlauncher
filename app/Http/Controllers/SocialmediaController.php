<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Socialmediamarketings;

class SocialmediaController extends Controller
{
    public function getfrontendAllSocialmediaads(){
        $socialmedia_ads = Socialmediamarketings::all();

         if($socialmedia_ads->isEmpty())
         {

			return view('partials.comingsoon');

         } else {

           return view('frontend-mediatype.socialmedias.socilamediaads-list', ['socialmedia_ads' => $socialmedia_ads]);
         }
    }
}

