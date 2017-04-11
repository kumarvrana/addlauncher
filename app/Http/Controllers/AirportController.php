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

    public function getfrontAirportadByOption($airportOption)
    {
       
        $airport_ads = Airports::all()->toArray();
       
        $airportOption1 = '%'.$airportOption.'%';
        $airports = array();
        foreach($airport_ads as $airport){
            $count = Airportsprice::where([
                                    ['airports_id', '=', $airport['id']],
                                    ['price_key', 'LIKE', $airportOption1],
                                   ])->get()->count();
            if($count > 0){
                 $airportpriceOptions = Airportsprice::where([
                                    ['airports_id', '=', $airport['id']],
                                    ['price_key', 'LIKE', $airportOption1],
                                   ])->get(array('price_key', 'price_value', 'number_key', 'number_value', 'duration_key', 'duration_value'))->toArray();
                array_push($airport, $airportpriceOptions);
                $airports[] = array_flatten($airport);
            }
       }
       
        return view('frontend-mediatype.airports.airport-single', ['products' => $airports, 'airportOption' => $airportOption]);
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
       if(!empty($request['locationFilter']) && !empty($request['pricerange'])){
            $filter_priceCamparsion = preg_replace('/[0-9]+/', '', $request['pricerange']); // comparion operator
            if($filter_priceCamparsion != '<>'){
                    $filter_price = preg_replace('/[^0-9]/', '', $request['pricerange']);
                    $airportpriceOptions = Airportsprice::where([
                                ['price_key', 'LIKE', 'price_%'],                                    
                                ['price_value', $filter_priceCamparsion, $filter_price],
                                ])->get(array('airports_id','price_key', 'price_value', 'number_key', 'number_value', 'duration_key', 'duration_value'))->toArray();
            }else{
                    $filter_price = preg_replace('/[^0-9]/', '_', $request['pricerange']);
                    $filter_price = explode('_', $filter_price);
                
                    $airportpriceOptions = Airportsprice::where([
                                ['price_key', 'LIKE', 'price_%'],                                    
                                ['price_value', '>=', $filter_price[0]],
                                ['price_value', '<=', $filter_price[2]],
                                ])->get(array('airports_id','price_key', 'price_value', 'number_key', 'number_value', 'duration_key', 'duration_value'))->toArray();   
            }
            if(count($airportpriceOptions)>0){
               
                $airports = array(); 
                foreach($airportpriceOptions as $key => $value){
                    $location = "%".$request['locationFilter']."%";
            
                    $airport_ad = Airports::where('id', '=', $value['airports_id'])->where('location', 'LIKE', $location)->Where('city', 'LIKE', $location)->get()->toArray();
                    if(count($airport_ad) > 0){
                        $airportpriceiterate = Airportsprice::where([
                                        ['airports_id', '=', $value['airports_id']],
                                        ['price_key', 'LIKE', $value['price_key']],
                                    
                                        ])->get(array('price_key', 'price_value', 'number_key', 'number_value', 'duration_key', 'duration_value'))->first()->toArray();
                        array_push($airport_ad, $airportpriceiterate);
                        $airports[] = array_flatten($airport_ad);
                    }
                
                }
                if(count($airports)>0){
                    
                    foreach($airports as $searchAirport){
                        $this->airport_ads($searchAirport, $request->all());
                    }
            
                }else{
                    echo "<b>No results to display!</b>";
                }

            }else{
                echo "<b>No results to display!</b>";
            }    
       }

       if(!empty($request['pricerange']) && empty($request['locationFilter'])){
            $filter_priceCamparsion = preg_replace('/[0-9]+/', '', $request['pricerange']); // comparion operator
            if($filter_priceCamparsion != '<>'){
                    $filter_price = preg_replace('/[^0-9]/', '', $request['pricerange']);
                    $airportpriceOptions = Airportsprice::where([
                                ['price_key', 'LIKE', 'price_%'],                                    
                                ['price_value', $filter_priceCamparsion, $filter_price],
                                ])->get(array('airports_id','price_key', 'price_value', 'number_key', 'number_value', 'duration_key', 'duration_value'))->toArray();
            }else{
                    $filter_price = preg_replace('/[^0-9]/', '_', $request['pricerange']);
                    $filter_price = explode('_', $filter_price);
                
                    $airportpriceOptions = Airportsprice::where([
                                ['price_key', 'LIKE', 'price_%'],                                    
                                ['price_value', '>=', $filter_price[0]],
                                ['price_value', '<=', $filter_price[2]],
                                ])->get(array('airports_id','price_key', 'price_value', 'number_key', 'number_value', 'duration_key', 'duration_value'))->toArray();   
            }
            if(count($airportpriceOptions)>0){
                
                $airports = array(); 
                foreach($airportpriceOptions as $key => $value){
                    
                    $airport_ad = Airports::where('id', '=', $value['airports_id'])->get()->toArray();
                    
                    $airportpriceiterate = Airportsprice::where([
                                        ['airports_id', '=', $value['airports_id']],
                                        ['price_key', 'LIKE', $value['price_key']],
                                    
                                        ])->get(array('price_key', 'price_value', 'number_key', 'number_value', 'duration_key', 'duration_value'))->first()->toArray();
                    array_push($airport_ad, $airportpriceiterate);
                    $airports[] = array_flatten($airport_ad);
                
                }
                if(count($airports)>0){
            
                    foreach($airports as $searchAirport){
                        $this->airport_ads($searchAirport, $request->all());
                    }
            
                }else{
                    echo "<b>No results to display!</b>";
                }

            }else{
                echo "<b>No results to display!</b>";
            }
            
           
       }
       if(!empty($request['locationFilter']) && empty($request['pricerange'])){
            $location = "%".$request['locationFilter']."%";
            $airport_ad = Airports::where('location', 'LIKE', $location)->orWhere('city', 'LIKE', $location)->get()->toArray();
            $airports = array();
            $Sairports = array();
            if(count($airport_ad)>0){
                foreach($airport_ad as $airport){
                    
                    $airportpriceOptions = Airportsprice::where([
                                    ['airports_id', 'LIKE',  $airport['id']],                                 
                                    ])->get(array('price_key', 'price_value', 'number_key',
                                    'number_value', 'duration_key', 'duration_value'))->toArray();
                   
                    if(count($airportpriceOptions)>0){
                        $i = 1;
                        foreach($airportpriceOptions as $priceOptions){
                            if($i ==1 ){
                                $Sairports[] = array_merge($airport, $priceOptions);
                            }else{
                                array_pop($airports);
                                $Sairports[] = array_merge($airport, $priceOptions);
                            }
                            
                           
                            $i++;
                        }
                        
                    }else{
                        echo "<b>No results to display!</b>";
                    }
                    
                }
                if(count($Sairports)>0){
                    
                    foreach($Sairports as $searchAirport){
                        $this->Locationairport_ads($searchAirport, $request->all());
                    }
            
                }else{
                    echo "<b>No results to display!</b>";
                }
            }else{
                echo "<b>No results to display!</b>";
            }
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
            <div class=" cat-opt-img "> <img src="<?= asset('images/airports/'.$searchAirport[11]) ?>"> </div>
            <p class="font-1"><?= $searchAirport[3] ?></p>
            <p class="font-2"><?= $searchAirport[5] ?> | <?= $searchAirport[6] ?> | <?= $searchAirport[7] ?></p>
            <p class="font-3"><?= $searchAirport[21]?> <?= ucwords(substr(str_replace('_', ' ', $searchAirport[18]), 6))?> for <?= $searchAirport[23]?> months</p>
            <p class="font-2"><del class="lighter">Rs <?= $searchAirport[19]?> </del>Rs <?= $searchAirport[19]?> </p>
            <?php
            $options = $searchAirport[19].'+'.$searchAirport[18];
            $session_key = 'airports'.'_'.$searchAirport[18].'_'.$searchAirport[0];
            $printsession = (array) Session::get('cart');
                            
           ?>
            <div class="clearfix"> 
                <button class="glass add-cartButton" data-href="<?= route('airport.addtocartAfterSearch', ['id' => $searchAirport[0], 'variation' => $options, 'fileroption' => http_build_query($fileroptions)]) ?>"><span class="fa fa-star"></span>
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
   public function Locationairport_ads($searchAirport, $fileroptions)
   {
      
       ?>
       <div class="col-md-3 col-sm-3 "> 
        <div class="pro-item"> 
            <div class=" cat-opt-img "> <img src="<?= asset('images/airports/'.$searchAirport['image']) ?>"> </div>
            <p class="font-1"><?= $searchAirport['title'] ?></p>
            <p class="font-2"><?= $searchAirport['location'] ?> | <?= $searchAirport['city'] ?> | <?= $searchAirport['state'] ?></p>
            <p class="font-3"><?= $searchAirport['number_value']?> <?= ucwords(substr(str_replace('_', ' ', $searchAirport['price_key']), 6))?> for <?= $searchAirport['duration_value']?> months</p>
            <p class="font-2"><del class="lighter">Rs <?= $searchAirport['price_value']?> </del>Rs <?= $searchAirport['price_value']?> </p>
            <?php
            $options = $searchAirport['price_value'].'+'.$searchAirport['price_key'];
            $session_key = 'airports'.'_'.$searchAirport['price_key'].'_'.$searchAirport['id'];
            $printsession = (array) Session::get('cart');
                            
           ?>
            <div class="clearfix"> 
                <button class="glass add-cartButton" data-href="<?= route('airport.addtocartAfterSearch', ['id' => $searchAirport['id'], 'variation' => $options, 'fileroption' => http_build_query($fileroptions)]) ?>"><span class="fa fa-star"></span>
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
        
        $selectDisplayOpt = explode("+", $variation);
        $main_key = substr($selectDisplayOpt[1], 6);
        
       
        $airport_price = Airportsprice::where([
                                    ['airports_id', '=', $id],
                                    ['price_key', '=', $selectDisplayOpt[1]],
                                ])->first()->toArray();
       
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
        
        $selectDisplayOpt = explode("+", $variation);
        $main_key = substr($selectDisplayOpt[1], 6);
        
       
        $airport_price = Airportsprice::where([
                                    ['airports_id', '=', $id],
                                    ['price_key', '=', $selectDisplayOpt[1]],
                                ])->first()->toArray();
       
        $airport_Ad = array_merge($airport_ad, $airport_price);
       
        $oldCart = Session::has('cart') ? Session::get('cart') : null;
                
        $cart = new Cart($oldCart);

        $status = $cart->addorRemove($airport_Ad, $airport_ad['id'], 'airports', $flag=true); //pass full airport details, id and model name like "airports"
        
        $request->session()->put('cart', $cart);
        //Session::forget('cart');

        return response(['status' => $status, 'quatity' => $cart->totalQty, 'total' => $cart->totalPrice], 200);
    }
 
}
