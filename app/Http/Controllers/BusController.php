<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use Session;
use App\Buses;
use App\Busesprice;
use Image;
use App\Product;
use Illuminate\Support\Facades\File;
use App\Cart;
use App\Order;

class BusController extends Controller
{
    
    //frontend function starts
    
    public function getfrontendAllBusads()
    {
       $bus_ads = Buses::all();
       return view('frontend-mediatype.buses.busads-list', ['products' => $bus_ads]);
    }
    
    public function getfrontBusad($id)
    {
        $busad = Buses::find($id);
        $busprice = Busesprice::where('buses_id', $id)->get();
        return view('frontend-mediatype.buses.bus-single', ['busad' => $busad, 'busprice' => $busprice]);
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
            $this->addBusPrice($lastinsert_ID, 'price_full', $request->input('price_full'));
        }
        if($request->has('number_full')){
            $this->addBusPrice($lastinsert_ID, 'number_full', $request->input('number_full'));
        }

       if($request->has('duration_full')){
            $this->addBusPrice($lastinsert_ID, 'duration_full', $request->input('duration_full'));
        }


        if($request->has('price_both_side')){
            $this->addBusPrice($lastinsert_ID, 'price_both_side', $request->input('price_both_side'));
        }
        if($request->has('number_both_side')){
            $this->addBusPrice($lastinsert_ID, 'number_both_side', $request->input('number_both_side'));
        }

       if($request->has('duration_both_side')){
            $this->addBusPrice($lastinsert_ID, 'duration_both_side', $request->input('duration_both_side'));
        }

        if($request->has('price_left_side')){
            $this->addBusPrice($lastinsert_ID, 'price_left_side', $request->input('price_left_side'));
        }
        if($request->has('number_left_side')){
            $this->addBusPrice($lastinsert_ID, 'number_left_side', $request->input('number_left_side'));
        }

       if($request->has('duration_left_side')){
            $this->addBusPrice($lastinsert_ID, 'duration_left_side', $request->input('duration_left_side'));
        }


        if($request->has('price_right_side')){
            $this->addBusPrice($lastinsert_ID, 'price_right_side', $request->input('price_right_side'));
        }
        if($request->has('number_right_side')){
            $this->addBusPrice($lastinsert_ID, 'number_right_side', $request->input('number_right_side'));
        }

       if($request->has('duration_right_side')){
            $this->addBusPrice($lastinsert_ID, 'duration_right_side', $request->input('duration_right_side'));
        }


        if($request->has('price_back_side')){
            $this->addBusPrice($lastinsert_ID, 'price_back_side', $request->input('price_back_side'));
        }
        if($request->has('number_back_side')){
            $this->addBusPrice($lastinsert_ID, 'number_back_side', $request->input('number_back_side'));
        }

       if($request->has('duration_back_side')){
            $this->addBusPrice($lastinsert_ID, 'duration_back_side', $request->input('duration_back_side'));
        }


        if($request->has('price_back_glass')){
            $this->addBusPrice($lastinsert_ID, 'price_back_glass', $request->input('price_back_glass'));
        }
        if($request->has('number_back_glass')){
            $this->addBusPrice($lastinsert_ID, 'number_back_glass', $request->input('number_back_glass'));
        }

       if($request->has('duration_back_glass')){
            $this->addBusPrice($lastinsert_ID, 'duration_back_glass', $request->input('duration_back_glass'));
        }


        if($request->has('price_internal_ceiling')){
            $this->addBusPrice($lastinsert_ID, 'price_internal_ceiling', $request->input('price_internal_ceiling'));
        }
        if($request->has('number_internal_ceiling')){
            $this->addBusPrice($lastinsert_ID, 'number_internal_ceiling', $request->input('number_internal_ceiling'));
        }

       if($request->has('duration_internal_ceiling')){
            $this->addBusPrice($lastinsert_ID, 'duration_internal_ceiling', $request->input('duration_internal_ceiling'));
        }


        if($request->has('price_bus_grab_handles')){
            $this->addBusPrice($lastinsert_ID, 'price_bus_grab_handles', $request->input('price_bus_grab_handles'));
        }
        if($request->has('number_bus_grab_handles')){
            $this->addBusPrice($lastinsert_ID, 'number_bus_grab_handles', $request->input('number_bus_grab_handles'));
        }

       if($request->has('duration_bus_grab_handles')){
            $this->addBusPrice($lastinsert_ID, 'duration_bus_grab_handles', $request->input('duration_bus_grab_handles'));
        }


