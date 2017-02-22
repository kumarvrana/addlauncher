<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use Session;
use App\Cars;
use App\Carsprice;
use Image;
use App\Product;
use Illuminate\Support\Facades\File;
use App\Cart;
use App\Order;


class CarController extends Controller
{
    
    //frontend function starts
    
    public function getfrontendAllCarads()
    {
       $car_ads = Cars::all();
       return view('frontend-mediatype.cars.carads-list', ['products' => $car_ads]);
    }
    
    public function getfrontCarad($id)
    {
        $carad = Cars::find($id);
        $carprice = Carsprice::where('cars_id', $id)->get();
        return view('frontend-mediatype.cars.car-single', ['carad' => $carad, 'carprice' => $carprice]);
    }
    
    
    // frontend functions ends

    //Backend functions below


    // get list of all the products in car stop media type
    public function getDashboardCarList(){
        $car_ads = Cars::all();
        return view('backend.mediatypes.cars.car-list', ['car_ads' => $car_ads]);
    }
    
    // get form of car stop media type
     public function getDashboardCarForm()
    {
        return view('backend.mediatypes.cars.car-addform');
    }

    // post list of all the products in car media type

    public function postDashboardCarForm(Request $request)
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
            $location = public_path("images\cars\\" . $filename);
            Image::make($file)->resize(800, 400)->save($location);
        }

        $car = new Cars([
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
                'display_options' => serialize($request->input('cardisplay')),
                'light_option' => $request->input('aplighting'),
                'discount' => $request->input('cardiscount'),
                'numberofcars' => $request->input('carsnumber')
        ]);

        $car->save();

        $lastinsert_ID = $car->id;



        //car display prices insertion

   	  if($request->has('price_full')){
            $this->addCarPrice($lastinsert_ID, 'price_full', $request->input('price_full'));
        }
      
       if($request->has('number_full')){
            $this->addCarPrice($lastinsert_ID, 'number_full', $request->input('number_full'));
        }

       if($request->has('duration_full')){
            $this->addCarPrice($lastinsert_ID, 'duration_full', $request->input('duration_full'));
        }

        if($request->has('price_full_outside_only')){
            $this->addCarPrice($lastinsert_ID, 'price_full_outside_only', $request->input('price_full_outside_only'));
        }
        if($request->has('number_full_outside_only')){
            $this->addCarPrice($lastinsert_ID, 'number_full_outside_only', $request->input('number_full_outside_only'));
        }
        if($request->has('duration_full_outside_only')){
            $this->addCarPrice($lastinsert_ID, 'duration_full_outside_only', $request->input('duration_full_outside_only'));
        }
      
    
      

       
        //return to car product list
       return redirect()->route('dashboard.getCarList')->with('message', 'Successfully Added!');
    }

    //insert price data to car price table
    public function addCarPrice($id, $key, $value)
    {
        $insert = new Carsprice();

        $insert->cars_id = $id;
        $insert->price_key = $key;
        $insert->price_value = $value;
       
        $insert->save();

    }

    // delete car product and price form db tables

    public function getDeleteCarad($caradID)
    {
        $delele_carad = Cars::where('id', $caradID)->first();
        $delele_carad->delete();
        $delete_caradprice = Carsprice::where('cars_id', $caradID);
        $delete_caradprice->delete();
        // $delete_product = Product::where([
        //                             ['media_id', '=', $caradID],
        //                             ['media_type', '=', 'Cars'],
        //                         ])->first();
        // $delete_product->delete();
        return redirect()->route('dashboard.getCarList')->with(['message' => "Successfully Deleted From the List!"]);
    }

    // update car product
    public function getUpdateeCarad($ID)
    {
        $carData = Cars::find($ID);
        $carpriceData = Carsprice::where('cars_id', $ID)->get();
        $fieldData = array();
        foreach($carpriceData as $pricecar){
           $fieldData[] = ucwords(substr(str_replace("_", " ", $pricecar->price_key), 6));
        }
       $fieldData = serialize($fieldData);
        return view('backend.mediatypes.cars.car-editform', ['car' => $carData, 'carpricemeta' => $carpriceData, 'fieldData' => $fieldData]);
    }
    //check and uncheck options remove
    public function getuncheckCaradOptions(Request $request)
    {
        $count = Carsprice::where([
                                    ['cars_id', '=', $request['id']],
                                    ['price_key', '=', $request['price_key']],
                                ])->count();
        if($count > 0){
            Cars::where('id', $request['id'])->update(['display_options' => serialize($request['displayoptions'])]);
            $cars = Carsprice::where([
                                    ['cars_id', '=', $request['id']],
                                    ['price_key', '=', $request['price_key']],
                                ])->first();
            $cars->delete();
            return response(['msg' => 'price deleted'], 200);
        }
              
            return response(['msg' => 'Value not present in db!'], 200);
        
    }

    public function postUpdateeCarad(Request $request, $ID)
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

        $editcar = Cars::find($ID);

         $editcar->title = $request->input('title');
         $editcar->price = $request->input('price');
         $editcar->location = $request->input('location');
         $editcar->state = $request->input('state');
         $editcar->city = $request->input('city');
         $editcar->rank = $request->input('rank');
         $editcar->description = $request->input('description');
         $editcar->status = $request->input('status');
         $editcar->references = $request->input('reference');
         $editcar->display_options = serialize($request->input('cardisplay'));
          $editcar->numberofcars = $request->input('carsnumber');
          $editcar->discount = $request->input('cardiscount');

        if($request->hasFile('image')){
            $file = $request->file('image');
            $filename = time() .'.'. $file->getClientOriginalExtension();
            $location = public_path("images\cars\\" . $filename);
            Image::make($file)->resize(800, 400)->save($location);
            $oldimage = $editcar->image;
            $editcar->image = $filename;
        }

       $editcar->update();

        //car display prices insertion

       if($request->has('price_full')){
            $this->updateCarPrice($ID, 'price_full', $request->input('price_full'));
        }
      
       if($request->has('number_full')){
            $this->updateCarPrice($ID, 'number_full', $request->input('number_full'));
        }

       if($request->has('duration_full')){
            $this->updateCarPrice($ID, 'duration_full', $request->input('duration_full'));
        }

        if($request->has('price_full_outside_only')){
            $this->updateCarPrice($ID, 'price_full_outside_only', $request->input('price_full_outside_only'));
        }
        if($request->has('number_full_outside_only')){
            $this->updateCarPrice($ID, 'number_full_outside_only', $request->input('number_full_outside_only'));
        }
        if($request->has('duration_full_outside_only')){
            $this->updateCarPrice($ID, 'duration_full_outside_only', $request->input('duration_full_outside_only'));
        }
      
        

        //return to car product list
       return redirect()->route('dashboard.getCarList')->with('message', 'Successfully Edited!');
    }

    public function updateCarPrice( $id, $meta_key, $meta_value){
        $count = Carsprice::where([
                                    ['cars_id', '=', $id],
                                    ['price_key', '=', $meta_key],
                                ])->count();
        if($count < 1){
            $this->addCarPrice($id, $meta_key, $meta_value);
        }else{
            $update = Carsprice::where([
                                    ['cars_id', '=', $id],
                                    ['price_key', '=', $meta_key],
                                ])->update(['price_value' => $meta_value]);
        }
        
   }

    //cart functions
   // add or remove item to cart
   public function getAddToCart(Request $request, $id, $variation)
   {
        $car_ad = Cars::where('id', $id)->first()->toArray();
        
        $selectDisplayOpt = explode("+", $variation);
        $car_price = Carsprice::where([
                                    ['cars_id', '=', $id],
                                    ['price_key', '=', $selectDisplayOpt[1]],
                                ])->first()->toArray();
        
        $car_Ad = array_merge($car_ad, $car_price);
       
        $oldCart = Session::has('cart') ? Session::get('cart') : null;
                
        $cart = new Cart($oldCart);

        $cart->addorRemove($car_Ad, $car_ad['id'], 'cars'); //pass full car details, id and model name like "cars"
        
        $request->session()->put('cart', $cart);
        //Session::forget('cart');

        return redirect()->back()->with(['status' => 'added']);
    }

 
}
