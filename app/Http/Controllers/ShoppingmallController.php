<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use Session;
use App\Shoppingmalls;
use App\Shoppingmallsprice;
use Image;
use App\Product;
use Illuminate\Support\Facades\File;
use App\Cart;
use App\Order;


class ShoppingmallController extends Controller
{
    
    //frontend function starts
    
    public function getfrontendAllShoppingmallads()
    {
       $shoppingmall_ads = Shoppingmalls::all();
       return view('frontend-mediatype.shoppingmalls.shoppingmallads-list', ['products' => $shoppingmall_ads]);
    }
    
    public function getfrontShoppingmallad($id)
    {
        $shoppingmallad = Shoppingmalls::find($id);
        $shoppingmallprice = Shoppingmallsprice::where('shoppingmalls_id', $id)->get();
        return view('frontend-mediatype.shoppingmalls.shoppingmall-single', ['shoppingmallad' => $shoppingmallad, 'shoppingmallprice' => $shoppingmallprice]);
    }
    
    
    // frontend functions ends

    //Backend functions below


    // get list of all the products in shoppingmall stop media type
    public function getDashboardShoppingmallList(){
        $shoppingmall_ads = Shoppingmalls::all();
        return view('backend.mediatypes.shoppingmalls.shoppingmall-list', ['shoppingmall_ads' => $shoppingmall_ads]);
    }
    
    // get form of shoppingmall stop media type
     public function getDashboardShoppingmallForm()
    {
        return view('backend.mediatypes.shoppingmalls.shoppingmall-addform');
    }

    // post list of all the products in shoppingmall media type

