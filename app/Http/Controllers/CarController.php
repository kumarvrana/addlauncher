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
    
    // get cars by category
    public function getfrontCaradByType($cartype)
    {
        $car_ads = Cars::where('cartype', $cartype)->get();
        
        return view('frontend-mediatype.cars.carAdByType', ['cartype' => $cartype]);
    }
    public function getfrontCaradByOption($cartype, $carOption)
    {
        $car_ads = Cars::where('cartype', $cartype)->get()->toArray();
        $carOption1 = '%'.$carOption.'%';
        $cars = array();
        foreach($car_ads as $car){
            $count = Carsprice::where([
                                    ['cars_id', '=', $car['id']],
                                    ['price_key', 'LIKE', $carOption1],
                                    ['option_type', '=', $cartype],
                                ])->get()->count();
            if($count > 0){
                 $carpriceOptions = Carsprice::where([
                                    ['cars_id', '=', $car['id']],
                                    ['price_key', 'LIKE', $carOption1],
                                    ['option_type', '=', $cartype],
                                ])->get(array('price_key', 'price_value'))->toArray();
                array_push($car, $carpriceOptions);
                $cars[] = array_flatten($car);
            }
       }
       
        return view('frontend-mediatype.cars.car-single', ['products' => $cars, 'cartype' => $cartype, 'carOption' => $carOption]);
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
            Cars::where('id', $request['id'])->update(['option_type' => serialize($datta)]);
            $cars = Carsprice::where([
                                    ['cars_id', '=', $request['id']],
                                    ['price_key', '=', $request['price_key']],
                                ])->first();
            $cars->delete();

            return response(['msg' => 'price deleted'], 200);
        }else{
              
            return response(['msg' => 'Value not present in db!'], 200);
        }
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
            $this->updateCarPrice($ID, 'price_bumper', $request->input('price_bumper'),'number_bumper', $request->input('number_bumper'), 'duration_bumper', $request->input('duration_bumper'), $request->input('cartype'));
        }
      
       

        if($request->has('price_rear_window_decals')){
            $this->updateCarPrice($ID, 'price_rear_window_decals', $request->input('price_rear_window_decals'),'number_rear_window_decals', $request->input('number_rear_window_decals'),'duration_rear_window_decals', $request->input('duration_rear_window_decals'), $request->input('cartype'));
        }
       
      
        if($request->has('price_doors')){
            $this->updateCarPrice($ID, 'price_doors', $request->input('price_doors'), 'number_doors', $request->input('number_doors'),'duration_doors', $request->input('duration_doors'), $request->input('cartype'));
        }
       

        //return to car product list
       return redirect()->route('dashboard.getCarList')->with('message', 'Successfully Edited!');
    }

    public function updateCarPrice( $id, $pricekey, $pricevalue, $numkey, $numvalue, $durkey, $durvalue, $type){
        $count = Carsprice::where([
                                    ['cars_id', '=', $id],
                                    ['price_key', '=', $pricekey],
                                    ['option_type', '=', $type],
                                ])->count();
        if($count < 1){
            $this->addCarPrice($id, $pricekey, $pricevalue, $numkey, $numvalue, $durkey, $durvalue, $type);
        }else{
            $update = Carsprice::where([
                                    ['cars_id', '=', $id],
                                    ['price_key', '=', $pricekey],
                                    ['option_type', '=', $type],
                                ])->update(['price_value' => $pricevalue, 'number_value' => $numvalue, 'duration_value' => $durvalue]);
        }
        
   }

    //Fliter Functions
   public function getFilterCarAds(Request $request){
       $params = array_filter($request->all());
       foreach($params as $key=>$value){
            if($key == 'pricerange'){
                
                $filter_priceCamparsion = preg_replace('/[0-9]+/', '', $value); // comparion operator
                if($filter_priceCamparsion != '<>'){
                     $filter_price = preg_replace('/[^0-9]/', '', $value);
                     $carpriceOptions = Carsprice::where([
                                    ['price_key', 'LIKE', 'price_%'],                                    
                                    ['price_value', $filter_priceCamparsion, $filter_price],
                                    ])->get()->toArray();
                }else{
                     $filter_price = preg_replace('/[^0-9]/', '_', $value);
                     $filter_price = explode('_', $filter_price);
                    
                     $carpriceOptions = Carsprice::where([
                                    ['price_key', 'LIKE', 'price_%'],                                    
                                    ['price_value', '>=', $filter_price[0]],
                                    ['price_value', '<=', $filter_price[2]],
                                    ])->get()->toArray();   
                }
                if(count($carpriceOptions)>0){
                
                foreach($carpriceOptions as $key => $value){
                    $car_ads = Cars::find($value['cars_id'])->get()->toArray();
                    $filterLike = substr($value['price_key'], 6);
                    $carOption1 = '%'.$filterLike;
                    $cars = array();
                    
                    $carpriceOptions = Carsprice::where([
                                ['cars_id', '=', $value['cars_id']],
                                ['price_key', 'LIKE', $carOption1],
                                //['price_value', $filter_priceCamparsion, $filter_price],
                                ])->get(array('price_key', 'price_value', 'number_key', 'number_value', 'duration_key', 'duration_value'))->toArray();
                        
                    array_push($car_ads, $carpriceOptions);
                    $cars[] = array_flatten($car_ads);
                     
                   
               
                }
                if(count($cars)>0){
                    echo "<pre>";
                    print_r($cars);
                    echo "</pre>";
                    foreach($cars as $searchCar){
                       $this->car_ads($searchCar);
                    }
                
                    }else{
                        echo "<b>No results to display!</b>";
                }

            }else{
                echo "<b>No results to display!</b>";
            }
                
            
            }
            
           
            
            if($key == 'locationFilter'){
                
            }

            
       }
        $content = ob_get_contents();
        ob_get_clean();
        return $content;
       
       
   }
   public function car_ads($searchCar)
   {
       ?>
       <div class="col-md-3 col-sm-3 "> 
        <div class="pro-item"> 
            <div class=" cat-opt-img "> <img src="<?= asset('images/cars/'.$searchCar[11]) ?>"> </div>
            <p class="font-1"><?= $searchCar[3] ?></p>
            <p class="font-2"><?= $searchCar[5] ?> | <?= $searchCar[6] ?> | <?= $searchCar[7] ?></p>
            <p class="font-3"><?= $searchCar[21]?> <?= ucwords(substr(str_replace('_', ' ', $searchCar[18]), 6))?> for <?= $searchCar[23]?> months</p>
            <p class="font-2"><del class="lighter">Rs <?= $searchCar[19]?> </del>Rs <?= $searchCar[19]?> </p>
            <?php
            $options = $searchCar[19].'+'.$searchCar[18];
            $session_key = 'cars'.'_'.$searchCar[18].'_'.$searchCar[0];
            $printsession = (array) Session::get('cart');
                            
           ?>
            <div class="clearfix"> 
                <a class="glass" href="<?= route('car.addtocart', ['id' => $searchCar[0], 'variation' => $options]) ?>"><span class="fa fa-star"></span>
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
