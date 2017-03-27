<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use Session;
use App\Airports;
use App\Airportsprice;
use Image;
use App\Product;
use Illuminate\Support\Facades\File;
use App\Cart;
use App\Order;


class AirportController extends Controller
{
    
    //frontend function starts
    
    public function getfrontendAllAirportads()
    {
       $airport_ads = Airports::all();
       return view('frontend-mediatype.airports.airportads-list', ['products' => $airport_ads]);
    }
    
    public function getfrontAirportad($id)
    {
        $airportad = Airports::find($id);
       
        $airportprice = Airportsprice::where('airports_id', $id)->get();
        return view('frontend-mediatype.airports.airport-single', ['airportad' => $airportad, 'airportprice' => $airportprice]);
    }
    
    
    // frontend functions ends

    //Backend functions below


    // get list of all the products in airport stop media type
    public function getDashboardAirportList(){
        $airport_ads = Airports::all();
        return view('backend.mediatypes.airports.airport-list', ['airport_ads' => $airport_ads]);
    }
    
    // get form of airport stop media type
     public function getDashboardAirportForm()
    {
        return view('backend.mediatypes.airports.airport-addform');
    }

    // post list of all the products in airport media type

    public function postDashboardAirportForm(Request $request)
    {
         // dd($request->all());
        $this->validate( $request, [
           'title' => 'required',
           'price' => 'numeric',
           'image' => 'required|image',
           'location' => 'required',
           'state' => 'required',
           'city' => 'required',
           'rank' => 'numeric',
           'description' => 'required',
           'status' => 'required'
        ]);

        if($request->hasFile('image')){
            $file = $request->file('image');
            $filename = time() .'.'. $file->getClientOriginalExtension();
            $location = public_path("images\airports\\" . $filename);
            Image::make($file)->resize(800, 400)->save($location);
        }

        $airport = new Airports([
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
                'display_options' => serialize($request->input('airportdisplay')),
                'light_option' => $request->input('aplighting'),
                'discount' => $request->input('airportdiscount'),
                'airportnumber' => $request->input('airportsnumber')
        ]);

        $airport->save();

        $lastinsert_ID = $airport->id;



        //airport display prices insertion

   	   if($request->has('price_unipole')){
            $this->addAirportPrice($lastinsert_ID, 'price_unipole', $request->input('price_unipole'));
        }
      
       if($request->has('number_unipole')){
            $this->addAirportPrice($lastinsert_ID, 'number_unipole', $request->input('number_unipole'));
        }

       if($request->has('duration_unipole')){
            $this->addAirportPrice($lastinsert_ID, 'duration_unipole', $request->input('duration_unipole'));
        }

        if($request->has('price_backlit_panel')){
            $this->addAirportPrice($lastinsert_ID, 'price_backlit_panel', $request->input('price_backlit_panel'));
        }
        if($request->has('number_backlit_panel')){
            $this->addAirportPrice($lastinsert_ID, 'number_backlit_panel', $request->input('number_backlit_panel'));
        }
        if($request->has('duration_backlit_panel')){
            $this->addAirportPrice($lastinsert_ID, 'duration_backlit_panel', $request->input('duration_backlit_panel'));
        }
        if($request->has('price_luggage_trolley')){
            $this->addAirportPrice($lastinsert_ID, 'price_luggage_trolley', $request->input('price_luggage_trolley'));
        }
         if($request->has('number_luggage_trolley')){
            $this->addAirportPrice($lastinsert_ID, 'number_luggage_trolley', $request->input('number_luggage_trolley'));
        }
      
       if($request->has('duration_luggage_trolley')){
            $this->addAirportPrice($lastinsert_ID, 'duration_luggage_trolley', $request->input('duration_luggage_trolley'));
        }
    
      

       
        //return to airport product list
       return redirect()->route('dashboard.getAirportList')->with('message', 'Successfully Added!');
    }

    //insert price data to airport price table
    public function addAirportPrice($id, $key, $value)
    {
        $insert = new Airportsprice();

        $insert->airports_id = $id;
        $insert->price_key = $key;
        $insert->price_value = $value;
       
        $insert->save();

    }

