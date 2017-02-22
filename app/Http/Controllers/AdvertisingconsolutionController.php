<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Advertisingconsolution;

class AdvertisingconsolutionController extends Controller
{
    public function getDashboardAdvertisingconsolutionList(){
        $advertisingconsolution_ads = Advertisingconsolution::all();
        return view('backend.mediatypes.advertisingconsolution.advertisingconsolution-list', ['advertisingconsolution_ads' => $advertisingconsolution_ads]);
    }
}