        if($request->has('price_inside_billboards')){
            $this->addBusPrice($lastinsert_ID, 'price_inside_billboards', $request->input('price_inside_billboards'));
        }
        if($request->has('number_inside_billboards')){
            $this->addBusPrice($lastinsert_ID, 'number_inside_billboards', $request->input('number_inside_billboards'));
        }

       if($request->has('duration_inside_billboards')){
            $this->addBusPrice($lastinsert_ID, 'duration_inside_billboards', $request->input('duration_inside_billboards'));
        }

       
        //return to bus product list
       return redirect()->route('dashboard.getBusList')->with('message', 'Successfully Added!');
    }

    //insert price data to bus price table
    public function addBusPrice($id, $key, $value)
    {
        $insert = new Busesprice();

        $insert->buses_id = $id;
        $insert->price_key = $key;
        $insert->price_value = $value;
       
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
           $fieldData[] = $pricebus->price_key;
        }
       $name_key = array_chunk($fieldData, 3);
        $datta = array();
         $j = 0; 
		foreach($name_key as $options){
			$datta[$j] = ucwords(str_replace('_', ' ', substr($options[0], 6)));
			$j++;
		}
       $fieldDatas = serialize($datta);
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
            $busesnumber = Busesprice::where([
                                    ['buses_id', '=', $request['id']],
                                    ['price_key', '=', $request['number_key']]
                                ])->first();
            $busesnumber->delete();
            $busesduration = Busesprice::where([
                                    ['buses_id', '=', $request['id']],
                                    ['price_key', '=', $request['duration_key']]
                                ])->first();
            $busesduration->delete();
            return response(['msg' => 'price deleted'], 200);
        }
              
            return response(['msg' => 'Value not present in db!'], 200);
        
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
            $this->updateBusPrice($ID, 'price_full', $request->input('price_full'));
        }
        if($request->has('number_full')){
            $this->updateBusPrice($ID, 'number_full', $request->input('number_full'));
        }

       if($request->has('duration_full')){
            $this->updateBusPrice($ID, 'duration_full', $request->input('duration_full'));
        }



        if($request->has('price_both_side')){
            $this->updateBusPrice($ID, 'price_both_side', $request->input('price_both_side'));
        }

        if($request->has('number_both_side')){
            $this->updateBusPrice($ID, 'number_both_side', $request->input('number_both_side'));
        }

       if($request->has('duration_both_side')){
            $this->updateBusPrice($ID, 'duration_both_side', $request->input('duration_both_side'));
        }


        if($request->has('price_left_side')){
            $this->updateBusPrice($ID, 'price_left_side', $request->input('price_left_side'));
        }
        if($request->has('number_left_side')){
            $this->updateBusPrice($ID, 'number_left_side', $request->input('number_left_side'));
        }

       if($request->has('duration_left_side')){
            $this->updateBusPrice($ID, 'duration_left_side', $request->input('duration_left_side'));
        }


        if($request->has('price_right_side')){
            $this->updateBusPrice($ID, 'price_right_side', $request->input('price_right_side'));
        }
        if($request->has('number_right_side')){
            $this->updateBusPrice($ID, 'number_right_side', $request->input('number_right_side'));
        }

       if($request->has('duration_right_side')){
            $this->updateBusPrice($ID, 'duration_right_side', $request->input('duration_right_side'));
        }


        if($request->has('price_back_side')){
            $this->updateBusPrice($ID, 'price_back_side', $request->input('price_back_side'));
        }
        if($request->has('number_back_side')){
            $this->updateBusPrice($ID, 'number_back_side', $request->input('number_back_side'));
        }

       if($request->has('duration_back_side')){
            $this->updateBusPrice($ID, 'duration_back_side', $request->input('duration_back_side'));
        }


        if($request->has('price_back_glass')){
            $this->updateBusPrice($ID, 'price_back_glass', $request->input('price_back_glass'));
        }
        if($request->has('number_back_glass')){
            $this->updateBusPrice($ID, 'number_back_glass', $request->input('number_back_glass'));
        }

       if($request->has('duration_back_glass')){
            $this->updateBusPrice($ID, 'duration_back_glass', $request->input('duration_back_glass'));
        }


        if($request->has('price_internal_ceiling')){
            $this->updateBusPrice($ID, 'price_internal_ceiling', $request->input('price_internal_ceiling'));
        }
        if($request->has('number_internal_ceiling')){
            $this->updateBusPrice($ID, 'number_internal_ceiling', $request->input('number_internal_ceiling'));
        }

       if($request->has('duration_internal_ceiling')){
            $this->updateBusPrice($ID, 'duration_internal_ceiling', $request->input('duration_internal_ceiling'));
        }


        if($request->has('price_bus_grab_handles')){
            $this->updateBusPrice($ID, 'price_bus_grab_handles', $request->input('price_bus_grab_handles'));
        }
        if($request->has('number_bus_grab_handles')){
            $this->updateBusPrice($ID, 'number_bus_grab_handles', $request->input('number_bus_grab_handles'));
        }

       if($request->has('duration_bus_grab_handles')){
            $this->updateBusPrice($ID, 'duration_bus_grab_handles', $request->input('duration_bus_grab_handles'));
        }


        if($request->has('price_inside_billboards')){
            $this->updateBusPrice($ID, 'price_inside_billboards', $request->input('price_inside_billboards'));
        }
        if($request->has('number_inside_billboards')){
            $this->updateBusPrice($ID, 'number_inside_billboards', $request->input('number_inside_billboards'));
        }

       if($request->has('duration_inside_billboards')){
            $this->updateBusPrice($ID, 'duration_inside_billboards', $request->input('duration_inside_billboards'));
        }

        

        //return to bus product list
       return redirect()->route('dashboard.getBusList')->with('message', 'Successfully Edited!');
    }

    public function updateBusPrice( $id, $meta_key, $meta_value){
        $count = Busesprice::where([
                                    ['buses_id', '=', $id],
                                    ['price_key', '=', $meta_key],
                                ])->count();
        if($count < 1){
            $this->addBusPrice($id, $meta_key, $meta_value);
        }else{
            $update = Busesprice::where([
                                    ['buses_id', '=', $id],
                                    ['price_key', '=', $meta_key],
                                ])->update(['price_value' => $meta_value]);
        }
        
   }

    //cart functions
   // add or remove item to cart
   public function getAddToCart(Request $request, $id, $variation)
   {
        $bus_ad = Buses::where('id', $id)->first()->toArray();
        
        $selectDisplayOpt = explode("+", $variation);
        $main_key = substr($selectDisplayOpt[1], 6);
        
        $number_key = "number_".$main_key;
        $duration_key = "duration_".$main_key;

        $bus_price = Busesprice::where([
                                    ['buses_id', '=', $id],
                                    ['price_key', '=', $selectDisplayOpt[1]],
                                ])->first()->toArray();

        $billboard_number = Busesprice::where([
                                    ['buses_id', '=', $id],
                                    ['price_key', '=', $number_key],
                                ])->first()->toArray();
        $billboard_duration = Busesprice::where([
                                    ['buses_id', '=', $id],
                                    ['price_key', '=', $duration_key],
                                ])->first()->toArray();
        $bus_change_price = array();
        foreach($bus_price as $key => $value){
            if($key == 'price_key'){
                $bus_change_price[$key] = $value;
            }
            if($key == 'price_value'){
               $bus_change_price[$key] = $value;
            }
        }
        $bus_change_num = array();
        foreach($bus_number as $key => $value){
            if($key == 'price_key'){
                $key = 'number_key';
                $bus_change_num[$key] = $value;
            }
            if($key == 'price_value'){
                $key = 'number_value';
                $bus_change_num[$key] = $value;
            }
        }
        $bus_change_duration = array();
        foreach($bus_duration as $key => $value){
            if($key == 'price_key'){
                $key = 'duration_key';
                $bus_change_duration[$key] = $value;
            }
            if($key == 'price_value'){
                $key = 'duration_value';
                $bus_change_duration[$key] = $value;
            }
        }
        $bus_merge = array_merge($bus_change_num, $bus_change_duration);
        
        $bus_price = array_merge($bus_change_price, $bus_merge);
        
        $bus_Ad = array_merge($bus_ad, $bus_price);
       
        $oldCart = Session::has('cart') ? Session::get('cart') : null;
                
        $cart = new Cart($oldCart);

        $cart->addorRemove($bus_Ad, $bus_ad['id'], 'buses'); //pass full bus details, id and model name like "buses"
        
        $request->session()->put('cart', $cart);
        //Session::forget('cart');

        return redirect()->back()->with(['status' => 'added']);
    }

 
}