    // delete airport product and price form db tables

    public function getDeleteAirportad($airportadID)
    {
        $delele_airportad = Airports::where('id', $airportadID)->first();
        $delele_airportad->delete();
        $delete_airportadprice = Airportsprice::where('airports_id', $airportadID);
        $delete_airportadprice->delete();
       
        return redirect()->route('dashboard.getAirportList')->with(['message' => "Successfully Deleted From the List!"]);
    }

    // update airport product
    public function getUpdateeAirportad($ID)
    {
        $airportData = Airports::find($ID);
        $airportpriceData = Airportsprice::where('airports_id', $ID)->get();
        $fieldData = array();
        foreach($airportpriceData as $priceairport){
           $fieldData[] = $priceairport->price_key;
        }

        $name_key = array_chunk($fieldData, 3);
        $datta = array();
         $j = 0; 
		foreach($name_key as $options){
			$datta[$j] = ucwords(str_replace('_', ' ', substr($options[0], 6)));
			$j++;
		}
       $fieldDatas = serialize($datta);
        return view('backend.mediatypes.airports.airport-editform', ['airport' => $airportData, 'airportpricemeta' => $airportpriceData, 'fieldData' => $fieldDatas]);
    }
    //check and uncheck options remove
    public function getuncheckAirportadOptions(Request $request)
    {
        
        $displayoptions = json_decode($request['displayoptions']);
        $datta = array();
        foreach($displayoptions as $options){
			$datta[] = strtolower(str_replace(' ', '_', $options));
		
		}
               
        $count = Airportsprice::where([
                                    ['airports_id', '=', $request['id']],
                                    ['price_key', '=', $request['price_key']],
                                ])->count();
        
        if($count > 0){
            Airports::where('id', $request['id'])->update(['display_options' =>  serialize($datta)]);
            $airports = Airportsprice::where([
                                    ['airports_id', '=', $request['id']],
                                    ['price_key', '=', $request['price_key']],
                                ])->first();
            $airports->delete();
           
            $airportsnumber = Airportsprice::where([
                                    ['airports_id', '=', $request['id']],
                                    ['price_key', '=', $request['number_key']]
                                ])->first();
            $airportsnumber->delete();
            $airportsduration = Airportsprice::where([
                                    ['airports_id', '=', $request['id']],
                                    ['price_key', '=', $request['duration_key']]
                                ])->first();
            $airportsduration->delete();
            return response(['msg' => 'price deleted'], 200);
        }else{
             return response(['msg' => 'Value not present in db!'], 200);
        }
              
    }

