<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use Session;
use App\Busstops;
use App\Busstopsprice;
use App\Mainaddtype;
use Image;
use App\Product;
use Illuminate\Support\Facades\File;
use App\Cart;
use App\Order;


class BusstopController extends Controller
{
    
    public function __construct()
    {
        $this->middleware('admin', ['only' => ['getDashboardBusstopList', 'getDashboardBusstopForm', 'postDashboardBusstopForm', 'addBusstopPrice', 'getDeleteBusstopad', 'getUpdateeBusstopad', 'getuncheckBusstopadOptions']]);
    }
    //frontend function starts
    
    public function getfrontendAllBusstopads()
    {
       $busstop_ads = Busstops::all();
          $ad_cats = Mainaddtype::orderBy('title')->get();


       return view('frontend-mediatype.busstops.busstopads-list', ['products' => $busstop_ads,'mediacats' => $ad_cats]);
    }
    
    public function getfrontBusstopad($id)
    {
        $busstoppricead = Busstopsprice::where('busstops_id', $id)->get();
                    
        return view('frontend-mediatype.busstops.busstop-single', ['busstopads' => $busstoppricead]);
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
                'stopinnumber' => $request->input('busstopsnumber')
        ]);

        $busstop->save();

        $lastinsert_ID = $busstop->id;



        //busstop display prices insertion

   	   if($request->has('price_full')){
            $this->addBusstopPrice($lastinsert_ID, 'price_full', $request->input('price_full'), 'number_full', $request->input('number_full'), 'duration_full', $request->input('duration_full'));
        }


        if($request->has('price_roof_front')){
            $this->addBusstopPrice($lastinsert_ID, 'price_roof_front', $request->input('price_roof_front'), 'number_roof_front', $request->input('number_roof_front'), 'duration_roof_front', $request->input('duration_roof_front'));
        }
       
        if($request->has('price_seat_backs')){
            $this->addBusstopPrice($lastinsert_ID, 'price_seat_backs', $request->input('price_seat_backs'), 'number_seat_backs', $request->input('number_seat_backs'), 'duration_seat_backs', $request->input('duration_seat_backs'));
        }
      
       if($request->has('price_side_boards')){
            $this->addBusstopPrice($lastinsert_ID, 'price_side_boards', $request->input('price_side_boards'), 'number_side_boards', $request->input('number_side_boards'), 'duration_side_boards', $request->input('duration_side_boards'));
        }
      
       
        //return to busstop product list
       return redirect()->route('dashboard.getBusstopList')->with('message', 'Successfully Added!');
    }

    //insert price data to busstop price table
    public function addBusstopPrice($id, $pricekey, $pricevalue, $numkey, $numvalue, $durkey, $durvalue)
    {
        $insert = new Busstopsprice();

        $insert->busstops_id = $id;
        $insert->price_key = $pricekey;
        $insert->price_value = $pricevalue;
        $insert->number_key = $numkey;
        $insert->number_value = $numvalue;
        $insert->duration_key = $durkey;
        $insert->duration_value = $durvalue;
       
        $insert->save();

    }

    // delete busstop product and price form db tables

    public function getDeleteBusstopad($busstopadID)
    {
        $delele_busstopad = Busstops::where('id', $busstopadID)->first();
        $delele_busstopad->delete();
        $delete_busstopadprice = Busstopsprice::where('busstops_id', $busstopadID);
        $delete_busstopadprice->delete();
       
        return redirect()->route('dashboard.getBusstopList')->with(['message' => "Successfully Deleted From the List!"]);
    }

    // update busstop product
    public function getUpdateeBusstopad($ID)
    {
        $busstopData = Busstops::find($ID);
        $busstoppriceData = Busstopsprice::where('busstops_id', $ID)->get();
        $fieldData = array();
        foreach($busstoppriceData as $pricebusstop){
             $fieldData[] = ucwords(str_replace('_', ' ', substr($pricebusstop->price_key, 6)));
        }

       $fieldData = serialize($fieldData);
        return view('backend.mediatypes.busstops.busstop-editform', ['busstop' => $busstopData, 'busstoppricemeta' => $busstoppriceData, 'fieldData' => $fieldData]);
    }

    //check and uncheck options remove
    public function getuncheckBusstopadOptions(Request $request)
    {
        $displayoptions = json_decode($request['displayoptions']);
        $datta = array();
        foreach($displayoptions as $options){
            $datta[] = strtolower(str_replace(' ', '_', $options));
        
        }

        $count = Busstopsprice::where([
                                    ['busstops_id', '=', $request['id']],
                                    ['price_key', '=', $request['price_key']],
                                ])->count();
        if($count > 0){
            Busstops::where('id', $request['id'])->update(['display_options' => serialize($datta)]);

            $busstops = Busstopsprice::where([
                                    ['busstops_id', '=', $request['id']],
                                    ['price_key', '=', $request['price_key']],
                                ])->first();
            $busstops->delete();
            
            return response(['msg' => 'price deleted'], 200);
        }else{
              
            return response(['msg' => 'Value not present in db!'], 200);
        }
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
         $editbusstop->light_option = $request->input('bslighting');
          $editbusstop->stopinnumber = $request->input('busstopsnumber');
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
            $this->updateBusstopPrice($ID, 'price_full', $request->input('price_full'), 'number_full', $request->input('number_full'), 'duration_full', $request->input('duration_full'));
        }
      
       
        if($request->has('price_roof_front')){
            $this->updateBusstopPrice($ID, 'price_roof_front', $request->input('price_roof_front'), 'number_roof_front', $request->input('number_roof_front'), 'duration_roof_front', $request->input('duration_roof_front'));
        }
        
        if($request->has('price_seat_backs')){
            $this->updateBusstopPrice($ID, 'price_seat_backs', $request->input('price_seat_backs'), 'number_seat_backs', $request->input('number_seat_backs'), 'duration_seat_backs', $request->input('duration_seat_backs'));
        }
        
       if($request->has('price_side_boards')){
            $this->updateBusstopPrice($ID, 'price_side_boards', $request->input('price_side_boards'), 'number_side_boards', $request->input('number_side_boards'), 'duration_side_boards', $request->input('duration_side_boards'));
        }
      
      

        //return to busstop product list
       return redirect()->route('dashboard.getBusstopList')->with('message', 'Successfully Edited!');
    }

    public function updateBusstopPrice( $id, $pricekey, $pricevalue, $numkey, $numvalue, $durkey, $durvalue){
        $count = Busstopsprice::where([
                                    ['busstops_id', '=', $id],
                                    ['price_key', '=', $pricekey],
                                ])->count();
        if($count < 1){
            $this->addBusstopPrice( $id, $pricekey, $pricevalue, $numkey, $numvalue, $durkey, $durvalue);
        }else{
            $update = Busstopsprice::where([
                                    ['busstops_id', '=', $id],
                                    ['price_key', '=', $pricekey],
                                ])->update(['price_value' => $pricevalue, 'number_value' => $numvalue, 'duration_value' => $durvalue]);
        }
        
   }

   //Fliter Functions
   public function getFilterBusstopAds(Request $request){
       $params = array_filter($request->all());
       foreach($params as $key=>$value){
            if($key == 'pricerange'){
                
                $filter_priceCamparsion = preg_replace('/[0-9]+/', '', $value); // comparion operator
                if($filter_priceCamparsion != '<>'){
                     $filter_price = preg_replace('/[^0-9]/', '', $value);
                     $busstoppriceOptions = Busstopsprice::where([
                                    ['price_key', 'LIKE', 'price_%'],                                    
                                    ['price_value', $filter_priceCamparsion, $filter_price],
                                    ])->get()->toArray();
                }else{
                     $filter_price = preg_replace('/[^0-9]/', '_', $value);
                     $filter_price = explode('_', $filter_price);
                    
                     $busstoppriceOptions = Busstopsprice::where([
                                    ['price_key', 'LIKE', 'price_%'],                                    
                                    ['price_value', '>=', $filter_price[0]],
                                    ['price_value', '<=', $filter_price[2]],
                                    ])->get()->toArray();   
                }
                if(count($busstoppriceOptions)>0){
                
                foreach($busstoppriceOptions as $key => $value){
                    $busstop_ads = Busstops::find($value['busstops_id'])->get()->toArray();
                    $filterLike = substr($value['price_key'], 6);
                    $busstopOption1 = '%'.$filterLike;
                    $busstops = array();
                    
                    $busstoppriceOptions = Busstopsprice::where([
                                ['busstops_id', '=', $value['busstops_id']],
                                ['price_key', 'LIKE', $busstopOption1],
                                //['price_value', $filter_priceCamparsion, $filter_price],
                                ])->get(array('price_key', 'price_value', 'number_key', 'number_value', 'duration_key', 'duration_value'))->toArray();
                        
                    array_push($busstop_ads, $busstoppriceOptions);
                    $busstops[] = array_flatten($busstop_ads);
                     
                   
               
                }
                if(count($busstops)>0){
                   
                    foreach($busstops as $searchBusstop){
                       $this->busstop_ads($searchBusstop);
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
   public function busstop_ads($searchBusstop)
   {
       ?>
       <div class="col-md-3 col-sm-3 "> 
        <div class="pro-item"> 
            <div class=" cat-opt-img "> <img src="<?= asset('images/busstops/'.$searchBusstop[11]) ?>"> </div>
            <p class="font-1"><?= $searchBusstop[3] ?></p>
            <p class="font-2"><?= $searchBusstop[5] ?> | <?= $searchBusstop[6] ?> | <?= $searchBusstop[7] ?></p>
            <p class="font-3"><?= $searchBusstop[21]?> <?= ucwords(substr(str_replace('_', ' ', $searchBusstop[18]), 6))?> for <?= $searchBusstop[23]?> months</p>
            <p class="font-2"><del class="lighter">Rs <?= $searchBusstop[19]?> </del>Rs <?= $searchBusstop[19]?> </p>
            <?php
            $options = $searchBusstop[19].'+'.$searchBusstop[18];
            $session_key = 'busstops'.'_'.$searchBusstop[18].'_'.$searchBusstop[0];
            $printsession = (array) Session::get('cart');
                            
           ?>
            <div class="clearfix"> 
                <a class="glass" href="<?= route('busstop.addtocart', ['id' => $searchBusstop[0], 'variation' => $options]) ?>"><span class="fa fa-star"></span>
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
        $busstop_ad = Busstops::where('id', $id)->first()->toArray();
       
        $busPrice = new Busstopsprice();

        $busstop_price = $busPrice->getBusstopsPriceCart($id, $variation);

        
        $busstop_Ad = array_merge($busstop_ad, $busstop_price);
       
        $oldCart = Session::has('cart') ? Session::get('cart') : null;
                
        $cart = new Cart($oldCart);

        $status = $cart->addorRemove($busstop_Ad, $busstop_ad['id'], 'busstops', $flag=true); //pass full busstop details, id and model name like "busstops"
        
        $request->session()->put('cart', $cart);
        //Session::forget('cart');

        return redirect()->back()->with(['status' => $status]);
    }

 
}
