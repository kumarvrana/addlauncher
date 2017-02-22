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


    // get list of all the products in bus stop media type
    public function getDashboardMetroList(){
        $metro_ads = Metros::all();
        return view('backend.mediatypes.metros.metro-list', ['metro_ads' => $metro_ads]);
    }
    
    // get form of bus stop media type
     public function getDashboardMetroForm()
    {
        return view('backend.mediatypes.metros.metro-addform');
    }

    // post list of all the products in bus media type

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
                'display_options' => serialize($request->input('busdisplay')),
                'light_option' => $request->input('bslighting'),
                'metronumber' => $request->input('metrosnumber')
        ]);

        $metro->save();

        $lastinsert_ID = $metro->id;



        //bus display prices insertion

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
      
      

       
        //return to bus product list
       return redirect()->route('dashboard.getMetroList')->with('message', 'Successfully Added!');
    }

    //insert price data to bus price table
    public function addMetroPrice($id, $key, $value)
    {
        $insert = new Metrosprice();

        $insert->metros_id = $id;
        $insert->price_key = $key;
        $insert->price_value = $value;
       
        $insert->save();

    }

    // delete bus product and price form db tables

    public function getDeleteMetroad($metroadID)
    {
        $delele_busad = Metros::where('id', $metroadID)->first();
        $delele_busad->delete();
        $delete_metroadprice = Metrosprice::where('metros_id', $metroadID);
        $delete_metroadprice->delete();
        // $delete_product = Product::where([
        //                             ['media_id', '=', $metroadID],
        //                             ['media_type', '=', 'Metros'],
        //                         ])->first();
        // $delete_product->delete();
        return redirect()->route('dashboard.getMetroList')->with(['message' => "Successfully Deleted From the List!"]);
    }

    // update bus product
    public function getUpdateeBusad($ID)
    {
        $metroData = Buses::find($ID);
        $metropriceData = Busesprice::where('buses_id', $ID)->get();
        $fieldData = array();
        foreach($metropriceData as $pricebus){
           $fieldData[] = ucwords(substr(str_replace("_", " ", $pricebus->price_key), 6));
        }
       $fieldData = serialize($fieldData);
        return view('backend.mediatypes.buses.bus-editform', ['bus' => $metroData, 'buspricemeta' => $metropriceData, 'fieldData' => $fieldData]);
    }
    //check and uncheck options remove
    public function getuncheckBusadOptions(Request $request)
    {
        $count = Busesprice::where([
                                    ['buses_id', '=', $request['id']],
                                    ['price_key', '=', $request['price_key']],
                                ])->count();
        if($count > 0){
            Buses::where('id', $request['id'])->update(['display_options' => serialize($request['displayoptions'])]);
            $buses = Busesprice::where([
                                    ['buses_id', '=', $request['id']],
                                    ['price_key', '=', $request['price_key']],
                                ])->first();
            $buses->delete();
            return response(['msg' => 'price deleted'], 200);
        }
              
            return response(['msg' => 'Value not present in db!'], 200);
        
    }

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
        if($request->has('price_both_side')){
            $this->updateBusPrice($ID, 'price_both_side', $request->input('price_both_side'));
        }
        if($request->has('price_left_side')){
            $this->updateBusPrice($ID, 'price_left_side', $request->input('price_left_side'));
        }
        if($request->has('price_right_side')){
            $this->updateBusPrice($ID, 'price_right_side', $request->input('price_right_side'));
        }
        if($request->has('price_back_side')){
            $this->updateBusPrice($ID, 'price_back_side', $request->input('price_back_side'));
        }
        if($request->has('price_back_glass')){
            $this->updateBusPrice($ID, 'price_back_glass', $request->input('price_back_glass'));
        }
        if($request->has('price_internal_ceiling')){
            $this->updateBusPrice($ID, 'price_internal_ceiling', $request->input('price_internal_ceiling'));
        }
        if($request->has('price_bus_grab_handles')){
            $this->updateBusPrice($ID, 'price_bus_grab_handles', $request->input('price_bus_grab_handles'));
        }
        if($request->has('price_inside_billboards')){
            $this->updateBusPrice($ID, 'price_inside_billboards', $request->input('price_inside_billboards'));
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
        $metro_ad = Buses::where('id', $id)->first()->toArray();
        
        $selectDisplayOpt = explode("+", $variation);
        $metro_price = Busesprice::where([
                                    ['buses_id', '=', $id],
                                    ['price_key', '=', $selectDisplayOpt[1]],
                                ])->first()->toArray();
        
        $metro_Ad = array_merge($metro_ad, $metro_price);
       
        $oldCart = Session::has('cart') ? Session::get('cart') : null;
                
        $cart = new Cart($oldCart);

        $cart->addorRemove($metro_Ad, $metro_ad['id'], 'buses'); //pass full bus details, id and model name like "buses"
        
        $request->session()->put('cart', $cart);
        //Session::forget('cart');

        return redirect()->back()->with(['status' => 'added']);
    }

 
}
