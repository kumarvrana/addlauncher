<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use Session;
use App\Buses;
use App\Busesprice;
use App\Mainaddtype;
use Image;
use App\Product;
use Illuminate\Support\Facades\File;
use App\Cart;
use App\Order;

class BusController extends Controller
{   

    public function __construct()
    {
        $this->middleware('admin', ['only' => ['getDashboardBusList', 'getDashboardBusForm', 'postDashboardBusForm', 'addBusPrice', 'getDeleteBusad', 'getUpdateeBusad', 'getuncheckBusadOptions']]);
    }
    
    //frontend function starts
    
    public function getfrontendAllBusads()
    {
       $bus_options = Buses::all();
       $location = 'Delhi NCR';
       $ad_cats = Mainaddtype::orderBy('title')->get();
       
       return view('frontend-mediatype.buses.busads-list', ['bus_options' => $bus_options, 'location' => $location,'mediacats' => $ad_cats]);

    }
    public function getfrontBusadByOption($busOption)
    {
          
        $buses = new Busesprice();

        $buses = $buses->getBusByFilter($busOption);
        
        return view('frontend-mediatype.buses.bus-single', ['buses' => $buses, 'busOption' => $busOption]);
    }
    
    public function getfrontBusad($id)
    {
       $busad = Buses::find($id);
        if($busad){
            if($busad->status === "3" || $busad->status === "2"){
                return redirect()->back();
            }else{
                $busprice = Busesprice::where('buses_id', $id)->get();
                return view('frontend-mediatype.buses.bus-single', ['busad' => $busad, 'busprice' => $busprice]);
            }
        }else{
            return redirect()->back();
        }
    }
    
    
    // frontend functions ends

    //Backend functions below


    // get list of all the products in bus media type
    public function getDashboardBusList()
    {
         $bus_ads = Buses::all();
         return view('backend.mediatypes.buses.bus-list', ['bus_ads' => $bus_ads]);
    }
    
    // get form of bus media type
    public function getDashboardBusForm()
    {
        return view('backend.mediatypes.buses.bus-addform');
    }

    // post list of all the products in bus media type

    public function postDashboardBusForm(Request $request)
    {
        //dd($request->all());
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
            $location = public_path("images\buses\\" . $filename);
            Image::make($file)->resize(800, 400)->save($location);
        }

        $bus = new Buses([
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
                'display_options' => serialize($request->input('busdisplay')),
                'busnumber' => $request->input('busesnumber'),
                'discount' => $request->input('busdiscount')
        ]);

        $bus->save();

        $lastinsert_ID = $bus->id;

        

        //bus display prices insertion

        if($request->has('price_full')){
            $this->addBusPrice($lastinsert_ID, 'price_full', $request->input('price_full'), 'number_full', $request->input('number_full'), 'duration_full', $request->input('duration_full'));
        }
       

        if($request->has('price_both_side')){
            $this->addBusPrice($lastinsert_ID, 'price_both_side', $request->input('price_both_side'), 'number_both_side', $request->input('number_both_side'), 'duration_both_side', $request->input('duration_both_side'));
        }
        

        if($request->has('price_left_side')){
            $this->addBusPrice($lastinsert_ID, 'price_left_side', $request->input('price_left_side'), 'number_left_side', $request->input('number_left_side'), 'duration_left_side', $request->input('duration_left_side'));
        }
       

        if($request->has('price_right_side')){
            $this->addBusPrice($lastinsert_ID, 'price_right_side', $request->input('price_right_side'), 'number_right_side', $request->input('number_right_side'), 'duration_right_side', $request->input('duration_right_side'));
        }
        

        if($request->has('price_back_side')){
            $this->addBusPrice($lastinsert_ID, 'price_back_side', $request->input('price_back_side'), 'number_back_side', $request->input('number_back_side'), 'duration_back_side', $request->input('duration_back_side'));
        }
        

        if($request->has('price_back_glass')){
            $this->addBusPrice($lastinsert_ID, 'price_back_glass', $request->input('price_back_glass'), 'number_back_glass', $request->input('number_back_glass'), 'duration_back_glass', $request->input('duration_back_glass'));
        }
       

        if($request->has('price_internal_ceiling')){
            $this->addBusPrice($lastinsert_ID, 'price_internal_ceiling', $request->input('price_internal_ceiling'), 'number_internal_ceiling', $request->input('number_internal_ceiling'), 'duration_internal_ceiling', $request->input('duration_internal_ceiling'));
        }


        if($request->has('price_bus_grab_handles')){
            $this->addBusPrice($lastinsert_ID, 'price_bus_grab_handles', $request->input('price_bus_grab_handles'), 'number_bus_grab_handles', $request->input('number_bus_grab_handles'), 'duration_bus_grab_handles', $request->input('duration_bus_grab_handles'));
        }