    public function postUpdateeAirportad(Request $request, $ID)
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
           'status' => 'required'
        ]);

        $editairport = Airports::find($ID);

         $editairport->title = $request->input('title');
         $editairport->price = $request->input('price');
         $editairport->location = $request->input('location');
         $editairport->state = $request->input('state');
         $editairport->city = $request->input('city');
         $editairport->rank = $request->input('rank');
         $editairport->landmark = $request->input('landmark');
         $editairport->description = $request->input('description');
         $editairport->status = $request->input('status');
         $editairport->references = $request->input('reference');
         $editairport->display_options = serialize($request->input('airportdisplay'));
          $editairport->light_option = $request->input('aplighting');
          $editairport->airportnumber = $request->input('airportsnumber');
          $editairport->discount = $request->input('airportdiscount');

        if($request->hasFile('image')){
            $file = $request->file('image');
            $filename = time() .'.'. $file->getClientOriginalExtension();
            $location = public_path("images\airports\\" . $filename);
            Image::make($file)->resize(800, 400)->save($location);
            $oldimage = $editairport->image;
            $editairport->image = $filename;
        }

       $editairport->update();

        //airport display prices insertion

         if($request->has('price_unipole')){
            $this->updateAirportPrice($ID, 'price_unipole', $request->input('price_unipole'));
        }
      
       if($request->has('number_unipole')){
            $this->updateAirportPrice($ID, 'number_unipole', $request->input('number_unipole'));
        }

       if($request->has('duration_unipole')){
            $this->updateAirportPrice($ID, 'duration_unipole', $request->input('duration_unipole'));
        }

        if($request->has('price_backlit_panel')){
            $this->updateAirportPrice($ID, 'price_backlit_panel', $request->input('price_backlit_panel'));
        }
        if($request->has('number_backlit_panel')){
            $this->updateAirportPrice($ID, 'number_backlit_panel', $request->input('number_backlit_panel'));
        }
        if($request->has('duration_backlit_panel')){
            $this->updateAirportPrice($ID, 'duration_backlit_panel', $request->input('duration_backlit_panel'));
        }
        if($request->has('price_luggage_trolley')){
            $this->updateAirportPrice($ID, 'price_luggage_trolley', $request->input('price_luggage_trolley'));
        }
         if($request->has('number_luggage_trolley')){
            $this->updateAirportPrice($ID, 'number_luggage_trolley', $request->input('number_luggage_trolley'));
        }
      
       if($request->has('duration_luggage_trolley')){
            $this->updateAirportPrice($ID, 'duration_luggage_trolley', $request->input('duration_luggage_trolley'));
        }

        

        //return to airport product list
       return redirect()->route('dashboard.getAirportList')->with('message', 'Successfully Edited!');
    }

    public function updateAirportPrice( $id, $meta_key, $meta_value){
        $count = Airportsprice::where([
                                    ['airports_id', '=', $id],
                                    ['price_key', '=', $meta_key],
                                ])->count();
        if($count < 1){
            $this->addAirportPrice($id, $meta_key, $meta_value);
        }else{
            $update = Airportsprice::where([
                                    ['airports_id', '=', $id],
                                    ['price_key', '=', $meta_key],
                                ])->update(['price_value' => $meta_value]);
        }
        
   }

    //cart functions
   // add or remove item to cart
   public function getAddToCart(Request $request, $id, $variation)
   {
        $airport_ad = Airports::where('id', $id)->first()->toArray();
        
        $selectDisplayOpt = explode("+", $variation);
        $main_key = substr($selectDisplayOpt[1], 6);
        
        $number_key = "number_".$main_key;
        $duration_key = "duration_".$main_key;
     
        $airport_price = Airportsprice::where([
                                    ['airports_id', '=', $id],
                                    ['price_key', '=', $selectDisplayOpt[1]],
                                ])->first()->toArray();
       
        $airport_number = Airportsprice::where([
                                    ['airports_id', '=', $id],
                                    ['price_key', '=', $number_key],
                                ])->first()->toArray();
        $airport_duration = Airportsprice::where([
                                    ['airports_id', '=', $id],
                                    ['price_key', '=', $duration_key],
                                ])->first()->toArray();
        $airport_change_price = array();
        foreach($airport_price as $key => $value){
            if($key == 'price_key'){
                $airport_change_price[$key] = $value;
            }
            if($key == 'price_value'){
               $airport_change_price[$key] = $value;
            }
        }
        $airport_change_num = array();
        foreach($airport_number as $key => $value){
            if($key == 'price_key'){
                $key = 'number_key';
                $airport_change_num[$key] = $value;
            }
            if($key == 'price_value'){
                $key = 'number_value';
                $airport_change_num[$key] = $value;
            }
        }
        $airport_change_duration = array();
        foreach($airport_duration as $key => $value){
            if($key == 'price_key'){
                $key = 'duration_key';
                $airport_change_duration[$key] = $value;
            }
            if($key == 'price_value'){
                $key = 'duration_value';
                $airport_change_duration[$key] = $value;
            }
        }
        $airport_merge = array_merge($airport_change_num, $airport_change_duration);
        
        $airport_price = array_merge($airport_change_price, $airport_merge);
        
        $airport_Ad = array_merge($airport_ad, $airport_price);
       
        $oldCart = Session::has('cart') ? Session::get('cart') : null;
                
        $cart = new Cart($oldCart);

        $cart->addorRemove($airport_Ad, $airport_ad['id'], 'airports'); //pass full airport details, id and model name like "airports"
        
        $request->session()->put('cart', $cart);
        //Session::forget('cart');

        return redirect()->back()->with(['status' => 'added']);
    }

 
}
