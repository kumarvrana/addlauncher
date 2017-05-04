<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use Session;
use App\Airports;
use App\Airportsprice;
use App\Mainaddtype;
use Image;
use App\Product;
use Illuminate\Support\Facades\File;
use App\Cart;
use App\Order;


class AirportController extends Controller
{
    
    public function __construct()
    {
        $this->middleware('admin', ['only' => ['getDashboardAirportList', 'getDashboardAirportForm', 'postDashboardAirportForm', 'addAirportPrice', 'getDeleteAirportad', 'getUpdateeAirportad', 'getuncheckAirportadOptions']]);
    }

    //frontend function starts
    

    public function getfrontendAllAirportads()
    {
       $airport_options = array(
                                'unipole' => 'Unipole',
                                'backlit_panel' => 'Backlit Panel',
                                'luggage_trolley' => 'Luggage Trolley'
                            );

       $location = 'Delhi NCR';
          $ad_cats = Mainaddtype::orderBy('title')->get();

       return view('frontend-mediatype.airports.airportads-list', ['airport_options' => $airport_options, 'location' => $location,'mediacats' => $ad_cats]);
    }


    public function getfrontAirportadByOption($airportOption)
    {
          
        $airports = new Airportsprice();

        $airports = $airports->getAirportByFilter($airportOption);
        
        return view('frontend-mediatype.airports.airport-single', ['airports' => $airports, 'airportOption' => $airportOption]);
    }
    
    public function getfrontAirportad($id)
    {
        $airportad = Airports::find($id);
        if($airportad){
            if($airportad->status === "3" || $airportad->status === "2"){
                return redirect()->back();
            }else{
                $airportprice = Airportsprice::where('airports_id', $id)->get();
                return view('frontend-mediatype.airports.airport-single', ['airportad' => $airportad, 'airportprice' => $airportprice]);
            }
        }else{
            return redirect()->back();
        }
        
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
                       
            $this->addAirportPrice($lastinsert_ID, 'price_unipole', $request->input('price_unipole'), 'number_unipole', $request->input('number_unipole'),'duration_unipole', $request->input('duration_unipole'));
        }
      
        if($request->has('price_backlit_panel')){
            $this->addAirportPrice($lastinsert_ID, 'price_backlit_panel', $request->input('price_backlit_panel'), 'number_backlit_panel', $request->input('number_backlit_panel'), 'duration_backlit_panel', $request->input('duration_backlit_panel'));
        }
       
        if($request->has('price_luggage_trolley')){
            $this->addAirportPrice($lastinsert_ID, 'price_luggage_trolley', $request->input('price_luggage_trolley'), 'number_luggage_trolley', $request->input('number_luggage_trolley'), 'duration_luggage_trolley', $request->input('duration_luggage_trolley'));
        }
        
    
       
