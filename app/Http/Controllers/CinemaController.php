<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use Session;
use App\Cinemas;
use App\Cinemasprice;
use Image;
use App\Product;
use Illuminate\Support\Facades\File;
use App\Cart;
use App\Order;


class CinemaController extends Controller
{
    
    //frontend function starts
    
    public function getfrontendAllCinemaads()
    {
       $cinema_ads = Cinemas::all();
       return view('frontend-mediatype.cinemas.cinemaads-list', ['products' => $cinema_ads]);
    }
    
    public function getfrontCinemaad($id)
    {
        $cinemaad = Cinemas::find($id);
        $cinemaprice = Cinemasprice::where('cinemas_id', $id)->get();
        return view('frontend-mediatype.cinemas.cinema-single', ['cinemaad' => $cinemaad, 'cinemaprice' => $cinemaprice]);
    }
    
    
    // frontend functions ends

    //Backend functions below


    // get list of all the products in cinema stop media type
    public function getDashboardCinemaList(){
        $cinema_ads = Cinemas::all();
        return view('backend.mediatypes.cinemas.cinema-list', ['cinema_ads' => $cinema_ads]);
    }
    
    // get form of cinema stop media type
     public function getDashboardCinemaForm()
    {
        return view('backend.mediatypes.cinemas.cinema-addform');
    }

    // post list of all the products in cinema media type

    public function postDashboardCinemaForm(Request $request)
    {
         
        $this->validate( $request, [
           'title' => 'required',
           'price' => 'numeric',
           'image' => 'required|image',
           'location' => 'required',
           'state' => 'required',
           'city' => 'required',
           'rank' => 'numeric',
           'description' => 'required',
           'status' => 'required',
           'audiseats' => 'numeric',
           'audinumber' => 'numeric',
           'cinemanumber' => 'numeric',
           'cinemadiscount' => 'numeric'
           
        ]);

        if($request->hasFile('image')){
            $file = $request->file('image');
            $filename = time() .'.'. $file->getClientOriginalExtension();
            $location = public_path("images\cinemas\\" . $filename);
            Image::make($file)->resize(800, 400)->save($location);
        }

        $cinema = new Cinemas([
                'title' => $request->input('title'),
                'price' => $request->input('price'),
                'image' => $filename,
                'location' => $request->input('location'),
                'state' =>  $request->input('state'),
                'city' => $request->input('city'),
                'rank' => $request->input('rank'),
                'landmark' => $request->input('landmark'),
                'description' => $request->input('description'),
                'references' => $request->input('reference'),
                'status' => $request->input('status'),
                'display_options' => serialize($request->input('cinemadisplay')),
        
                'discount' => $request->input('cinemadiscount'),
                'cinemanumber' => $request->input('cinemasnumber'),
                'audiseats' => $request->input('audiseats'),
                'audinumber' => $request->input('audinumber'),
                'cinemacategory' => $request->input('cinemacategory')
        ]);

        $cinema->save();

        $lastinsert_ID = $cinema->id;


        //cinema display prices insertion

   	  
   	   if($request->has('price_rate_per_week')){
            $this->addCinemaPrice($lastinsert_ID, 'price_rate_per_week', $request->input('price_rate_per_week'));
        }
      
       if($request->has('duration_rate_per_week')){
            $this->addCinemaPrice($lastinsert_ID, 'duration_rate_per_week', $request->input('duration_rate_per_week'));
        }

       if($request->has('price_trailor_per_week')){
            $this->addCinemaPrice($lastinsert_ID, 'price_trailor_per_week', $request->input('price_trailor_per_week'));
        } //can be used as no of seats or no of screens

        if($request->has('duration_trailor_per_week')){
            $this->addCinemaPrice($lastinsert_ID, 'duration_trailor_per_week', $request->input('duration_trailor_per_week'));
        }
        if($request->has('price_mute_slide_per_week')){
            $this->addCinemaPrice($lastinsert_ID, 'price_mute_slide_per_week', $request->input('price_mute_slide_per_week'));
        }
        if($request->has('duration_mute_slide_per_week')){
            $this->addCinemaPrice($lastinsert_ID, 'duration_mute_slide_per_week', $request->input('duration_mute_slide_per_week'));
        }

       

       
        //return to cinema product list
       return redirect()->route('dashboard.getCinemaList')->with('message', 'Successfully Added!');
    }

