<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Socialmediamarketings;

class SocialmediaController extends Controller
{
    public function getDashboardSocialmediaList(){
        $socialmedia_ads = Socialmediamarketings::all();
        return view('backend.mediatypes.socialmedias.socialmedia-list', ['socialmedia_ads' => $socialmedia_ads]);
    }
}
