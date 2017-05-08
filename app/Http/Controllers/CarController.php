<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use Session;
use App\Cars;
use App\Mainaddtype;
use App\Carsprice;
use Image;
use App\Product;
use Illuminate\Support\Facades\File;
use App\Cart;
use App\Order;


class CarController extends Controller
{
    
    public function __construct()
    {
        $this->middleware('admin', ['only' => ['getDashboardCarList', 'getDashboardCarForm', 'postDashboardCarForm', 'addCarPrice', 'getDeleteCarad', 'getUpdateeCarad', 'getuncheckCaradOptions']]);
    }
    //frontend function starts
    
    public function getfrontendAllCarads()
    {
         $car_type = array(  'micro_and_mini' => 'Micro And Mini',
                        'sedan' => 'Sedan',
                        'suv' => 'Suv',
                        'large' => 'Large'
                        );

        $location = 'Delhi NCR';
        $ad_cats = Mainaddtype::orderBy('title')->get();


        return view('frontend-mediatype.cars.carads-list', ['car_type' => $car_type, 'location' => $location, 'mediacats' => $ad_cats]);
    }
    
    // get cars by category
    public function getfrontCaradByType($cartype)
    {
        
        $options = array(
                                'bumper' => 'Bumper',
                                'rear_window_decals' => 'Rear Window Decals',
                                'doors' => 'Doors'
                            );

        $location = 'Delhi NCR';    

        
        return view('frontend-mediatype.cars.carAdByType', [
                                                    'options' => $options,
                                                    'cartype' => $cartype,
                                                    'location' => $location
                                                    ]
                    );

    }

    public function getfrontCaradByOption($cartype, $carOption)
    {
         $cars = new Carsprice();

        $cars = $cars->getCarByFilter($cartype, $carOption);
        
        return view('frontend-mediatype.cars.car-single', ['cars' => $cars, 'cartype' => $cartype, 'carOption' => $carOption]);
    }

