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
                'cinemanumber' => $request->input('cinemasnumber')
        ]);

        $cinema->save();

        $lastinsert_ID = $cinema->id;



        //cinema display prices insertion

   	  
   	   if($request->has('price_ten_sec_mute_slide')){
            $this->addCinemaPrice($lastinsert_ID, 'price_ten_sec_mute_slide', $request->input('price_ten_sec_mute_slide'));
        }
      
       if($request->has('number_ten_sec_mute_slide')){
            $this->addCinemaPrice($lastinsert_ID, 'number_ten_sec_mute_slide', $request->input('number_ten_sec_mute_slide'));
        }

       if($request->has('duration_ten_sec_mute_slide')){
            $this->addCinemaPrice($lastinsert_ID, 'duration_ten_sec_mute_slide', $request->input('duration_ten_sec_mute_slide'));
        } //can be used as no of seats or no of screens

        if($request->has('price_ten_sec_audio_slide')){
            $this->addCinemaPrice($lastinsert_ID, 'price_ten_sec_audio_slide', $request->input('price_ten_sec_audio_slide'));
        }
        if($request->has('number_ten_sec_audio_slide')){
            $this->addCinemaPrice($lastinsert_ID, 'number_ten_sec_audio_slide', $request->input('number_ten_sec_audio_slide'));
        }
        if($request->has('duration_ten_sec_audio_slide')){
            $this->addCinemaPrice($lastinsert_ID, 'duration_ten_sec_audio_slide', $request->input('duration_ten_sec_audio_slide'));
        }

           if($request->has('price_thirty_sec_video')){
            $this->addCinemaPrice($lastinsert_ID, 'price_thirty_sec_video', $request->input('price_thirty_sec_video'));
        }
        if($request->has('number_thirty_sec_video')){
            $this->addCinemaPrice($lastinsert_ID, 'number_thirty_sec_video', $request->input('number_thirty_sec_video'));
        }
        if($request->has('duration_thirty_sec_video')){
            $this->addCinemaPrice($lastinsert_ID, 'duration_thirty_sec_video', $request->input('duration_thirty_sec_video'));
        }

         if($request->has('price_sixty_sec_video')){
            $this->addCinemaPrice($lastinsert_ID, 'price_sixty_sec_video', $request->input('price_sixty_sec_video'));
        }
        if($request->has('number_sixty_sec_video')){
            $this->addCinemaPrice($lastinsert_ID, 'number_sixty_sec_video', $request->input('number_sixty_sec_video'));
        }
        if($request->has('duration_sixty_sec_video')){
            $this->addCinemaPrice($lastinsert_ID, 'duration_sixty_sec_video', $request->input('duration_sixty_sec_video'));
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
        // $delete_product = Product::where([
        //                             ['media_id', '=', $cinemaadID],
        //                             ['media_type', '=', 'Cinemas'],
        //                         ])->first();
        // $delete_product->delete();
        return redirect()->route('dashboard.getCinemaList')->with(['message' => "Successfully Deleted From the List!"]);
    }

    // update cinema product
    public function getUpdateeCinemaad($ID)
    {
        $cinemaData = Cinemas::find($ID);
        $cinemapriceData = Cinemasprice::where('cinemas_id', $ID)->get();
        $fieldData = array();
        foreach($cinemapriceData as $pricecinema){
           $fieldData[] = ucwords(substr(str_replace("_", " ", $pricecinema->price_key), 6));
        }
       $fieldData = serialize($fieldData);
        return view('backend.mediatypes.cinemas.cinema-editform', ['cinema' => $cinemaData, 'cinemapricemeta' => $cinemapriceData, 'fieldData' => $fieldData]);
    }
    //check and uncheck options remove
    public function getuncheckCinemaadOptions(Request $request)
    {
        $count = Cinemasprice::where([
                                    ['cinemas_id', '=', $request['id']],
                                    ['price_key', '=', $request['price_key']],
                                ])->count();
        if($count > 0){
            Cinemas::where('id', $request['id'])->update(['display_options' => serialize($request['displayoptions'])]);
            $cinemas = Cinemasprice::where([
                                    ['cinemas_id', '=', $request['id']],
                                    ['price_key', '=', $request['price_key']],
                                ])->first();
            $cinemas->delete();
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
           'status' => 'required'
        ]);

        $editcinema = Cinemas::find($ID);

         $editcinema->title = $request->input('title');
         $editcinema->price = $request->input('price');
         $editcinema->location = $request->input('location');
         $editcinema->state = $request->input('state');
         $editcinema->city = $request->input('city');
         $editcinema->rank = $request->input('rank');
         $editcinema->description = $request->input('description');
         $editcinema->status = $request->input('status');
         $editcinema->references = $request->input('reference');
         $editcinema->display_options = serialize($request->input('cinemadisplay'));
          $editcinema->cinemanumber = $request->input('cinemasnumber');
          $editcinema->discount = $request->input('cinemadiscount');

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

   	   if($request->has('price_ten_sec_mute_slide')){
            $this->updateCinemaPrice($ID, 'price_ten_sec_mute_slide', $request->input('price_ten_sec_mute_slide'));
        }
      
       if($request->has('number_ten_sec_mute_slide')){
            $this->updateCinemaPrice($ID, 'number_ten_sec_mute_slide', $request->input('number_ten_sec_mute_slide'));
        }

       if($request->has('duration_ten_sec_mute_slide')){
            $this->updateCinemaPrice($ID, 'duration_ten_sec_mute_slide', $request->input('duration_ten_sec_mute_slide'));
        } //can be used as no of seats or no of screens

        if($request->has('price_ten_sec_audio_slide')){
            $this->updateCinemaPrice($ID, 'price_ten_sec_audio_slide', $request->input('price_ten_sec_audio_slide'));
        }
        if($request->has('number_ten_sec_audio_slide')){
            $this->updateCinemaPrice($ID, 'number_ten_sec_audio_slide', $request->input('number_ten_sec_audio_slide'));
        }
        if($request->has('duration_ten_sec_audio_slide')){
            $this->updateCinemaPrice($ID, 'duration_ten_sec_audio_slide', $request->input('duration_ten_sec_audio_slide'));
        }

           if($request->has('price_thirty_sec_video')){
            $this->updateCinemaPrice($ID, 'price_thirty_sec_video', $request->input('price_thirty_sec_video'));
        }
        if($request->has('number_thirty_sec_video')){
            $this->updateCinemaPrice($ID, 'number_thirty_sec_video', $request->input('number_thirty_sec_video'));
        }
        if($request->has('duration_thirty_sec_video')){
            $this->updateCinemaPrice($ID, 'duration_thirty_sec_video', $request->input('duration_thirty_sec_video'));
        }

         if($request->has('price_sixty_sec_video')){
            $this->updateCinemaPrice($ID, 'price_sixty_sec_video', $request->input('price_sixty_sec_video'));
        }
        if($request->has('number_sixty_sec_video')){
            $this->updateCinemaPrice($ID, 'number_sixty_sec_video', $request->input('number_sixty_sec_video'));
        }
        if($request->has('duration_sixty_sec_video')){
            $this->updateCinemaPrice($ID, 'duration_sixty_sec_video', $request->input('duration_sixty_sec_video'));
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
        $cinema_price = Cinemasprice::where([
                                    ['cinemas_id', '=', $id],
                                    ['price_key', '=', $selectDisplayOpt[1]],
                                ])->first()->toArray();
        
        $cinema_Ad = array_merge($cinema_ad, $cinema_price);
       
        $oldCart = Session::has('cart') ? Session::get('cart') : null;
                
        $cart = new Cart($oldCart);

        $cart->addorRemove($cinema_Ad, $cinema_ad['id'], 'cinemas'); //pass full cinema details, id and model name like "cinemas"
        
        $request->session()->put('cart', $cart);
        //Session::forget('cart');

        return redirect()->back()->with(['status' => 'added']);
    }

 
}
