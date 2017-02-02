<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Requests;
use App\User;
use Auth;
use Image;
use App\Mainaddtype;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

class DashboardController extends Controller
{
    public function getDashboard(){
        return view('backend.admin.index');
    }

   
}
