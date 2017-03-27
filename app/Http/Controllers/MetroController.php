<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use Session;
use App\Metros;
use App\Metrosprice;
use Image;
use App\Product;
use Illuminate\Support\Facades\File;
use App\Cart;
use App\Order;


class MetroController extends Controller
{
    
    //frontend function starts
    
    public function getfrontendAllMetroads()
    {
       $metro_ads = Metros::all();
       return view('frontend-mediatype.metros.metroads-list', ['products' => $metro_ads]);
    }
    
    public function getfrontMetroad($id)
    {
        $metroad = Metros::find($id);
       
        $metroprice = Metrosprice::where('metros_id', $id)->get();
        return view('frontend-mediatype.metros.metro-single', ['metroad' => $metroad, 'metroprice' => $metroprice]);
    }
    
    
    // frontend functions ends

    //Backend functions below


    // get list of all the products in metro stop media type
    public function getDashboardMetroList(){
        $metro_ads = Metros::all();
        return view('backend.mediatypes.metros.metro-list', ['metro_ads' => $metro_ads]);
    }
    
    // get form of metro stop media type
     public function getDashboardMetroForm()
    {
        return view('backend.mediatypes.metros.metro-addform');
    }

    // post list of all the products in metro media type

    public function postDashboardMetroForm(Request $request)
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
            $location = public_path("images\metros\\" . $filename);
            Image::make($file)->resize(800, 400)->save($location);
        }

        $metro = new Metros([
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
                'display_options' => serialize($request->input('metrodisplay')),
                'light_option' => $request->input('metrolight'),
                'discount' => $request->input('metrodiscount'),
                'metronumber' => $request->input('metrosnumber')
        ]);

        $metro->save();

        $lastinsert_ID = $metro->id;



        //metro display prices insertion
