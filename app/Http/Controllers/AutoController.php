<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Http\Requests;
use Session;
use App\Autos;
use App\Autosprice;
use Image;
use App\Product;
use Illuminate\Support\Facades\File;
use App\Cart;
use App\Order;




class AutoController extends Controller
{
     //frontend function starts
    
    public function getfrontendAllAutoads()
    {
       $auto_ads = Autos::all();
       return view('frontend-mediatype.autos.autoads-list', ['products' => $auto_ads]);
    }
    
    public function getfrontAutoad($id)
    {
        $autoad = Autos::find($id);
        $autoprice = Autosprice::where('autos_id', $id)->get();
        return view('frontend-mediatype.autos.auto-single', ['autoad' => $autoad, 'autoprice' => $autoprice]);
    }
    
    
    // frontend functions ends
  

    //Backend functions below


    // get list of all the products in auto stop media type
     public function getDashboardAutoList(){
        $auto_ads = Autos::all();
        return view('backend.mediatypes.autos.auto-list', ['auto_ads' => $auto_ads]);
    }
    
     // get form of Auto media type
    public function getDashboardAutoForm()
    {
        return view('backend.mediatypes.autos.auto-addform');
    }


    // post list of all the products in auto media type

    public function postDashboardAutoForm(Request $request)
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
            $location = public_path("images\autos\\" . $filename);
            Image::make($file)->resize(800, 400)->save($location);
        }

        $auto = new Autos([
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
                'display_options' => serialize($request->input('autodisplay')),
                'front_pamphlets_reactanguler_options' => serialize($request->input('autofrontprdisplay')),
                'front_stickers_options' => serialize($request->input('autostickerdisplay')),
                'hood_options' => serialize($request->input('autohooddisplay')),
                'interior_options' => serialize($request->input('autointeriordisplay')),
                'light_option' => $request->input('autolighting'),
                'discount' => $request->input('autodiscount'),
                'auto_number' => $request->input('autosnumber')
        ]);

        $auto->save();

        $lastinsert_ID = $auto->id;



        //auto display prices insertion

   	   if($request->has('price_front')){
            $this->addAutoPrice($lastinsert_ID, 'price_front', $request->input('price_front'));
        }
      
       if($request->has('number_front')){
            $this->addAutoPrice($lastinsert_ID, 'number_front', $request->input('number_front'));
        }

       if($request->has('duration_front')){
            $this->addAutoPrice($lastinsert_ID, 'duration_front', $request->input('duration_front'));
        }



        if($request->has('price_back')){
            $this->addAutoPrice($lastinsert_ID, 'price_back', $request->input('price_back'));
        }
        if($request->has('number_back')){
            $this->addAutoPrice($lastinsert_ID, 'number_back', $request->input('number_back'));
        }
        if($request->has('duration_back')){
            $this->addAutoPrice($lastinsert_ID, 'duration_back', $request->input('duration_back'));
        }




        if($request->has('price_hood')){
            $this->addAutoPrice($lastinsert_ID, 'price_hood', $request->input('price_hood'));
        }
         if($request->has('number_hood')){
            $this->addAutoPrice($lastinsert_ID, 'number_hood', $request->input('number_hood'));
        }
      
       if($request->has('duration_hood')){
            $this->addAutoPrice($lastinsert_ID, 'duration_hood', $request->input('duration_hood'));
        }



      
       if($request->has('price_interior')){
            $this->addAutoPrice($lastinsert_ID, 'price_interior', $request->input('price_interior'));
        }
      
       if($request->has('number_interior')){
            $this->addAutoPrice($lastinsert_ID, 'number_interior', $request->input('number_interior'));
        }

      if($request->has('duration_interior')){
            $this->addAutoPrice($lastinsert_ID, 'duration_interior', $request->input('duration_interior'));
        }


        
      
       if($request->has('price_large_pamphlets')){
            $this->addAutoPrice($lastinsert_ID, 'price_large_pamphlets', $request->input('price_large_pamphlets'));
        }
      
       if($request->has('number_large_pamphlets')){
            $this->addAutoPrice($lastinsert_ID, 'number_large_pamphlets', $request->input('number_large_pamphlets'));
        }

      if($request->has('duration_large_pamphlets')){
            $this->addAutoPrice($lastinsert_ID, 'duration_large_pamphlets', $request->input('duration_large_pamphlets'));
        }


        
      
       if($request->has('price_medium_pamphlets')){
            $this->addAutoPrice($lastinsert_ID, 'price_medium_pamphlets', $request->input('price_medium_pamphlets'));
        }
      
       if($request->has('number_medium_pamphlets')){
            $this->addAutoPrice($lastinsert_ID, 'number_medium_pamphlets', $request->input('number_medium_pamphlets'));
        }

      if($request->has('duration_medium_pamphlets')){
            $this->addAutoPrice($lastinsert_ID, 'duration_medium_pamphlets', $request->input('duration_medium_pamphlets'));
        }


        
      
       if($request->has('price_small_pamphlets')){
            $this->addAutoPrice($lastinsert_ID, 'price_small_pamphlets', $request->input('price_small_pamphlets'));
        }
      
       if($request->has('number_small_pamphlets')){
            $this->addAutoPrice($lastinsert_ID, 'number_small_pamphlets', $request->input('number_small_pamphlets'));
        }

      if($request->has('duration_small_pamphlets')){
            $this->addAutoPrice($lastinsert_ID, 'duration_small_pamphlets', $request->input('duration_small_pamphlets'));
        }



        
      
       if($request->has('price_medium_front_sticker')){
            $this->addAutoPrice($lastinsert_ID, 'price_medium_front_sticker', $request->input('price_medium_front_sticker'));
        }
      
       if($request->has('number_medium_front_sticker')){
            $this->addAutoPrice($lastinsert_ID, 'number_medium_front_sticker', $request->input('number_medium_front_sticker'));
        }

      if($request->has('duration_medium_front_sticker')){
            $this->addAutoPrice($lastinsert_ID, 'duration_medium_front_sticker', $request->input('duration_medium_front_sticker'));
        }


        
      
       if($request->has('price_small_front_sticker')){
            $this->addAutoPrice($lastinsert_ID, 'price_small_front_sticker', $request->input('price_small_front_sticker'));
        }
      
       if($request->has('number_small_front_sticker')){
            $this->addAutoPrice($lastinsert_ID, 'number_small_front_sticker', $request->input('number_small_front_sticker'));
        }

      if($request->has('duration_small_front_sticker')){
            $this->addAutoPrice($lastinsert_ID, 'duration_small_front_sticker', $request->input('duration_small_front_sticker'));
        }


        
      
       if($request->has('price_large_front_sticker')){
            $this->addAutoPrice($lastinsert_ID, 'price_large_front_sticker', $request->input('price_large_front_sticker'));
        }
      
       if($request->has('number_large_front_sticker')){
            $this->addAutoPrice($lastinsert_ID, 'number_large_front_sticker', $request->input('number_large_front_sticker'));
        }

      if($request->has('duration_large_front_sticker')){
            $this->addAutoPrice($lastinsert_ID, 'duration_large_front_sticker', $request->input('duration_large_front_sticker'));
        }


        
      
       if($request->has('price_full_auto_hood')){
            $this->addAutoPrice($lastinsert_ID, 'price_full_auto_hood', $request->input('price_full_auto_hood'));
        }
      
       if($request->has('number_full_auto_hood')){
            $this->addAutoPrice($lastinsert_ID, 'number_full_auto_hood', $request->input('number_full_auto_hood'));
        }

      if($request->has('duration_full_auto_hood')){
            $this->addAutoPrice($lastinsert_ID, 'duration_full_auto_hood', $request->input('duration_full_auto_hood'));
        }


        
      
       if($request->has('price_driver_seat_interior')){
            $this->addAutoPrice($lastinsert_ID, 'price_driver_seat_interior', $request->input('price_driver_seat_interior'));
        }
      
       if($request->has('number_driver_seat_interior')){
            $this->addAutoPrice($lastinsert_ID, 'number_driver_seat_interior', $request->input('number_driver_seat_interior'));
        }

      if($request->has('duration_driver_seat_interior')){
            $this->addAutoPrice($lastinsert_ID, 'duration_driver_seat_interior', $request->input('duration_driver_seat_interior'));
        }


        
      
       if($request->has('price_left_auto_hood')){
            $this->addAutoPrice($lastinsert_ID, 'price_left_auto_hood', $request->input('price_left_auto_hood'));
        }
      
       if($request->has('number_left_auto_hood')){
            $this->addAutoPrice($lastinsert_ID, 'number_left_auto_hood', $request->input('number_left_auto_hood'));
        }

      if($request->has('duration_left_auto_hood')){
            $this->addAutoPrice($lastinsert_ID, 'duration_left_auto_hood', $request->input('duration_left_auto_hood'));
        }


        
      
       if($request->has('price_right_auto_hood')){
            $this->addAutoPrice($lastinsert_ID, 'price_right_auto_hood', $request->input('price_right_auto_hood'));
        }
      
       if($request->has('number_right_auto_hood')){
            $this->addAutoPrice($lastinsert_ID, 'number_right_auto_hood', $request->input('number_right_auto_hood'));
        }

      if($request->has('duration_right_auto_hood')){
            $this->addAutoPrice($lastinsert_ID, 'duration_right_auto_hood', $request->input('duration_right_auto_hood'));
        }


        
      
       if($request->has('price_roof_interior')){
            $this->addAutoPrice($lastinsert_ID, 'price_roof_interior', $request->input('price_roof_interior'));
        }
      
       if($request->has('number_roof_interior')){
            $this->addAutoPrice($lastinsert_ID, 'number_roof_interior', $request->input('number_roof_interior'));
        }

      if($request->has('duration_roof_interior')){
            $this->addAutoPrice($lastinsert_ID, 'duration_roof_interior', $request->input('duration_roof_interior'));
        }
      
      

       
        //return to auto product list
       return redirect()->route('dashboard.getAutoList')->with('message', 'Successfully Added!');
    }

    //insert price data to auto price table
    public function addAutoPrice($id, $key, $value)
    {
        $insert = new Autosprice();

        $insert->autos_id = $id;
        $insert->price_key = $key;
        $insert->price_value = $value;
       
        $insert->save();

    }

    // delete auto product and price form db tables

    public function getDeleteAutoad($autoadID)
    {
        $delele_autoad = Autos::where('id', $autoadID)->first();
        $delele_autoad->delete();
        $delete_autoadprice = Autosprice::where('autos_id', $autoadID);
        $delete_autoadprice->delete();
        // $delete_product = Product::where([
        //                             ['media_id', '=', $autoadID],
        //                             ['media_type', '=', 'Autos'],
        //                         ])->first();
        // $delete_product->delete();
        return redirect()->route('dashboard.getAutoList')->with(['message' => "Successfully Deleted From the List!"]);
    }

    // update auto product
    public function getUpdateeAutoad($ID)
    {
        $autoData = Autos::find($ID);
        $autopriceData = Autosprice::where('autos_id', $ID)->get();
        $fieldData = array();
        foreach($autopriceData as $priceauto){
           $fieldData[] = ucwords(substr(str_replace("_", " ", $priceauto->price_key), 6));
        }
       $fieldData = serialize($fieldData);
        return view('backend.mediatypes.autos.auto-editform', ['auto' => $autoData, 'autopricemeta' => $autopriceData, 'fieldData' => $fieldData]);
    }
    //check and uncheck options remove
    public function getuncheckAutoadOptions(Request $request)
    {
        $count = Autosprice::where([
                                    ['autos_id', '=', $request['id']],
                                    ['price_key', '=', $request['price_key']],
                                ])->count();
        if($count > 0){
            Autos::where('id', $request['id'])->update(['display_options' => serialize($request['displayoptions'])]);
            $autos = Autosprice::where([
                                    ['autos_id', '=', $request['id']],
                                    ['price_key', '=', $request['price_key']],
                                ])->first();
            $autos->delete();
            return response(['msg' => 'price deleted'], 200);
        }
              
            return response(['msg' => 'Value not present in db!'], 200);
        
    }

    public function postUpdateeAutoad(Request $request, $ID)
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

        $editauto = Autos::find($ID);

         $editauto->title = $request->input('title');
         $editauto->price = $request->input('price');
         $editauto->location = $request->input('location');
         $editauto->state = $request->input('state');
         $editauto->city = $request->input('city');
         $editauto->rank = $request->input('rank');
         $editauto->description = $request->input('description');
         $editauto->status = $request->input('status');
         $editauto->references = $request->input('reference');
         $editauto->display_options = serialize($request->input('autodisplay'));
         $editauto->front_pamphlets_reactanguler_options = serialize($request->input('autofrontprdisplay'));
         $editauto->front_stickers_options = serialize($request->input('autostickerdisplay'));
         $editauto->hood_options = serialize($request->input('autohooddisplay'));
         $editauto->interior_options = serialize($request->input('autointeriordisplay'));
         $editauto->auto_number = $request->input('autosnumber');

        if($request->hasFile('image')){
            $file = $request->file('image');
            $filename = time() .'.'. $file->getClientOriginalExtension();
            $location = public_path("images\buses\\" . $filename);
            Image::make($file)->resize(800, 400)->save($location);
            $oldimage = $editauto->image;
            $editauto->image = $filename;
        }

       $editauto->update();

        //auto display prices insertion

       if($request->has('price_front')){
            $this->updateAutoPrice($ID, 'price_front', $request->input('price_front'));
        }
      
       if($request->has('number_front')){
            $this->updateAutoPrice($ID, 'number_front', $request->input('number_front'));
        }

       if($request->has('duration_front')){
            $this->updateAutoPrice($ID, 'duration_front', $request->input('duration_front'));
        }



        if($request->has('price_back')){
            $this->updateAutoPrice($ID, 'price_back', $request->input('price_back'));
        }
        if($request->has('number_back')){
            $this->updateAutoPrice($ID, 'number_back', $request->input('number_back'));
        }
        if($request->has('duration_back')){
            $this->updateAutoPrice($ID, 'duration_back', $request->input('duration_back'));
        }




        if($request->has('price_hood')){
            $this->updateAutoPrice($ID, 'price_hood', $request->input('price_hood'));
        }
         if($request->has('number_hood')){
            $this->updateAutoPrice($ID, 'number_hood', $request->input('number_hood'));
        }
      
       if($request->has('duration_hood')){
            $this->updateAutoPrice($ID, 'duration_hood', $request->input('duration_hood'));
        }



      
       if($request->has('price_interior')){
            $this->updateAutoPrice($ID, 'price_interior', $request->input('price_interior'));
        }
      
       if($request->has('number_interior')){
            $this->updateAutoPrice($ID, 'number_interior', $request->input('number_interior'));
        }

      if($request->has('duration_interior')){
            $this->updateAutoPrice($ID, 'duration_interior', $request->input('duration_interior'));
        }


        
      
       if($request->has('price_large_pamphlets')){
            $this->updateAutoPrice($ID, 'price_large_pamphlets', $request->input('price_large_pamphlets'));
        }
      
       if($request->has('number_large_pamphlets')){
            $this->updateAutoPrice($ID, 'number_large_pamphlets', $request->input('number_large_pamphlets'));
        }

      if($request->has('duration_large_pamphlets')){
            $this->updateAutoPrice($ID, 'duration_large_pamphlets', $request->input('duration_large_pamphlets'));
        }


        
      
       if($request->has('price_medium_pamphlets')){
            $this->updateAutoPrice($ID, 'price_medium_pamphlets', $request->input('price_medium_pamphlets'));
        }
      
       if($request->has('number_medium_pamphlets')){
            $this->updateAutoPrice($ID, 'number_medium_pamphlets', $request->input('number_medium_pamphlets'));
        }

      if($request->has('duration_medium_pamphlets')){
            $this->updateAutoPrice($ID, 'duration_medium_pamphlets', $request->input('duration_medium_pamphlets'));
        }


        
      
       if($request->has('price_small_pamphlets')){
            $this->updateAutoPrice($ID, 'price_small_pamphlets', $request->input('price_small_pamphlets'));
        }
      
       if($request->has('number_small_pamphlets')){
            $this->updateAutoPrice($ID, 'number_small_pamphlets', $request->input('number_small_pamphlets'));
        }

      if($request->has('duration_small_pamphlets')){
            $this->updateAutoPrice($ID, 'duration_small_pamphlets', $request->input('duration_small_pamphlets'));
        }



        
      
       if($request->has('price_medium_front_sticker')){
            $this->updateAutoPrice($ID, 'price_medium_front_sticker', $request->input('price_medium_front_sticker'));
        }
      
       if($request->has('number_medium_front_sticker')){
            $this->updateAutoPrice($ID, 'number_medium_front_sticker', $request->input('number_medium_front_sticker'));
        }

      if($request->has('duration_medium_front_sticker')){
            $this->updateAutoPrice($ID, 'duration_medium_front_sticker', $request->input('duration_medium_front_sticker'));
        }


        
      
       if($request->has('price_small_front_sticker')){
            $this->updateAutoPrice($ID, 'price_small_front_sticker', $request->input('price_small_front_sticker'));
        }
      
       if($request->has('number_small_front_sticker')){
            $this->updateAutoPrice($ID, 'number_small_front_sticker', $request->input('number_small_front_sticker'));
        }

      if($request->has('duration_small_front_sticker')){
            $this->updateAutoPrice($ID, 'duration_small_front_sticker', $request->input('duration_small_front_sticker'));
        }


        
      
       if($request->has('price_large_front_sticker')){
            $this->updateAutoPrice($ID, 'price_large_front_sticker', $request->input('price_large_front_sticker'));
        }
      
       if($request->has('number_large_front_sticker')){
            $this->updateAutoPrice($ID, 'number_large_front_sticker', $request->input('number_large_front_sticker'));
        }

      if($request->has('duration_large_front_sticker')){
            $this->updateAutoPrice($ID, 'duration_large_front_sticker', $request->input('duration_large_front_sticker'));
        }


        
      
       if($request->has('price_full_auto_hood')){
            $this->updateAutoPrice($ID, 'price_full_auto_hood', $request->input('price_full_auto_hood'));
        }
      
       if($request->has('number_full_auto_hood')){
            $this->updateAutoPrice($ID, 'number_full_auto_hood', $request->input('number_full_auto_hood'));
        }

      if($request->has('duration_full_auto_hood')){
            $this->updateAutoPrice($ID, 'duration_full_auto_hood', $request->input('duration_full_auto_hood'));
        }


        
      
       if($request->has('price_driver_seat_interior')){
            $this->updateAutoPrice($ID, 'price_driver_seat_interior', $request->input('price_driver_seat_interior'));
        }
      
       if($request->has('number_driver_seat_interior')){
            $this->updateAutoPrice($ID, 'number_driver_seat_interior', $request->input('number_driver_seat_interior'));
        }

      if($request->has('duration_driver_seat_interior')){
            $this->updateAutoPrice($ID, 'duration_driver_seat_interior', $request->input('duration_driver_seat_interior'));
        }


        
      
       if($request->has('price_left_auto_hood')){
            $this->updateAutoPrice($ID, 'price_left_auto_hood', $request->input('price_left_auto_hood'));
        }
      
       if($request->has('number_left_auto_hood')){
            $this->updateAutoPrice($ID, 'number_left_auto_hood', $request->input('number_left_auto_hood'));
        }

      if($request->has('duration_left_auto_hood')){
            $this->updateAutoPrice($ID, 'duration_left_auto_hood', $request->input('duration_left_auto_hood'));
        }


        
      
       if($request->has('price_right_auto_hood')){
            $this->updateAutoPrice($ID, 'price_right_auto_hood', $request->input('price_right_auto_hood'));
        }
      
       if($request->has('number_right_auto_hood')){
            $this->updateAutoPrice($ID, 'number_right_auto_hood', $request->input('number_right_auto_hood'));
        }

      if($request->has('duration_right_auto_hood')){
            $this->updateAutoPrice($ID, 'duration_right_auto_hood', $request->input('duration_right_auto_hood'));
        }


        
      
       if($request->has('price_roof_interior')){
            $this->updateAutoPrice($ID, 'price_roof_interior', $request->input('price_roof_interior'));
        }
      
       if($request->has('number_roof_interior')){
            $this->updateAutoPrice($ID, 'number_roof_interior', $request->input('number_roof_interior'));
        }

      if($request->has('duration_roof_interior')){
            $this->updateAutoPrice($ID, 'duration_roof_interior', $request->input('duration_roof_interior'));
        }

        

        //return to auto product list
       return redirect()->route('dashboard.getAutoList')->with('message', 'Successfully Edited!');
    }

    public function updateAutoPrice( $id, $meta_key, $meta_value){
        $count = Autosprice::where([
                                    ['autos_id', '=', $id],
                                    ['price_key', '=', $meta_key],
                                ])->count();
        if($count < 1){
            $this->addAutoPrice($id, $meta_key, $meta_value);
        }else{
            $update = Autosprice::where([
                                    ['autos_id', '=', $id],
                                    ['price_key', '=', $meta_key],
                                ])->update(['price_value' => $meta_value]);
        }
        
   }

    //cart functions
   // add or remove item to cart
   public function getAddToCart(Request $request, $id, $variation)
   {
        $auto_ad = Autos::where('id', $id)->first()->toArray();
        
        $selectDisplayOpt = explode("+", $variation);
        $auto_price = Autosprice::where([
                                    ['autos_id', '=', $id],
                                    ['price_key', '=', $selectDisplayOpt[1]],
                                ])->first()->toArray();
        
        $auto_Ad = array_merge($auto_ad, $auto_price);
       
        $oldCart = Session::has('cart') ? Session::get('cart') : null;
                
        $cart = new Cart($oldCart);

        $cart->addorRemove($auto_Ad, $auto_ad['id'], 'autos'); //pass full auto details, id and model name like "autos"
        
        $request->session()->put('cart', $cart);
        //Session::forget('cart');

        return redirect()->back()->with(['status' => 'added']);
    }

 
}