        if($request->has('price_inside_billboards')){
            $this->addBusPrice($lastinsert_ID, 'price_inside_billboards', $request->input('price_inside_billboards'), 'number_inside_billboards', $request->input('number_inside_billboards'), 'duration_inside_billboards', $request->input('duration_inside_billboards'));
        }
       
        //return to bus product list
       return redirect()->route('dashboard.getBusList')->with('message', 'Successfully Added!');
    }

    //insert price data to bus price table
    public function addBusPrice($id, $pricekey, $pricevalue, $numkey, $numvalue, $durkey, $durvalue)
    {
        $insert = new Busesprice();

        $insert->buses_id = $id;
        $insert->price_key = $pricekey;
        $insert->price_value = $pricevalue;
        $insert->number_key = $numkey;
        $insert->number_value = $numvalue;
        $insert->duration_key = $durkey;
        $insert->duration_value = $durvalue;
       
        $insert->save();

    }

    // delete bus product and price form db tables

    public function getDeleteBusad($busadID)
    {
        $delele_busad = Buses::where('id', $busadID)->first();
        $delele_busad->delete();
        $delete_busadprice = Busesprice::where('buses_id', $busadID);
        $delete_busadprice->delete();
        
        return redirect()->route('dashboard.getBusList')->with(['message' => "Successfully Deleted From the List!"]);
    }

    // update bus product
    public function getUpdateeBusad($ID)
    {
        $busData = Buses::find($ID);
        $buspriceData = Busesprice::where('buses_id', $ID)->get();
        $fieldData = array();
        foreach($buspriceData as $pricebus){
           $fieldData[] = ucwords(str_replace('_', ' ', substr($pricebus->price_key, 6)));
        }
      
       $fieldDatas = serialize($fieldData);
        return view('backend.mediatypes.buses.bus-editform', ['bus' => $busData, 'buspricemeta' => $buspriceData, 'fieldData' => $fieldDatas]);
    }
    //check and uncheck options remove
    public function getuncheckBusadOptions(Request $request)
    {
        $displayoptions = json_decode($request['displayoptions']);
        $datta = array();
        foreach($displayoptions as $options){
			$datta[] = strtolower(str_replace(' ', '_', $options));
		
		}
        $count = Busesprice::where([
                                    ['buses_id', '=', $request['id']],
                                    ['price_key', '=', $request['price_key']],
                                ])->count();
        if($count > 0){
            Buses::where('id', $request['id'])->update(['display_options' => serialize($datta)]);
            $buses = Busesprice::where([
                                    ['buses_id', '=', $request['id']],
                                    ['price_key', '=', $request['price_key']],
                                ])->first();
            $buses->delete();

            return response(['msg' => 'price deleted'], 200);
        }else{
              
            return response(['msg' => 'Value not present in db!'], 200);
        }
    }
