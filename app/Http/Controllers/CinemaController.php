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

    public function getfrontCinemaadByOption($cinemaOption)
    {
       
        $cinema_ads = Cinemas::all()->toArray();
       
        $cinemaOption1 = '%'.$cinemaOption.'%';
        $cinemas = array();
        foreach($cinema_ads as $cinema){
            $count = Cinemasprice::where([
                                    ['cinemas_id', '=', $cinema['id']],
                                    ['price_key', 'LIKE', $cinemaOption1],
                                   ])->get()->count();
            if($count > 0){
                 $cinemapriceOptions = Cinemasprice::where([
                                    ['cinemas_id', '=', $cinema['id']],
                                    ['price_key', 'LIKE', $cinemaOption1],
                                   ])->get(array('price_key', 'price_value', 'number_key', 'number_value', 'duration_key', 'duration_value'))->toArray();
                array_push($cinema, $cinemapriceOptions);
                $cinemas[] = array_flatten($cinema);
            }
       }
       
        return view('frontend-mediatype.cinemas.cinema-single', ['products' => $cinemas, 'cinemaOption' => $cinemaOption]);
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
           'audiseats' => 'numeric',
           'audinumber' => 'numeric',
           'cinemanumber' => 'numeric',
           'cinemadiscount' => 'numeric'
           
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
                'cinemanumber' => $request->input('cinemasnumber'),
                'audiseats' => $request->input('audiseats'),
                'audinumber' => $request->input('audinumber'),
                'cinemacategory' => $request->input('cinemacategory')
        ]);

        $cinema->save();

        $lastinsert_ID = $cinema->id;


        //cinema display prices insertion

      
       if($request->has('price_rate_per_week')){
            $this->addCinemaPrice($lastinsert_ID, 'price_rate_per_week', $request->input('price_rate_per_week'), 'duration_rate_per_week', $request->input('duration_rate_per_week'));
        }
      

       if($request->has('price_trailor_per_week')){
            $this->addCinemaPrice($lastinsert_ID, 'price_trailor_per_week', $request->input('price_trailor_per_week'), 'duration_trailor_per_week', $request->input('duration_trailor_per_week'));
        } //can be used as no of seats or no of screens

       
        if($request->has('price_mute_slide_per_week')){
            $this->addCinemaPrice($lastinsert_ID, 'price_mute_slide_per_week', $request->input('price_mute_slide_per_week'), 'duration_mute_slide_per_week', $request->input('duration_mute_slide_per_week'));
        }
       

       
        //return to cinema product list
       return redirect()->route('dashboard.getCinemaList')->with('message', 'Successfully Added!');
    }

    //insert price data to cinema price table
    public function addCinemaPrice($id, $pricekey, $pricevalue, $durkey, $durvalue)
    {
        $insert = new Cinemasprice();

       $insert->cinemas_id = $id;
        $insert->price_key = $pricekey;
        $insert->price_value = $pricevalue;
        $insert->duration_key = $durkey;
        $insert->duration_value = $durvalue;
       
        $insert->save();

    }

    // delete cinema product and price form db tables

    public function getDeleteCinemaad($cinemaadID)
    {
        $delele_cinemaad = Cinemas::where('id', $cinemaadID)->first();
        $delele_cinemaad->delete();
        $delete_cinemaadprice = Cinemasprice::where('cinemas_id', $cinemaadID);
        $delete_cinemaadprice->delete();
      
        return redirect()->route('dashboard.getCinemaList')->with(['message' => "Successfully Deleted From the List!"]);
    }

    // update cinema product
    public function getUpdateeCinemaad($ID)
    {
        $cinemaData = Cinemas::find($ID);
        $cinemapriceData = Cinemasprice::where('cinemas_id', $ID)->get();
        $fieldData = array();
        foreach($cinemapriceData as $pricecinema){
            $fieldData[] = ucwords(str_replace('_', ' ', substr($pricecinema->price_key, 6)));
        }

       $fieldDatas = serialize($fieldData);
        return view('backend.mediatypes.cinemas.cinema-editform', ['cinema' => $cinemaData, 'cinemapricemeta' => $cinemapriceData, 'fieldData' => $fieldDatas]);
    }
    //check and uncheck options remove
    public function getuncheckCinemaadOptions(Request $request)
    {
        $displayoptions = json_decode($request['displayoptions']);
        $datta = array();
        foreach($displayoptions as $options){
            $datta[] = strtolower(str_replace(' ', '_', $options));
        
        }
        $count = Cinemasprice::where([
                                    ['cinemas_id', '=', $request['id']],
                                    ['price_key', '=', $request['price_key']],
                                ])->count();
        if($count > 0){
            Cinemas::where('id', $request['id'])->update(['display_options' => serialize($datta)]);
            $cinemas = Cinemasprice::where([
                                    ['cinemas_id', '=', $request['id']],
                                    ['price_key', '=', $request['price_key']],
                                ])->first();
            $cinemas->delete();
             
            return response(['msg' => 'price deleted'], 200);
        }else{
              
            return response(['msg' => 'Value not present in db!'], 200);
        }
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
           'status' => 'required',
           'audiseats' => 'numeric',
           'audinumber' => 'numeric',
           'cinemanumber' => 'numeric',
           'cinemadiscount' => 'numeric'
        ]);

        $editcinema = Cinemas::find($ID);

         $editcinema->title = $request->input('title');
         $editcinema->price = $request->input('price');
         $editcinema->location = $request->input('location');
         $editcinema->state = $request->input('state');
         $editcinema->city = $request->input('city');
         $editcinema->rank = $request->input('rank');
         $editcinema->landmark = $request->input('landmark');
         $editcinema->description = $request->input('description');
         $editcinema->status = $request->input('status');
         $editcinema->references = $request->input('reference');
         $editcinema->display_options = serialize($request->input('cinemadisplay'));
         $editcinema->cinemanumber = $request->input('cinemasnumber');
         $editcinema->discount = $request->input('cinemadiscount');
         $editcinema->audiseats = $request->input('audiseats');
         $editcinema->audinumber = $request->input('audinumber');
         $editcinema->cinemacategory = $request->input('cinemacategory');
         
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

       if($request->has('price_rate_per_week')){
            $this->updateCinemaPrice($ID, 'price_rate_per_week', $request->input('price_rate_per_week'), 'duration_rate_per_week', $request->input('duration_rate_per_week'));
        }

       if($request->has('price_trailor_per_week')){
            $this->updateCinemaPrice($ID, 'price_trailor_per_week', $request->input('price_trailor_per_week'), 'duration_trailor_per_week', $request->input('duration_trailor_per_week'));
        } //can be used as no of seats or no of screens

       
        if($request->has('price_mute_slide_per_week')){
            $this->updateCinemaPrice($ID, 'price_mute_slide_per_week', $request->input('price_mute_slide_per_week'), 'duration_mute_slide_per_week', $request->input('duration_mute_slide_per_week'));
        }
        

        //return to cinema product list
       return redirect()->route('dashboard.getCinemaList')->with('message', 'Successfully Edited!');
    }

    public function updateCinemaPrice( $id, $pricekey, $pricevalue, $durkey, $durvalue){
        $count = Cinemasprice::where([
                                    ['cinemas_id', '=', $id],
                                    ['price_key', '=', $pricekey],
                                ])->count();
        if($count < 1){
            $this->addCinemaPrice($id, $pricekey, $pricevalue, $durkey, $durvalue);
        }else{
            $update = Cinemasprice::where([
                                    ['cinemas_id', '=', $id],
                                    ['price_key', '=', $pricekey],
                                ])->update(['price_value' => $pricevalue, 'duration_value' => $durvalue]);
        }
        
   }

   //Fliter Functions
   public function getFilterCinemaAds(Request $request){
       $params = array_filter($request->all());
       foreach($params as $key=>$value){
            if($key == 'pricerange'){
                
                $filter_priceCamparsion = preg_replace('/[0-9]+/', '', $value); // comparion operator
                if($filter_priceCamparsion != '<>'){
                     $filter_price = preg_replace('/[^0-9]/', '', $value);
                     $cinemapriceOptions = Cinemasprice::where([
                                    ['price_key', 'LIKE', 'price_%'],                                    
                                    ['price_value', $filter_priceCamparsion, $filter_price],
                                    ])->get()->toArray();
                }else{
                     $filter_price = preg_replace('/[^0-9]/', '_', $value);
                     $filter_price = explode('_', $filter_price);
                    
                     $cinemapriceOptions = Cinemasprice::where([
                                    ['price_key', 'LIKE', 'price_%'],                                    
                                    ['price_value', '>=', $filter_price[0]],
                                    ['price_value', '<=', $filter_price[2]],
                                    ])->get()->toArray();   
                }
                if(count($cinemapriceOptions)>0){
                
                foreach($cinemapriceOptions as $key => $value){
                    $cinema_ads = Cinemas::find($value['cinemas_id'])->get()->toArray();
                    $filterLike = substr($value['price_key'], 6);
                    $cinemaOption1 = '%'.$filterLike;
                    $cinemas = array();
                    
                    $cinemapriceOptions = Cinemasprice::where([
                                ['cinemas_id', '=', $value['cinemas_id']],
                                ['price_key', 'LIKE', $cinemaOption1],
                                //['price_value', $filter_priceCamparsion, $filter_price],
                                ])->get(array('price_key', 'price_value','duration_key', 'duration_value'))->toArray();
                        
                    array_push($cinema_ads, $cinemapriceOptions);
                    $cinemas[] = array_flatten($cinema_ads);
                     
                   
               
                }
                if(count($cinemas)>0){
                    echo "<pre>";
                    print_r($cinemas);
                    echo "</pre>";
                    foreach($cinemas as $searchCinema){
                       $this->cinema_ads($searchCinema);
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
   public function cinema_ads($searchCinema)
   {
       ?>
       <div class="col-md-3 col-sm-3 "> 
        <div class="pro-item"> 
            <div class=" cat-opt-img "> <img src="<?= asset('images/cinemas/'.$searchCinema[11]) ?>"> </div>
            <p class="font-1"><?= $searchCinema[3] ?></p>
            <p class="font-2"><?= $searchCinema[5] ?> | <?= $searchCinema[6] ?> | <?= $searchCinema[7] ?></p>
            <p class="font-3"><?= $searchCinema[21]?> <?= ucwords(substr(str_replace('_', ' ', $searchCinema[18]), 6))?> for <?= $searchCinema[23]?> months</p>
            <p class="font-2"><del class="lighter">Rs <?= $searchCinema[19]?> </del>Rs <?= $searchCinema[19]?> </p>
            <?php
            $options = $searchCinema[19].'+'.$searchCinema[18];
            $session_key = 'cinemas'.'_'.$searchCinema[18].'_'.$searchCinema[0];
            $printsession = (array) Session::get('cart');
                            
           ?>
            <div class="clearfix"> 
                <a class="glass" href="<?= route('cinema.addtocart', ['id' => $searchCinema[0], 'variation' => $options]) ?>"><span class="fa fa-star"></span>
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
        $cinema_ad = Cinemas::where('id', $id)->first()->toArray();
        
        $selectDisplayOpt = explode("+", $variation);

        $main_key = substr($selectDisplayOpt[1], 6);

        $cinema_price = Cinemasprice::where([
                                    ['cinemas_id', '=', $id],
                                    ['price_key', '=', $selectDisplayOpt[1]],
                                ])->first()->toArray();
        
        
        $cinema_Ad = array_merge($cinema_ad, $cinema_price);
       
        $oldCart = Session::has('cart') ? Session::get('cart') : null;
                
        $cart = new Cart($oldCart);

        $cart->addorRemove($cinema_Ad, $cinema_ad['id'], 'cinemas', $flag=true); //pass full cinema details, id and model name like "cinemas"
        
        $request->session()->put('cart', $cart);
        //Session::forget('cart');

        return redirect()->back()->with(['status' => 'added']);
    }

 
}