    //insert price data to cinema price table
    public function addCinemaPrice($id, $key, $value)
    {
        $insert = new Cinemasprice();

        $insert->cinemas_id = $id;
        $insert->price_key = $key;
        $insert->price_value = $value;
       
        $insert->save();

    }

    // delete cinema product and price form db tables

    public function getDeleteCinemaad($cinemaadID)
    {
        $delele_cinemaad = Cinemas::where('id', $cinemaadID)->first();
        $delele_cinemaad->delete();
        $delete_cinemaadprice = Cinemasprice::where('cinemas_id', $cinemaadID);
        $delete_cinemaadprice->delete();
      
        return redirect()->route('dashboard.getCinemaList')->with(['message' => "Successfully Deleted From the List!"]);
    }

    // update cinema product
    public function getUpdateeCinemaad($ID)
    {
        $cinemaData = Cinemas::find($ID);
        $cinemapriceData = Cinemasprice::where('cinemas_id', $ID)->get();
        $fieldData = array();
        foreach($cinemapriceData as $pricecinema){
           $fieldData[] = $pricecinema->price_key;
        }

        $name_key = array_chunk($fieldData, 2);
        $datta = array();
         $j = 0; 
		foreach($name_key as $options){
			$datta[$j] = ucwords(str_replace('_', ' ', substr($options[0], 6)));
			$j++;
		}
       $fieldDatas = serialize($datta);
        return view('backend.mediatypes.cinemas.cinema-editform', ['cinema' => $cinemaData, 'cinemapricemeta' => $cinemapriceData, 'fieldData' => $fieldDatas]);
    }
    //check and uncheck options remove
    public function getuncheckCinemaadOptions(Request $request)
    {
        $displayoptions = json_decode($request['displayoptions']);
        $datta = array();
        foreach($displayoptions as $options){
			$datta[] = strtolower(str_replace(' ', '_', $options));
		
		}
        $count = Cinemasprice::where([
                                    ['cinemas_id', '=', $request['id']],
                                    ['price_key', '=', $request['price_key']],
                                ])->count();
        if($count > 0){
            Cinemas::where('id', $request['id'])->update(['display_options' => serialize($datta)]);
            $cinemas = Cinemasprice::where([
                                    ['cinemas_id', '=', $request['id']],
                                    ['price_key', '=', $request['price_key']],
                                ])->first();
            $cinemas->delete();
             $cinemasduration = Cinemasprice::where([
                                    ['cinemas_id', '=', $request['id']],
                                    ['price_key', '=', $request['duration_key']],
                                ])->first();
            $cinemasduration->delete();
            return response(['msg' => 'price deleted'], 200);
        }
              
            return response(['msg' => 'Value not present in db!'], 200);
        
    }