if($request->has('price_full')){
            $this->addMetroPrice($lastinsert_ID, 'price_full', $request->input('price_full'));
        }
      
       if($request->has('number_full')){
            $this->addMetroPrice($lastinsert_ID, 'number_full', $request->input('number_full'));
        }

       if($request->has('duration_full')){
            $this->addMetroPrice($lastinsert_ID, 'duration_full', $request->input('duration_full'));
        }

        if($request->has('price_roof_front')){
            $this->addMetroPrice($lastinsert_ID, 'price_roof_front', $request->input('price_roof_front'));
        }
        if($request->has('number_roof_front')){
            $this->addMetroPrice($lastinsert_ID, 'number_roof_front', $request->input('number_roof_front'));
        }
        if($request->has('duration_roof_front')){
            $this->addMetroPrice($lastinsert_ID, 'duration_roof_front', $request->input('duration_roof_front'));
        }
        if($request->has('price_seat_backs')){
            $this->addMetroPrice($lastinsert_ID, 'price_seat_backs', $request->input('price_seat_backs'));
        }
         if($request->has('number_seat_backs')){
            $this->addMetroPrice($lastinsert_ID, 'number_seat_backs', $request->input('number_seat_backs'));
        }
      
       if($request->has('duration_seat_backs')){
            $this->addMetroPrice($lastinsert_ID, 'duration_seat_backs', $request->input('duration_seat_backs'));
        }
      
       if($request->has('price_side_boards')){
            $this->addMetroPrice($lastinsert_ID, 'price_side_boards', $request->input('price_side_boards'));
        }
      
       if($request->has('number_side_boards')){
            $this->addMetroPrice($lastinsert_ID, 'number_side_boards', $request->input('number_side_boards'));
        }

      if($request->has('duration_side_boards')){
            $this->addMetroPrice($lastinsert_ID, 'duration_side_boards', $request->input('duration_side_boards'));
        }
      
      


       
        //return to metro product list
       return redirect()->route('dashboard.getMetroList')->with('message', 'Successfully Added!');
    }

    //insert price data to metro price table
    public function addMetroPrice($id, $key, $value)
    {
        $insert = new Metrosprice();

        $insert->metros_id = $id;
        $insert->price_key = $key;
        $insert->price_value = $value;
       
        $insert->save();

    }

    // delete metro product and price form db tables

    public function getDeleteMetroad($metroadID)
    {
        $delele_metroad = Metros::where('id', $metroadID)->first();
        $delele_metroad->delete();
        $delete_metroadprice = Metrosprice::where('metros_id', $metroadID);
        $delete_metroadprice->delete();
       
        return redirect()->route('dashboard.getMetroList')->with(['message' => "Successfully Deleted From the List!"]);
    }

    // update metro product
    public function getUpdateeMetroad($ID)
    {
        $metroData = Metros::find($ID);
        $metropriceData = Metrosprice::where('metros_id', $ID)->get();
        $fieldData = array();
        foreach($metropriceData as $pricemetro){
           $fieldData[] = $pricemetro->price_key;
        }
        $name_key = array_chunk($fieldData, 3);
        $datta = array();
         $j = 0; 
        foreach($name_key as $options){
            $datta[$j] = ucwords(str_replace('_', ' ', substr($options[0], 6)));
            $j++;
        }
       $fieldDatas = serialize($datta);
        return view('backend.mediatypes.metros.metro-editform', ['metro' => $metroData, 'metropricemeta' => $metropriceData, 'fieldData' => $fieldDatas]);
    }
    //check and uncheck options remove
    public function getuncheckMetroadOptions(Request $request)
    {
        $count = Metrosprice::where([
                                    ['metros_id', '=', $request['id']],
                                    ['price_key', '=', $request['price_key']],
                                ])->count();
        if($count > 0){
            Metros::where('id', $request['id'])->update(['display_options' => serialize($request['displayoptions'])]);
            $metros = Metrosprice::where([
                                    ['metros_id', '=', $request['id']],
                                    ['price_key', '=', $request['price_key']],
                                ])->first();
            $metros->delete();
            return response(['msg' => 'price deleted'], 200);
        }
              
            return response(['msg' => 'Value not present in db!'], 200);
        
    }

    public function postUpdateeMetroad(Request $request, $ID)
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

        $editmetro = Metros::find($ID);

         $editmetro->title = $request->input('title');
         $editmetro->price = $request->input('price');
         $editmetro->location = $request->input('location');
         $editmetro->state = $request->input('state');
         $editmetro->city = $request->input('city');
         $editmetro->rank = $request->input('rank');
         $editmetro->description = $request->input('description');
         $editmetro->status = $request->input('status');
         $editmetro->references = $request->input('reference');
         $editmetro->display_options = serialize($request->input('metrodisplay'));
          $editmetro->metronumber = $request->input('metrosnumber');
          $editmetro->discount = $request->input('metrodiscount');

        if($request->hasFile('image')){
            $file = $request->file('image');
            $filename = time() .'.'. $file->getClientOriginalExtension();
            $location = public_path("images\metros\\" . $filename);
            Image::make($file)->resize(800, 400)->save($location);
            $oldimage = $editmetro->image;
            $editmetro->image = $filename;
        }

       $editmetro->update();

        //metro display prices insertion

        if($request->has('price_full')){
            $this->updateMetroPrice($ID, 'price_full', $request->input('price_full'));
        }
      
       if($request->has('number_full')){
            $this->updateMetroPrice($ID, 'number_full', $request->input('number_full'));
        }

       if($request->has('duration_full')){
            $this->updateMetroPrice($ID, 'duration_full', $request->input('duration_full'));
        }

        if($request->has('price_roof_front')){
            $this->updateMetroPrice($ID, 'price_roof_front', $request->input('price_roof_front'));
        }
        if($request->has('number_roof_front')){
            $this->updateMetroPrice($ID, 'number_roof_front', $request->input('number_roof_front'));
        }
        if($request->has('duration_roof_front')){
            $this->updateMetroPrice($ID, 'duration_roof_front', $request->input('duration_roof_front'));
        }
        if($request->has('price_seat_backs')){
            $this->updateMetroPrice($ID, 'price_seat_backs', $request->input('price_seat_backs'));
        }
         if($request->has('number_seat_backs')){
            $this->updateMetroPrice($ID, 'number_seat_backs', $request->input('number_seat_backs'));
        }
      
       if($request->has('duration_seat_backs')){
            $this->updateMetroPrice($ID, 'duration_seat_backs', $request->input('duration_seat_backs'));
        }
      
       if($request->has('price_side_boards')){
            $this->updateMetroPrice($ID, 'price_side_boards', $request->input('price_side_boards'));
        }
      
       if($request->has('number_side_boards')){
            $this->updateMetroPrice($ID, 'number_side_boards', $request->input('number_side_boards'));
        }

      if($request->has('duration_side_boards')){
            $this->updateMetroPrice($ID, 'duration_side_boards', $request->input('duration_side_boards'));
        }
      
        

        //return to metro product list
       return redirect()->route('dashboard.getMetroList')->with('message', 'Successfully Edited!');
    }

    public function updateMetroPrice( $id, $meta_key, $meta_value){
        $count = Metrosprice::where([
                                    ['metros_id', '=', $id],
                                    ['price_key', '=', $meta_key],
                                ])->count();
        if($count < 1){
            $this->addMetroPrice($id, $meta_key, $meta_value);
        }else{
            $update = Metrosprice::where([
                                    ['metros_id', '=', $id],
                                    ['price_key', '=', $meta_key],
                                ])->update(['price_value' => $meta_value]);
        }
        
   }

    //cart functions
   // add or remove item to cart
   public function getAddToCart(Request $request, $id, $variation)
   {
        $metro_ad = Metros::where('id', $id)->first()->toArray();
        
        $selectDisplayOpt = explode("+", $variation);
        $main_key = substr($selectDisplayOpt[1], 6);
        
        $number_key = "number_".$main_key;
        $duration_key = "duration_".$main_key;
     
        $metro_price = Metrosprice::where([
                                    ['metros_id', '=', $id],
                                    ['price_key', '=', $selectDisplayOpt[1]],
                                ])->first()->toArray();
       
        $metro_number = Metrosprice::where([
                                    ['metros_id', '=', $id],
                                    ['price_key', '=', $number_key],
                                ])->first()->toArray();
        $metro_duration = Metrosprice::where([
                                    ['metros_id', '=', $id],
                                    ['price_key', '=', $duration_key],
                                ])->first()->toArray();
        $metro_change_price = array();
        foreach($metro_price as $key => $value){
            if($key == 'price_key'){
                $metro_change_price[$key] = $value;
            }
            if($key == 'price_value'){
               $metro_change_price[$key] = $value;
            }
        }
        $metro_change_num = array();
        foreach($metro_number as $key => $value){
            if($key == 'price_key'){
                $key = 'number_key';
                $metro_change_num[$key] = $value;
            }
            if($key == 'price_value'){
                $key = 'number_value';
                $metro_change_num[$key] = $value;
            }
        }
        $metro_change_duration = array();
        foreach($metro_duration as $key => $value){
            if($key == 'price_key'){
                $key = 'duration_key';
                $metro_change_duration[$key] = $value;
            }
            if($key == 'price_value'){
                $key = 'duration_value';
                $metro_change_duration[$key] = $value;
            }
        }
        $metro_merge = array_merge($metro_change_num, $metro_change_duration);
        
        $metro_price = array_merge($metro_change_price, $metro_merge);
        
        $metro_Ad = array_merge($metro_ad, $metro_price);
       
        $oldCart = Session::has('cart') ? Session::get('cart') : null;
                
        $cart = new Cart($oldCart);

        $cart->addorRemove($metro_Ad, $metro_ad['id'], 'metros'); //pass full metro details, id and model name like "metros"
        
        $request->session()->put('cart', $cart);
        //Session::forget('cart');

        return redirect()->back()->with(['status' => 'added']);
    }

 
}