    public function postDashboardShoppingmallForm(Request $request)
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
            $location = public_path("images\shoppingmalls\\" . $filename);
            Image::make($file)->resize(800, 400)->save($location);
        }

        $shoppingmall = new Shoppingmalls([
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
                'display_options' => serialize($request->input('shoppingmalldisplay')),
                'light_option' => $request->input('shoppingmalllighting'),
                'discount' => $request->input('discount'),
                'numberofshoppingmalls' => $request->input('shoppingmallsnumber')
        ]);

        $shoppingmall->save();

        $lastinsert_ID = $shoppingmall->id;



        //shoppingmall display prices insertion
 if($request->has('price_drop_down_banners')){
            $this->addShoppingmallPrice($lastinsert_ID, 'price_drop_down_banners', $request->input('price_drop_down_banners'));
        }
      
       if($request->has('number_drop_down_banners')){
            $this->addShoppingmallPrice($lastinsert_ID, 'number_drop_down_banners', $request->input('number_drop_down_banners'));
        }

       if($request->has('duration_drop_down_banners')){
            $this->addShoppingmallPrice($lastinsert_ID, 'duration_drop_down_banners', $request->input('duration_drop_down_banners'));
        }

        if($request->has('price_free_stand_display')){
            $this->addShoppingmallPrice($lastinsert_ID, 'price_free_stand_display', $request->input('price_free_stand_display'));
        }
        if($request->has('number_free_stand_display')){
            $this->addShoppingmallPrice($lastinsert_ID, 'number_free_stand_display', $request->input('number_free_stand_display'));
        }
        if($request->has('duration_free_stand_display')){
            $this->addShoppingmallPrice($lastinsert_ID, 'duration_free_stand_display', $request->input('duration_free_stand_display'));
        }

          if($request->has('price_walls')){
            $this->addShoppingmallPrice($lastinsert_ID, 'price_walls', $request->input('price_walls'));
        }
        if($request->has('number_walls')){
            $this->addShoppingmallPrice($lastinsert_ID, 'number_walls', $request->input('number_walls'));
        }
        if($request->has('duration_walls')){
            $this->addShoppingmallPrice($lastinsert_ID, 'duration_walls', $request->input('duration_walls'));
        }

          if($request->has('price_poles_or_pillar')){
            $this->addShoppingmallPrice($lastinsert_ID, 'price_poles_or_pillar', $request->input('price_poles_or_pillar'));
        }
        if($request->has('number_poles_or_pillar')){
            $this->addShoppingmallPrice($lastinsert_ID, 'number_poles_or_pillar', $request->input('number_poles_or_pillar'));
        }
        if($request->has('duration_poles_or_pillar')){
            $this->addShoppingmallPrice($lastinsert_ID, 'duration_poles_or_pillar', $request->input('duration_poles_or_pillar'));
        }

          if($request->has('price_signage')){
            $this->addShoppingmallPrice($lastinsert_ID, 'price_signage', $request->input('price_signage'));
        }
        if($request->has('number_signage')){
            $this->addShoppingmallPrice($lastinsert_ID, 'number_signage', $request->input('number_signage'));
        }
        if($request->has('duration_signage')){
            $this->addShoppingmallPrice($lastinsert_ID, 'duration_signage', $request->input('duration_signage'));
        }
    
      

       
        //return to shoppingmall product list
       return redirect()->route('dashboard.getShoppingmallList')->with('message', 'Successfully Added!');
    }

    //insert price data to shoppingmall price table
    public function addShoppingmallPrice($id, $key, $value)
    {
        $insert = new Shoppingmallsprice();

        $insert->shoppingmalls_id = $id;
        $insert->price_key = $key;
        $insert->price_value = $value;
       
        $insert->save();

    }

    // delete shoppingmall product and price form db tables

    public function getDeleteShoppingmallad($shoppingmalladID)
    {
        $delele_shoppingmallad = Shoppingmalls::where('id', $shoppingmalladID)->first();
        $delele_shoppingmallad->delete();
        $delete_shoppingmalladprice = Shoppingmallsprice::where('shoppingmalls_id', $shoppingmalladID);
        $delete_shoppingmalladprice->delete();
        // $delete_product = Product::where([
        //                             ['media_id', '=', $shoppingmalladID],
        //                             ['media_type', '=', 'Shoppingmalls'],
        //                         ])->first();
        // $delete_product->delete();
        return redirect()->route('dashboard.getShoppingmallList')->with(['message' => "Successfully Deleted From the List!"]);
    }

    // update shoppingmall product
    public function getUpdateeShoppingmallad($ID)
    {
        $shoppingmallData = Shoppingmalls::find($ID);
        $shoppingmallpriceData = Shoppingmallsprice::where('shoppingmalls_id', $ID)->get();
        $fieldData = array();
        foreach($shoppingmallpriceData as $priceshoppingmall){
           $fieldData[] = ucwords(substr(str_replace("_", " ", $priceshoppingmall->price_key), 6));
        }
       $fieldData = serialize($fieldData);
        return view('backend.mediatypes.shoppingmalls.shoppingmall-editform', ['shoppingmall' => $shoppingmallData, 'shoppingmallpricemeta' => $shoppingmallpriceData, 'fieldData' => $fieldData]);
    }
    //check and uncheck options remove
    public function getuncheckShoppingmalladOptions(Request $request)
    {
        $count = Shoppingmallsprice::where([
                                    ['shoppingmalls_id', '=', $request['id']],
                                    ['price_key', '=', $request['price_key']],
                                ])->count();
        if($count > 0){
            Shoppingmalls::where('id', $request['id'])->update(['display_options' => serialize($request['displayoptions'])]);
            $shoppingmalls = Shoppingmallsprice::where([
                                    ['shoppingmalls_id', '=', $request['id']],
                                    ['price_key', '=', $request['price_key']],
                                ])->first();
            $shoppingmalls->delete();
            return response(['msg' => 'price deleted'], 200);
        }
              
            return response(['msg' => 'Value not present in db!'], 200);
        
    }

    public function postUpdateeShoppingmallad(Request $request, $ID)
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

        $editshoppingmall = Shoppingmalls::find($ID);

         $editshoppingmall->title = $request->input('title');
         $editshoppingmall->price = $request->input('price');
         $editshoppingmall->location = $request->input('location');
         $editshoppingmall->state = $request->input('state');
         $editshoppingmall->city = $request->input('city');
         $editshoppingmall->rank = $request->input('rank');
         $editshoppingmall->description = $request->input('description');
         $editshoppingmall->status = $request->input('status');
         $editshoppingmall->references = $request->input('reference');
         $editshoppingmall->display_options = serialize($request->input('shoppingmalldisplay'));
          $editshoppingmall->numberofshoppingmalls = $request->input('shoppingmallsnumber');
          $editshoppingmall->discount = $request->input('discount');

        if($request->hasFile('image')){
            $file = $request->file('image');
            $filename = time() .'.'. $file->getClientOriginalExtension();
            $location = public_path("images\shoppingmalls\\" . $filename);
            Image::make($file)->resize(800, 400)->save($location);
            $oldimage = $editshoppingmall->image;
            $editshoppingmall->image = $filename;
        }

       $editshoppingmall->update();

        //shoppingmall display prices insertion

         if($request->has('price_drop_down_banners')){
            $this->updateShoppingmallPrice($ID, 'price_drop_down_banners', $request->input('price_drop_down_banners'));
        }
      
       if($request->has('number_drop_down_banners')){
            $this->updateShoppingmallPrice($ID, 'number_drop_down_banners', $request->input('number_drop_down_banners'));
        }

       if($request->has('duration_drop_down_banners')){
            $this->updateShoppingmallPrice($ID, 'duration_drop_down_banners', $request->input('duration_drop_down_banners'));
        }

        if($request->has('price_free_stand_display')){
            $this->updateShoppingmallPrice($ID, 'price_free_stand_display', $request->input('price_free_stand_display'));
        }
        if($request->has('number_free_stand_display')){
            $this->updateShoppingmallPrice($ID, 'number_free_stand_display', $request->input('number_free_stand_display'));
        }
        if($request->has('duration_free_stand_display')){
            $this->updateShoppingmallPrice($ID, 'duration_free_stand_display', $request->input('duration_free_stand_display'));
        }

          if($request->has('price_walls')){
            $this->updateShoppingmallPrice($ID, 'price_walls', $request->input('price_walls'));
        }
        if($request->has('number_walls')){
            $this->updateShoppingmallPrice($ID, 'number_walls', $request->input('number_walls'));
        }
        if($request->has('duration_walls')){
            $this->updateShoppingmallPrice($ID, 'duration_walls', $request->input('duration_walls'));
        }

          if($request->has('price_poles_or_pillar')){
            $this->updateShoppingmallPrice($ID, 'price_poles_or_pillar', $request->input('price_poles_or_pillar'));
        }
        if($request->has('number_poles_or_pillar')){
            $this->updateShoppingmallPrice($ID, 'number_poles_or_pillar', $request->input('number_poles_or_pillar'));
        }
        if($request->has('duration_poles_or_pillar')){
            $this->updateShoppingmallPrice($ID, 'duration_poles_or_pillar', $request->input('duration_poles_or_pillar'));
        }

          if($request->has('price_signage')){
            $this->updateShoppingmallPrice($ID, 'price_signage', $request->input('price_signage'));
        }
        if($request->has('number_signage')){
            $this->updateShoppingmallPrice($ID, 'number_signage', $request->input('number_signage'));
        }
        if($request->has('duration_signage')){
            $this->updateShoppingmallPrice($ID, 'duration_signage', $request->input('duration_signage'));
        }

        

        //return to shoppingmall product list
       return redirect()->route('dashboard.getShoppingmallList')->with('message', 'Successfully Edited!');
    }

    public function updateShoppingmallPrice( $id, $meta_key, $meta_value){
        $count = Shoppingmallsprice::where([
                                    ['shoppingmalls_id', '=', $id],
                                    ['price_key', '=', $meta_key],
                                ])->count();
        if($count < 1){
            $this->addShoppingmallPrice($id, $meta_key, $meta_value);
        }else{
            $update = Shoppingmallsprice::where([
                                    ['shoppingmalls_id', '=', $id],
                                    ['price_key', '=', $meta_key],
                                ])->update(['price_value' => $meta_value]);
        }
        
   }

    //cart functions
   // add or remove item to cart
   public function getAddToCart(Request $request, $id, $variation)
   {
        $shoppingmall_ad = Shoppingmalls::where('id', $id)->first()->toArray();
        
        $selectDisplayOpt = explode("+", $variation);
        $main_key = substr($selectDisplayOpt[1], 6);
        
        $number_key = "number_".$main_key;
        $duration_key = "duration_".$main_key;

        $shoppingmall_price = Shoppingmallsprice::where([
                                    ['shoppingmalls_id', '=', $id],
                                    ['price_key', '=', $selectDisplayOpt[1]],
                                ])->first()->toArray();

        $shoppingmall_number = Shoppingmallsprice::where([
                                    ['shoppingmalls_id', '=', $id],
                                    ['price_key', '=', $number_key],
                                ])->first()->toArray();
        $shoppingmall_duration = Shoppingmallsprice::where([
                                    ['shoppingmalls_id', '=', $id],
                                    ['price_key', '=', $duration_key],
                                ])->first()->toArray();
        $shoppingmall_change_price = array();
        foreach($shoppingmall_price as $key => $value){
            if($key == 'price_key'){
                $shoppingmall_change_price[$key] = $value;
            }
            if($key == 'price_value'){
               $shoppingmall_change_price[$key] = $value;
            }
        }
        $shoppingmall_change_num = array();
        foreach($shoppingmall_number as $key => $value){
            if($key == 'price_key'){
                $key = 'number_key';
                $shoppingmall_change_num[$key] = $value;
            }
            if($key == 'price_value'){
                $key = 'number_value';
                $shoppingmall_change_num[$key] = $value;
            }
        }
        $shoppingmall_change_duration = array();
        foreach($shoppingmall_duration as $key => $value){
            if($key == 'price_key'){
                $key = 'duration_key';
                $shoppingmall_change_duration[$key] = $value;
            }
            if($key == 'price_value'){
                $key = 'duration_value';
                $shoppingmall_change_duration[$key] = $value;
            }
        }
        $shoppingmall_merge = array_merge($shoppingmall_change_num, $shoppingmall_change_duration);
        
        $shoppingmall_price = array_merge($shoppingmall_change_price, $shoppingmall_merge);
        
        $shoppingmall_Ad = array_merge($shoppingmall_ad, $shoppingmall_price);
       
        $oldCart = Session::has('cart') ? Session::get('cart') : null;
                
        $cart = new Cart($oldCart);

        $cart->addorRemove($shoppingmall_Ad, $shoppingmall_ad['id'], 'shoppingmalls'); //pass full shoppingmall details, id and model name like "shoppingmalls"
        
        $request->session()->put('cart', $cart);
        //Session::forget('cart');

        return redirect()->back()->with(['status' => 'added']);
    }

 
}