        //return to airport product list
       return redirect()->route('dashboard.getAirportList')->with('message', 'Successfully Added!');
    }

    //insert price data to airport price table
    public function addAirportPrice($id, $pricekey, $pricevalue, $numkey, $numvalue, $durkey, $durvalue)
    {
        $insert = new Airportsprice();

        $insert->airports_id = $id;
        $insert->price_key = $pricekey;
        $insert->price_value = $pricevalue;
        $insert->number_key = $numkey;
        $insert->number_value = $numvalue;
        $insert->duration_key = $durkey;
        $insert->duration_value = $durvalue;
       
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
           $fieldData[] = ucwords(str_replace('_', ' ', substr($priceairport->price_key, 6)));
        }

        $fieldDatas = serialize($fieldData);
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
                       
            $this->updateAirportPrice($ID, 'price_unipole', $request->input('price_unipole'), 'number_unipole', $request->input('number_unipole'),'duration_unipole', $request->input('duration_unipole'));
        }
      
        if($request->has('price_backlit_panel')){
            $this->updateAirportPrice($ID, 'price_backlit_panel', $request->input('price_backlit_panel'), 'number_backlit_panel', $request->input('number_backlit_panel'), 'duration_backlit_panel', $request->input('duration_backlit_panel'));
        }
       
        if($request->has('price_luggage_trolley')){
            $this->updateAirportPrice($ID, 'price_luggage_trolley', $request->input('price_luggage_trolley'), 'number_luggage_trolley', $request->input('number_luggage_trolley'), 'duration_luggage_trolley', $request->input('duration_luggage_trolley'));
        }
     
        //return to airport product list
       return redirect()->route('dashboard.getAirportList')->with('message', 'Successfully Edited!');
    }

    public function updateAirportPrice($id, $pricekey, $pricevalue, $numkey, $numvalue, $durkey, $durvalue){
        $count = Airportsprice::where([
                                    ['airports_id', '=', $id],
                                    ['price_key', '=', $pricekey],
                                ])->count();
        if($count < 1){
            $this->addAirportPrice($id, $pricekey, $pricevalue, $numkey, $numvalue, $durkey, $durvalue);
        }else{
            $update = Airportsprice::where([
                                    ['airports_id', '=', $id],
                                    ['price_key', '=', $pricekey],
                                ])->update(['price_value' => $pricevalue, 'number_value' => $numvalue, 'duration_value' => $durvalue]);
        }
        
   }

   //Fliter Functions
   public function getFilterAirportAds(Request $request)
   {
        
        $airportPrice = new Airportsprice();
        $filterResults = $airportPrice->FilterAirportsAds($request->all());
        if(count($filterResults)>0){
            foreach($filterResults as $searchAirport){
                $this->airport_ads($searchAirport, $request->all());
            }

        }else{
            echo "<strong>No Results Found!</strong>";
        }

        $content = ob_get_contents();
        ob_get_clean();
        return $content;
  
   }

   public function airport_ads($searchAirport, $fileroptions)
   { 
         ?>
       
       <div class="col-md-3 col-sm-3 "> 
        <div class="pro-item"> 
            <div class=" cat-opt-img "> <img src="<?= asset('images/airports/'.$searchAirport->airport->image) ?>"> </div>
            <p class="font-1"><?= $searchAirport->airport->title ?></p>
            <p class="font-2"><?= $searchAirport->airport->location ?>, <?= $searchAirport->airport->city ?>, <?= $searchAirport->airport->state ?></p>
            <div class="row">
                <div class="col-md-6">
                    <p class="font-3"><?= $searchAirport->number_value ?> <?= ucwords(substr(str_replace('_', ' ', $searchAirport->price_key), 6))?> <br>for <br> <?= $searchAirport->duration_value?> months</p>
                    </div>
                <div class="col-md-6">
                        <p class="font-4"><del class="lighter">Rs <?= $searchAirport->price_value?> </del><br>Rs <?= $searchAirport->price_value?> </p>
                </div>
            
            </div>

            <?php
            $options = $searchAirport->price_value.'+'.$searchAirport->price_key;
            $session_key = 'airports'.'_'.$searchAirport->price_key.'_'.$searchAirport->airport->id;
            $printsession = (array) Session::get('cart');
                            
           ?>
            <div class="clearfix"> 
                <button class="glass add-cartButton" data-href="<?= route('airport.addtocartAfterSearch', ['id' => $searchAirport->airport->id, 'variation' => $options, 'fileroption' => http_build_query($fileroptions)]) ?>"><span class="fa fa-star"></span>
                <?php
                    if(count($printsession) > 0){
                     if(array_key_exists($session_key, $printsession['items'])){
                       echo "Remove From Cart"; 
                    }else{
                        echo "Add to Cart"; 
                    }
                    }else{
                        echo "Add to Cart";
                    }
                ?>
            </button> 
            </div>
        </div>
    </div>
    <?php
   }
  
    //cart functions
   // add or remove item to cart
   public function getAddToCart(Request $request, $id, $variation)
   {
       
        $airport_ad = Airports::where('id', $id)->first()->toArray();

        $airportPrice = new Airportsprice();
        $airport_price = $airportPrice->getAirportspriceCart($id, $variation);
               
        $airport_Ad = array_merge($airport_ad, $airport_price);
        
        $oldCart = Session::has('cart') ? Session::get('cart') : null;
                
        $cart = new Cart($oldCart);

        $status = $cart->addorRemove($airport_Ad, $airport_ad['id'], 'airports', $flag=true); //pass full airport details, id and model name like "airports"
        
        $request->session()->put('cart', $cart);
        //Session::forget('cart');

        return redirect()->back()->with(['status' => $status]);
    }

    public function getAddToCartBySearch(Request $request, $id, $variation, $fileroption)
    {
        $airport_ad = Airports::where('id', $id)->first()->toArray();
        
        $airportPrice = new Airportsprice();
        $airport_price = $airportPrice->getAirportspriceCart($id, $variation);
       
        $airport_Ad = array_merge($airport_ad, $airport_price);
       
        $oldCart = Session::has('cart') ? Session::get('cart') : null;
                
        $cart = new Cart($oldCart);

        $status = $cart->addorRemove($airport_Ad, $airport_ad['id'], 'airports', $flag=true); //pass full airport details, id and model name like "airports"
        
        $request->session()->put('cart', $cart);
        //Session::forget('cart');

        return response(['status' => $status, 'quatity' => $cart->totalQty, 'total' => $cart->totalPrice], 200);
    }
 
}