    public function postUpdateeCinemaad(Request $request, $ID)
    {
       $this->validate( $request, [
           'title' => 'required',
           'price' => 'numeric',
           //'image' => 'required|image',
           'location' => 'required',
           'state' => 'required',
           'city' => 'required',
           'rank' => 'numeric',
           'description' => 'required',
           'status' => 'required',
           'audiseats' => 'numeric',
           'audinumber' => 'numeric',
           'cinemanumber' => 'numeric',
           'cinemadiscount' => 'numeric'
        ]);

        $editcinema = Cinemas::find($ID);

         $editcinema->title = $request->input('title');
         $editcinema->price = $request->input('price');
         $editcinema->location = $request->input('location');
         $editcinema->state = $request->input('state');
         $editcinema->city = $request->input('city');
         $editcinema->rank = $request->input('rank');
         $editcinema->landmark = $request->input('landmark');
         $editcinema->description = $request->input('description');
         $editcinema->status = $request->input('status');
         $editcinema->references = $request->input('reference');
         $editcinema->display_options = serialize($request->input('cinemadisplay'));
         $editcinema->cinemanumber = $request->input('cinemasnumber');
         $editcinema->discount = $request->input('cinemadiscount');
         $editcinema->audiseats = $request->input('audiseats');
         $editcinema->audinumber = $request->input('audinumber');
         $editcinema->cinemacategory = $request->input('cinemacategory');
         
        if($request->hasFile('image')){
            $file = $request->file('image');
            $filename = time() .'.'. $file->getClientOriginalExtension();
            $location = public_path("images\cinemas\\" . $filename);
            Image::make($file)->resize(800, 400)->save($location);
            $oldimage = $editcinema->image;
            $editcinema->image = $filename;
        }

       $editcinema->update();

        //cinema display prices insertion

   	   if($request->has('price_rate_per_week')){
            $this->updateCinemaPrice($ID, 'price_rate_per_week', $request->input('price_rate_per_week'));
        }
      
       if($request->has('duration_rate_per_week')){
            $this->updateCinemaPrice($ID, 'duration_rate_per_week', $request->input('duration_rate_per_week'));
        }

       if($request->has('price_trailor_per_week')){
            $this->updateCinemaPrice($ID, 'price_trailor_per_week', $request->input('price_trailor_per_week'));
        } //can be used as no of seats or no of screens

        if($request->has('duration_trailor_per_week')){
            $this->updateCinemaPrice($ID, 'duration_trailor_per_week', $request->input('duration_trailor_per_week'));
        }
        if($request->has('price_mute_slide_per_week')){
            $this->updateCinemaPrice($ID, 'price_mute_slide_per_week', $request->input('price_mute_slide_per_week'));
        }
        if($request->has('duration_mute_slide_per_week')){
            $this->updateCinemaPrice($ID, 'duration_mute_slide_per_week', $request->input('duration_mute_slide_per_week'));
        }

        //return to cinema product list
       return redirect()->route('dashboard.getCinemaList')->with('message', 'Successfully Edited!');
    }

    public function updateCinemaPrice( $id, $meta_key, $meta_value){
        $count = Cinemasprice::where([
                                    ['cinemas_id', '=', $id],
                                    ['price_key', '=', $meta_key],
                                ])->count();
        if($count < 1){
            $this->addCinemaPrice($id, $meta_key, $meta_value);
        }else{
            $update = Cinemasprice::where([
                                    ['cinemas_id', '=', $id],
                                    ['price_key', '=', $meta_key],
                                ])->update(['price_value' => $meta_value]);
        }
        
   }

    //cart functions
   // add or remove item to cart
   public function getAddToCart(Request $request, $id, $variation)
   {
        $cinema_ad = Cinemas::where('id', $id)->first()->toArray();
        
        $selectDisplayOpt = explode("+", $variation);

        $main_key = substr($selectDisplayOpt[1], 6);
        
        $duration_key = "duration_".$main_key;

        $cinema_price = Cinemasprice::where([
                                    ['cinemas_id', '=', $id],
                                    ['price_key', '=', $selectDisplayOpt[1]],
                                ])->first()->toArray();

        
        $cinema_duration = Cinemasprice::where([
                                    ['cinemas_id', '=', $id],
                                    ['price_key', '=', $duration_key],
                                ])->first()->toArray();
        $cinema_change_price = array();
        foreach($cinema_price as $key => $value){
            if($key == 'price_key'){
                $cinema_change_price[$key] = $value;
            }
            if($key == 'price_value'){
               $cinema_change_price[$key] = $value;
            }
        }
       
        $cinema_change_duration = array();
        foreach($cinema_duration as $key => $value){
            if($key == 'price_key'){
                $key = 'duration_key';
                $cinema_change_duration[$key] = $value;
            }
            if($key == 'price_value'){
                $key = 'duration_value';
                $cinema_change_duration[$key] = $value;
            }
        }
       
        $cinema_price = array_merge($cinema_change_price, $cinema_change_duration);
        
        $cinema_Ad = array_merge($cinema_ad, $cinema_price);
       
        $oldCart = Session::has('cart') ? Session::get('cart') : null;
                
        $cart = new Cart($oldCart);

        $cart->addorRemove($cinema_Ad, $cinema_ad['id'], 'cinemas'); //pass full cinema details, id and model name like "cinemas"
        
        $request->session()->put('cart', $cart);
        //Session::forget('cart');

        return redirect()->back()->with(['status' => 'added']);
    }

 
}