// this fnction updste busads 
// $id ad id
// $request form data
    public function postUpdateeBusad(Request $request, $ID)
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

        $editbus = Buses::find($ID);

         $editbus->title = $request->input('title');
         $editbus->price = $request->input('price');
         $editbus->location = $request->input('location');
         $editbus->state = $request->input('state');
         $editbus->city = $request->input('city');
         $editbus->rank = $request->input('rank');
         $editbus->description = $request->input('description');
         $editbus->status = $request->input('status');
         $editbus->references = $request->input('reference');
         $editbus->display_options = serialize($request->input('busdisplay'));
          $editbus->busnumber = $request->input('busesnumber');
          $editbus->discount = $request->input('busdiscount');

        if($request->hasFile('image')){
            $file = $request->file('image');
            $filename = time() .'.'. $file->getClientOriginalExtension();
            $location = public_path("images\buses\\" . $filename);
            Image::make($file)->resize(800, 400)->save($location);
            $oldimage = $editbus->image;
            $editbus->image = $filename;
        }

       $editbus->update();

        //bus display prices insertion

        if($request->has('price_full')){
            $this->updateBusPrice($ID, 'price_full', $request->input('price_full'), 'number_full', $request->input('number_full'), 'duration_full', $request->input('duration_full'));
        }
       

        if($request->has('price_both_side')){
            $this->updateBusPrice($ID, 'price_both_side', $request->input('price_both_side'), 'number_both_side', $request->input('number_both_side'), 'duration_both_side', $request->input('duration_both_side'));
        }


        if($request->has('price_left_side')){
            $this->updateBusPrice($ID, 'price_left_side', $request->input('price_left_side'), 'number_left_side', $request->input('number_left_side'), 'duration_left_side', $request->input('duration_left_side'));
        }

        if($request->has('price_right_side')){
            $this->updateBusPrice($ID, 'price_right_side', $request->input('price_right_side'),'number_right_side', $request->input('number_right_side'), 'duration_right_side', $request->input('duration_right_side'));
        }
        
        if($request->has('price_back_side')){
            $this->updateBusPrice($ID, 'price_back_side', $request->input('price_back_side'), 'number_back_side', $request->input('number_back_side'), 'duration_back_side', $request->input('duration_back_side'));
        }
        

        if($request->has('price_back_glass')){
            $this->updateBusPrice($ID, 'price_back_glass', $request->input('price_back_glass'), 'number_back_glass', $request->input('number_back_glass'), 'duration_back_glass', $request->input('duration_back_glass'));
        }

        if($request->has('price_internal_ceiling')){
            $this->updateBusPrice($ID, 'price_internal_ceiling', $request->input('price_internal_ceiling'), 'number_internal_ceiling', $request->input('number_internal_ceiling'), 'duration_internal_ceiling', $request->input('duration_internal_ceiling'));
        }
       

        if($request->has('price_bus_grab_handles')){
            $this->updateBusPrice($ID, 'price_bus_grab_handles', $request->input('price_bus_grab_handles'), 'number_bus_grab_handles', $request->input('number_bus_grab_handles'), 'duration_bus_grab_handles', $request->input('duration_bus_grab_handles'));
        }
        

        if($request->has('price_inside_billboards')){
            $this->updateBusPrice($ID, 'price_inside_billboards', $request->input('price_inside_billboards'), 'number_inside_billboards', $request->input('number_inside_billboards'), 'duration_inside_billboards', $request->input('duration_inside_billboards'));
        }
       

        //return to bus product list
       return redirect()->route('dashboard.getBusList')->with('message', 'Successfully Edited!');
    }

    public function updateBusPrice( $id, $pricekey, $pricevalue, $numkey, $numvalue, $durkey, $durvalue){
        $count = Busesprice::where([
                                    ['buses_id', '=', $id],
                                    ['price_key', '=', $pricekey],
                                ])->count();
        if($count < 1){
            $this->addBusPrice($id, $pricekey, $pricevalue, $numkey, $numvalue, $durkey, $durvalue);
        }else{
            $update = Busesprice::where([
                                    ['buses_id', '=', $id],
                                    ['price_key', '=', $pricekey],
                                ])->update(['price_value' => $pricevalue, 'number_value' => $numvalue, 'duration_value' => $durvalue]);
        }
        
   }

   //Fliter Functions
   public function getFilterBusAds(Request $request){

       $busPrice = new Busesprice();
        $filterResults = $busPrice->FilterBusesAds($request->all());
        if(count($filterResults)>0){
            foreach($filterResults as $searchBus){
                $this->bus_ads($searchBus, $request->all());
            }

        }else{
            echo "<strong>No Results Found!</strong>";
        }

        $content = ob_get_contents();
        ob_get_clean();
        return $content;
       
       
   }
   public function bus_ads($searchBus)
   {
       ?>
       <div class="col-md-3 col-sm-3 "> 
        <div class="pro-item"> 
            <div class=" cat-opt-img "> <img src="<?= asset('images/buses/'.$searchBus[11]) ?>"> </div>
            <p class="font-1"><?= $searchBus[3] ?></p>
            <p class="font-2"><?= $searchBus[5] ?> | <?= $searchBus[6] ?> | <?= $searchBus[7] ?></p>
            <p class="font-3"><?= $searchBus[20]?> <?= ucwords(substr(str_replace('_', ' ', $searchBus[18]), 6))?> for <?= $searchBus[22]?> months</p>
            <p class="font-2"><del class="lighter">Rs <?= $searchBus[19]?> </del>Rs <?= $searchBus[19]?> </p>
            <?php
            $options = $searchBus[19].'+'.$searchBus[18];
            $session_key = 'buses'.'_'.$searchBus[18].'_'.$searchBus[0];
            $printsession = (array) Session::get('cart');
                            
           ?>
            <div class="clearfix"> 
                <a class="glass" href="<?= route('bus.addtocart', ['id' => $searchBus[0], 'variation' => $options]) ?>"><span class="fa fa-star"></span>
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
            </a> 
            </div>
        </div>
    </div>
    <?php
   }

    //cart functions
   // add or remove item to cart
   public function getAddToCart(Request $request, $id, $variation)
   {
        $bus_ad = Buses::where('id', $id)->first()->toArray();

        $busPrice = new Busesprice();
        $bus_price = $busPrice->getBusespriceCart($id, $variation);
               
        $bus_Ad = array_merge($bus_ad, $bus_price);
        
        $oldCart = Session::has('cart') ? Session::get('cart') : null;
                
        $cart = new Cart($oldCart);

        $status = $cart->addorRemove($bus_Ad, $bus_ad['id'], 'buses', $flag=true); //pass full bus details, id and model name like "buses"
        
        $request->session()->put('cart', $cart);
        //Session::forget('cart');

        return redirect()->back()->with(['status' => $status]);
    }

 
}