    public function getfrontCarad($id)
    {
        $carad = Cars::find($id);
        if($carad){
            if($carad->status === "3" || $carad->status === "2"){
                return redirect()->back();
            }else{
        $carprice = Carsprice::where('cars_id', $id)->get();
        return view('frontend-mediatype.cars.car-single', ['carad' => $carad, 'carprice' => $carprice]);
    }
    }else{
            return redirect()->back();
        }
        
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
           'status' => 'required',
           'cartype' => 'required'
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
                'cartype' => $request->input('cartype'),
                'display_options' => serialize($request->input('cardisplay')),
                // 'light_option' => $request->input('aplighting'),
                'discount' => $request->input('cardiscount'),
                'numberofcars' => $request->input('carnumber')
        ]);

        $car->save();

        $lastinsert_ID = $car->id;



        //car display prices insertion

   	    if($request->has('price_bumper')){
            $this->addCarPrice($lastinsert_ID, 'price_bumper', $request->input('price_bumper'),'number_bumper', $request->input('number_bumper'),'duration_bumper', $request->input('duration_bumper'), $request->input('cartype'));
        }
      
       

        if($request->has('price_rear_window_decals')){
            $this->addCarPrice($lastinsert_ID, 'price_rear_window_decals', $request->input('price_rear_window_decals'),'number_rear_window_decals', $request->input('number_rear_window_decals'),'duration_rear_window_decals', $request->input('duration_rear_window_decals'), $request->input('cartype'));
        }
       
      
        if($request->has('price_doors')){
            $this->addCarPrice($lastinsert_ID, 'price_doors', $request->input('price_doors'), 'number_doors', $request->input('number_doors'), 'duration_doors', $request->input('duration_doors'), $request->input('cartype'));
        }
       
      

       
        //return to car product list
       return redirect()->route('dashboard.getCarList')->with('message', 'Successfully Added!');
    }

    //insert price data to car price table
    public function addCarPrice($id, $pricekey, $pricevalue, $numkey, $numvalue, $durkey, $durvalue, $type)
    {
        $insert = new Carsprice();

        $insert->cars_id = $id;
        $insert->price_key = $pricekey;
        $insert->price_value = $pricevalue;
        $insert->number_key = $numkey;
        $insert->number_value = $numvalue;
        $insert->duration_key = $durkey;
        $insert->duration_value = $durvalue;
        $insert->option_type = $type;
        $insert->save();

    }

    // delete car product and price form db tables

    public function getDeleteCarad($caradID)
    {
        $delele_carad = Cars::where('id', $caradID)->first();
        $delele_carad->delete();
        $delete_caradprice = Carsprice::where('cars_id', $caradID);
        $delete_caradprice->delete();
       
        return redirect()->route('dashboard.getCarList')->with(['message' => "Successfully Deleted From the List!"]);
    }

    // update car product
    public function getUpdateeCarad($ID)
    {
        $carData = Cars::find($ID);
        $carpriceData = Carsprice::where('cars_id', $ID)->get();
        $fieldData = array();
        foreach($carpriceData as $pricecar){
           $fieldData[] = ucwords(str_replace('_', ' ', substr($pricecar->price_key, 6)));
        }

       $fieldDatas = serialize($fieldData);
        return view('backend.mediatypes.cars.car-editform', ['car' => $carData, 'carpricemeta' => $carpriceData, 'fieldData' => $fieldDatas]);
    }
    //check and uncheck options remove
    public function getuncheckCaradOptions(Request $request)
    {
        $displayoptions = json_decode($request['displayoptions']);
        $datta = array();
        foreach($displayoptions as $options){
            $datta[] = strtolower(str_replace(' ', '_', $options));
        
        }

        $count = Carsprice::where([
                                    ['cars_id', '=', $request['id']],
                                    ['price_key', '=', $request['price_key']],
                                ])->count();
        if($count > 0){
            Cars::where('id', $request['id'])->update([$request['option_type'] => serialize($datta)]);
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
         $editcar->cartype = $editcar->cartype;
         $editcar->display_options = serialize($request->input('cardisplay'));
         $editcar->numberofcars = $request->input('carnumber');
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

        if($request->has('price_bumper')){
            $this->updateCarPrice($ID, 'price_bumper', $request->input('price_bumper'),'number_bumper', $request->input('number_bumper'), 'duration_bumper', $request->input('duration_bumper'), $editcar->cartype);
        }
      
       

        if($request->has('price_rear_window_decals')){
            $this->updateCarPrice($ID, 'price_rear_window_decals', $request->input('price_rear_window_decals'),'number_rear_window_decals', $request->input('number_rear_window_decals'),'duration_rear_window_decals', $request->input('duration_rear_window_decals'), $editcar->cartype);
        }
       
      
        if($request->has('price_doors')){
            $this->updateCarPrice($ID, 'price_doors', $request->input('price_doors'), 'number_doors', $request->input('number_doors'),'duration_doors', $request->input('duration_doors'), $editcar->cartype);
        }
       

        //return to car product list
       return redirect()->route('dashboard.getCarList')->with('message', 'Successfully Edited!');
    }

    public function updateCarPrice( $id, $pricekey, $pricevalue, $numkey, $numvalue, $durkey, $durvalue, $type){
        $count = Carsprice::where([
                                    ['cars_id', '=', $id],
                                    ['price_key', '=', $pricekey],
                                ])->count();
        if($count < 1){
            $this->addCarPrice($id, $pricekey, $pricevalue, $numkey, $numvalue, $durkey, $durvalue, $type);
        }else{
            $update = Carsprice::where([
                                    ['cars_id', '=', $id],
                                    ['price_key', '=', $pricekey],
                                ])->update(['price_value' => $pricevalue, 'number_value' => $numvalue, 'duration_value' => $durvalue]);
        }
        
   }

 
 //Fliter Functions
   public function getFilterCarAds(Request $request)
   {
        
        $carPrice = new Carsprice();
        $filterResults = $carPrice->FilterCarsAds($request->all());

        if(count($filterResults)>0){
            foreach($filterResults as $searchCar){
                $this->car_ads($searchCar, $request->all());
            }

        }else{
            echo "<img src='../images/oops.jpg' class='img-responsive oops-img'>";
        }

        $content = ob_get_contents();
        ob_get_clean();
        return $content;
  
   }

   public function car_ads($searchCar, $fileroptions)
   { 
         ?>
       
       <div class="col-md-3 col-sm-3 "> 
        <div class="pro-item"> 
            <div class=" cat-opt-img "> <img src="<?= asset('images/cars/'.$searchCar->car->image) ?>"> </div>
            <p class="font-1"><?= $searchCar->car->title ?></p>
            <p class="font-2"><?= $searchCar->car->location ?>, <?= $searchCar->car->city ?>, <?= $searchCar->car->state ?></p>
            <div class="row">
                <div class="col-md-6">
                    <p class="font-3"><?= $searchCar->number_value ?> <?= ucwords(substr(str_replace('_', ' ', $searchCar->price_key), 6))?> <br>for <br> <?= $searchCar->duration_value?> months</p>
                    </div>
                <div class="col-md-6">
                        <p class="font-4"><del class="lighter">Rs <?= $searchCar->price_value?> </del><br>Rs <?= $searchCar->price_value?> </p>
                </div>
            
            </div>

            <?php
            $options = $searchCar->price_value.'+'.$searchCar->price_key;
            $session_key = 'cars'.'_'.$searchCar->price_key.'_'.$searchCar->car->id;
            $printsession = (array) Session::get('cart');
                            
           ?>
            <div class="clearfix"> 
                <button class="glass add-cartButton" data-href="<?= route('car.addtocartAfterSearch', ['id' => $searchCar->car->id, 'variation' => $options, 'fileroption' => http_build_query($fileroptions)]) ?>"><span class="fa fa-star"></span>
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
        $car_ad = Cars::where('id', $id)->first()->toArray();
        
        $selectDisplayOpt = explode("+", $variation);
        $main_key = substr($selectDisplayOpt[1], 6);
        
        $car_price = Carsprice::where([
                                    ['cars_id', '=', $id],
                                    ['price_key', '=', $selectDisplayOpt[1]],
                                ])->first()->toArray();

        
        $car_Ad = array_merge($car_ad, $car_price);
       
        $oldCart = Session::has('cart') ? Session::get('cart') : null;
                
        $cart = new Cart($oldCart);

        $cart->addorRemove($car_Ad, $car_ad['id'], 'cars', $flag=true); //pass full car details, id and model name like "cars"
        
        $request->session()->put('cart', $cart);
        //Session::forget('cart');

        return redirect()->back()->with(['status' => 'added']);
    }

 
}
