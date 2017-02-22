<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use Session;
use App\Busstops;
use App\Busstopsprice;
use Image;
use App\Product;
use Illuminate\Support\Facades\File;
use App\Cart;
use App\Order;


class BusstopController extends Controller
{
    
    //frontend function starts
    
    public function getfrontendAllBusstopads()
    {
       $busstop_ads = Busstops::all();
       return view('frontend-mediatype.busstopads-list', ['products' => $busstop_ads]);
    }
    
    public function getfrontBusstopad($id)
    {
        $busstopad = Busstops::find($id);
        $busstopprice = Busstopsprice::where('busstops_id', $id)->get();
        return view('frontend-mediatype.busstop-single', ['busstopad' => $busstopad, 'busstopprice' => $busstopprice]);
    }
    
    
    // frontend functions ends

    //Backend functions below


    // get list of all the products in busstop stop media type
    public function getDashboardBusstopList(){
        $busstop_ads = Busstops::all();
        return view('backend.mediatypes.busstops.busstop-list', ['busstop_ads' => $busstop_ads]);
    }
    
    // get form of busstop stop media type
     public function getDashboardBusstopForm()
    {
        return view('backend.mediatypes.busstops.busstop-addform');
    }

    // post list of all the products in busstop media type

    public function postDashboardBusstopForm(Request $request)
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
            $location = public_path("images\busstops\\" . $filename);
            Image::make($file)->resize(800, 400)->save($location);
        }

        $busstop = new Busstops([
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
                'display_options' => serialize($request->input('busstopdisplay')),
                'light_option' => $request->input('bslighting'),
                'discount' => $request->input('busstopdiscount'),
                'busstopnumber' => $request->input('busstopsnumber')
        ]);

        $busstop->save();

        $lastinsert_ID = $busstop->id;



        //busstop display prices insertion

   	   if($request->has('price_full')){
            $this->addBusstopPrice($lastinsert_ID, 'price_full', $request->input('price_full'));
        }
      
       if($request->has('number_full')){
            $this->addBusstopPrice($lastinsert_ID, 'number_full', $request->input('number_full'));
        }

       if($request->has('duration_full')){
            $this->addBusstopPrice($lastinsert_ID, 'duration_full', $request->input('duration_full'));
        }

        if($request->has('price_roof_front')){
            $this->addBusstopPrice($lastinsert_ID, 'price_roof_front', $request->input('price_roof_front'));
        }
        if($request->has('number_roof_front')){
            $this->addBusstopPrice($lastinsert_ID, 'number_roof_front', $request->input('number_roof_front'));
        }
        if($request->has('duration_roof_front')){
            $this->addBusstopPrice($lastinsert_ID, 'duration_roof_front', $request->input('duration_roof_front'));
        }
        if($request->has('price_seat_backs')){
            $this->addBusstopPrice($lastinsert_ID, 'price_seat_backs', $request->input('price_seat_backs'));
        }
         if($request->has('number_seat_backs')){
            $this->addBusstopPrice($lastinsert_ID, 'number_seat_backs', $request->input('number_seat_backs'));
        }
      
       if($request->has('duration_seat_backs')){
            $this->addBusstopPrice($lastinsert_ID, 'duration_seat_backs', $request->input('duration_seat_backs'));
        }
      
       if($request->has('price_side_boards')){
            $this->addBusstopPrice($lastinsert_ID, 'price_side_boards', $request->input('price_side_boards'));
        }
      
       if($request->has('number_side_boards')){
            $this->addBusstopPrice($lastinsert_ID, 'number_side_boards', $request->input('number_side_boards'));
        }

      if($request->has('duration_side_boards')){
            $this->addBusstopPrice($lastinsert_ID, 'duration_side_boards', $request->input('duration_side_boards'));
        }
    
      

       
        //return to busstop product list
       return redirect()->route('dashboard.getBusstopList')->with('message', 'Successfully Added!');
    }

    //insert price data to busstop price table
    public function addBusstopPrice($id, $key, $value)
    {
        $insert = new Busstopsprice();

        $insert->busstops_id = $id;
        $insert->price_key = $key;
        $insert->price_value = $value;
       
        $insert->save();

    }

    // delete busstop product and price form db tables

    public function getDeleteBusstopad($busstopadID)
    {
        $delele_busstopad = Busstops::where('id', $busstopadID)->first();
        $delele_busstopad->delete();
        $delete_busstopadprice = Busstopsprice::where('busstops_id', $busstopadID);
        $delete_busstopadprice->delete();
        // $delete_product = Product::where([
        //                             ['media_id', '=', $busstopadID],
        //                             ['media_type', '=', 'Busstops'],
        //                         ])->first();
        // $delete_product->delete();
        return redirect()->route('dashboard.getBusstopList')->with(['message' => "Successfully Deleted From the List!"]);
    }

    // update busstop product
    public function getUpdateeBusstopad($ID)
    {
        $busstopData = Busstops::find($ID);
        $busstoppriceData = Busstopsprice::where('busstops_id', $ID)->get();
        $fieldData = array();
        foreach($busstoppriceData as $pricebusstop){
           $fieldData[] = ucwords(substr(str_replace("_", " ", $pricebusstop->price_key), 6));
        }
       $fieldData = serialize($fieldData);
        return view('backend.mediatypes.busstops.busstop-editform', ['busstop' => $busstopData, 'busstoppricemeta' => $busstoppriceData, 'fieldData' => $fieldData]);
    }
    //check and uncheck options remove
    public function getuncheckBusstopadOptions(Request $request)
    {
        $count = Busstopsprice::where([
                                    ['busstops_id', '=', $request['id']],
                                    ['price_key', '=', $request['price_key']],
                                ])->count();
        if($count > 0){
            Busstops::where('id', $request['id'])->update(['display_options' => serialize($request['displayoptions'])]);
            $busstops = Busstopsprice::where([
                                    ['busstops_id', '=', $request['id']],
                                    ['price_key', '=', $request['price_key']],
                                ])->first();
            $busstops->delete();
            return response(['msg' => 'price deleted'], 200);
        }
              
            return response(['msg' => 'Value not present in db!'], 200);
        
    }

    public function postUpdateeBusstopad(Request $request, $ID)
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

        $editbusstop = Busstops::find($ID);

         $editbusstop->title = $request->input('title');
         $editbusstop->price = $request->input('price');
         $editbusstop->location = $request->input('location');
         $editbusstop->state = $request->input('state');
         $editbusstop->city = $request->input('city');
         $editbusstop->rank = $request->input('rank');
         $editbusstop->description = $request->input('description');
         $editbusstop->status = $request->input('status');
         $editbusstop->references = $request->input('reference');
         $editbusstop->display_options = serialize($request->input('busstopdisplay'));
          $editbusstop->busstopnumber = $request->input('busstopsnumber');
          $editbusstop->discount = $request->input('busstopdiscount');

        if($request->hasFile('image')){
            $file = $request->file('image');
            $filename = time() .'.'. $file->getClientOriginalExtension();
            $location = public_path("images\busstops\\" . $filename);
            Image::make($file)->resize(800, 400)->save($location);
            $oldimage = $editbusstop->image;
            $editbusstop->image = $filename;
        }

       $editbusstop->update();

        //busstop display prices insertion

        if($request->has('price_full')){
            $this->updateBusstopPrice($ID, 'price_full', $request->input('price_full'));
        }
      
       if($request->has('number_full')){
            $this->updateBusstopPrice($ID, 'number_full', $request->input('number_full'));
        }

       if($request->has('duration_full')){
            $this->updateBusstopPrice($ID, 'duration_full', $request->input('duration_full'));
        }

        if($request->has('price_roof_front')){
            $this->updateBusstopPrice($ID, 'price_roof_front', $request->input('price_roof_front'));
        }
        if($request->has('number_roof_front')){
            $this->updateBusstopPrice($ID, 'number_roof_front', $request->input('number_roof_front'));
        }
        if($request->has('duration_roof_front')){
            $this->updateBusstopPrice($ID, 'duration_roof_front', $request->input('duration_roof_front'));
        }
        if($request->has('price_seat_backs')){
            $this->updateBusstopPrice($ID, 'price_seat_backs', $request->input('price_seat_backs'));
        }
         if($request->has('number_seat_backs')){
            $this->updateBusstopPrice($ID, 'number_seat_backs', $request->input('number_seat_backs'));
        }
      
       if($request->has('duration_seat_backs')){
            $this->updateBusstopPrice($ID, 'duration_seat_backs', $request->input('duration_seat_backs'));
        }
      
       if($request->has('price_side_boards')){
            $this->updateBusstopPrice($ID, 'price_side_boards', $request->input('price_side_boards'));
        }
      
       if($request->has('number_side_boards')){
            $this->updateBusstopPrice($ID, 'number_side_boards', $request->input('number_side_boards'));
        }

      if($request->has('duration_side_boards')){
            $this->updateBusstopPrice($ID, 'duration_side_boards', $request->input('duration_side_boards'));
        }
        

        //return to busstop product list
       return redirect()->route('dashboard.getBusstopList')->with('message', 'Successfully Edited!');
    }

    public function updateBusstopPrice( $id, $meta_key, $meta_value){
        $count = Busstopsprice::where([
                                    ['busstops_id', '=', $id],
                                    ['price_key', '=', $meta_key],
                                ])->count();
        if($count < 1){
            $this->addBusstopPrice($id, $meta_key, $meta_value);
        }else{
            $update = Busstopsprice::where([
                                    ['busstops_id', '=', $id],
                                    ['price_key', '=', $meta_key],
                                ])->update(['price_value' => $meta_value]);
        }
        
   }

    //cart functions
   // add or remove item to cart
   public function getAddToCart(Request $request, $id, $variation)
   {
        $busstop_ad = Busstops::where('id', $id)->first()->toArray();
        
        $selectDisplayOpt = explode("+", $variation);
        $busstop_price = Busstopsprice::where([
                                    ['busstops_id', '=', $id],
                                    ['price_key', '=', $selectDisplayOpt[1]],
                                ])->first()->toArray();
        
        $busstop_Ad = array_merge($busstop_ad, $busstop_price);
       
        $oldCart = Session::has('cart') ? Session::get('cart') : null;
                
        $cart = new Cart($oldCart);

        $cart->addorRemove($busstop_Ad, $busstop_ad['id'], 'busstops'); //pass full busstop details, id and model name like "busstops"
        
        $request->session()->put('cart', $cart);
        //Session::forget('cart');

        return redirect()->back()->with(['status' => 'added']);
    }

 
}
