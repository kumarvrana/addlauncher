<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Http\Requests;
use Session;
use App\Autos;
use App\Autosprice;
use App\Mainaddtype;
use Image;
use App\Product;
use Illuminate\Support\Facades\File;
use App\Cart;
use App\Order;




class AutoController extends Controller
{

    public function __construct()
    {
        $this->middleware('admin', ['only' => ['getDashboardAutoList', 'getDashboardAutoForm', 'postDashboardAutoForm', 'addAutoPrice', 'getDeleteAutoad', 'postUpdateeAutoad', 'getUpdateeAutoad', 'getuncheckAutoadOptions']]);
    } 

     //frontend function starts
    
    public function getfrontendAllAutoads()
    {

        $auto_type = array(  'auto_rikshaw' => 'Auto Rikshaw',
                        'e_rikshaw' => 'E Rikshaw',
                        'tricycle' => 'Tricycle'
                        );

        $location = 'Delhi NCR';
        $ad_cats = Mainaddtype::orderBy('title')->get();


        return view('frontend-mediatype.autos.autoads-list', ['auto_type' => $auto_type, 'location' => $location, 'mediacats' => $ad_cats]);
    }
    
    public function getfrontAutoadByType($autotype)
    {
        switch($autotype){
            case 'auto_rikshaw':
                $options = array(
                                'sticker' => 'Sticker',
                                'auto_hood' => 'Auto Hood',
                                'backboard' => 'Backboard',
                                'full_auto' => 'Full Auto'
                            );
            break;
            case 'e_rikshaw':
                $options = array(
                                'back_board' => 'Back Board',
                                'stepney_tier' => 'Stepney Tier'
                            );
            break;
            case 'tricycle':

                $auto_ads = Autos::where('autotype', $autotype)->get();

                return view('frontend-mediatype.autos.auto-single', [
                                                                    'autos' => $auto_ads,
                                                                    'autotype' => $autotype,
                                                                    'autoOption' => 'tricycle'
                                                                ]
                            );
             break;
         }

        $location = 'Delhi NCR';
        
        return view('frontend-mediatype.autos.autoAdByType', [
                                                    'options' => $options,
                                                    'autotype' => $autotype,
                                                    'location' => $location
                                                    ]
                    );
    }

    public function getfrontAutoadByOption($autotype, $autoOption)
    {
        
        $autos = new Autosprice();

        $autos = $autos->getAutoByFilter($autotype, $autoOption);
        
        return view('frontend-mediatype.autos.auto-single', ['autos' => $autos, 'autotype' => $autotype, 'autoOption' => $autoOption]);

    }

    public function getfrontAutoad($id)
    {
         $autoad = Autos::find($id);
        //$autoprice = Autosprice::where('autos_id', $id)->get();

         if($autoad){
            if($autoad->status === "3" || $autoad->status === "2"){
                return redirect()->back();
            }else{

       $autodisplay = Autosprice::where([
                                    ['autos_id', '=', $id],
                                    ['option_type', '=', 'display'],
                                ])->get();
        $autofrontprdisplay = Autosprice::where([
                                    ['autos_id', '=', $id],
                                    ['option_type', '=', 'frontpr'],
                                ])->get();
        $autostickerdisplay = Autosprice::where([
                                    ['autos_id', '=', $id],
                                    ['option_type', '=', 'sticker'],
                                ])->get();
        $autohooddisplay = Autosprice::where([
                                    ['autos_id', '=', $id],
                                    ['option_type', '=', 'hood'],
                                ])->get();
        $autointeriordisplay = Autosprice::where([
                                    ['autos_id', '=', $id],
                                    ['option_type', '=', 'interior'],
                                ])->get();
        return view('frontend-mediatype.autos.auto-single', ['autoad' => $autoad, 'auto_display' => $autodisplay, 'auto_frontprdisplay' => $autofrontprdisplay, 'auto_stickerdisplay' => $autostickerdisplay, 'auto_hooddisplay' => $autohooddisplay, 'auto_interiordisplay' => $autointeriordisplay]);
    }
    }else{
            return redirect()->back();
        }
        
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
           'status' => 'required',
           'autotype' => 'required'
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
                'autotype' => $request->input('autotype'),
                'status' => $request->input('status'),
                'autorikshaw_options' => serialize($request->input('autodisplay')),
                'erikshaw_options' => serialize($request->input('erikshawdisplay')),
                'light_option' => $request->input('autolighting'),
                'discount' => $request->input('autodiscount'),
                'auto_number' => $request->input('autosnumber')
        ]);

        $auto->save();

        $lastinsert_ID = $auto->id;


        if($request->input('autotype') == 'auto_rikshaw'){
            if($request->has('price_sticker')){
                $this->addAutoPrice($lastinsert_ID, 'price_sticker', $request->input('price_sticker'),'number_sticker', $request->input('number_sticker'),'duration_sticker', $request->input('duration_sticker'), 'auto_rikshaw');
            }
            
         

            if($request->has('price_auto_hood')){
                $this->addAutoPrice($lastinsert_ID, 'price_auto_hood', $request->input('price_auto_hood'), 'number_auto_hood', $request->input('number_auto_hood'), 'duration_auto_hood', $request->input('duration_auto_hood'), 'auto_rikshaw');
            }
            
          

            if($request->has('price_backboard')){
                $this->addAutoPrice($lastinsert_ID, 'price_backboard', $request->input('price_backboard'), 'number_backboard', $request->input('number_backboard'), 'duration_backboard', $request->input('duration_backboard'), 'auto_rikshaw');
            }
        
             if($request->has('price_full_auto')){
                $this->addAutoPrice($lastinsert_ID, 'price_full_auto', $request->input('price_full_auto'), 'number_full_auto', $request->input('number_full_auto'), 'duration_full_auto', $request->input('duration_full_auto'), 'auto_rikshaw');
            }
            
           
        }

        if($request->input('autotype') == 'e_rikshaw'){
            if($request->has('price_back_board')){
                $this->addAutoPrice($lastinsert_ID, 'price_back_board', $request->input('price_back_board'), 'number_back_board', $request->input('number_back_board'), 'duration_back_board', $request->input('duration_back_board'), 'e_rikshaw');
            }
            
           
            
            if($request->has('price_stepney_tier')){
                $this->addAutoPrice($lastinsert_ID, 'price_stepney_tier', $request->input('price_stepney_tier'), 'number_stepney_tier', $request->input('number_stepney_tier'), 'duration_stepney_tier', $request->input('duration_stepney_tier'), 'e_rikshaw');
            }
      
           
        }
        
        //return to auto product list
       return redirect()->route('dashboard.getAutoList')->with('message', 'Successfully Added!');
    }

    //insert price data to auto price table
    public function addAutoPrice($id, $pricekey, $pricevalue, $numkey, $numvalue, $durkey, $durvalue, $type)
    {
        $insert = new Autosprice();

        $insert->autos_id = $id;
        $insert->price_key = $pricekey;
        $insert->price_value = $pricevalue;
        $insert->number_key = $numkey;
        $insert->number_value = $numvalue;
        $insert->duration_key = $durkey;
        $insert->duration_value = $durvalue;
        $insert->option_type = $type;
       
        $insert->save();

    }

    // delete auto product and price form db tables

    public function getDeleteAutoad($autoadID)
    {
        $delele_autoad = Autos::where('id', $autoadID)->first();
        $delele_autoad->delete();
        $delete_autoadprice = Autosprice::where('autos_id', $autoadID);
        $delete_autoadprice->delete();
        
        return redirect()->route('dashboard.getAutoList')->with(['message' => "Successfully Deleted From the List!"]);
    }

    // update auto product
    public function getUpdateeAutoad($ID)
    {
        $autoData = Autos::find($ID);
        $autopriceData = Autosprice::where('autos_id', $ID)->get();
        $fieldData = array();
        foreach($autopriceData as $priceauto){
           $fieldData[] = ucwords(str_replace('_', ' ', substr($priceauto->price_key, 6)));
        }
       
       $fieldDatas = serialize($fieldData);
        return view('backend.mediatypes.autos.auto-editform', ['auto' => $autoData, 'autopricemeta' => $autopriceData, 'fieldData' => $fieldDatas]);
    }
    //check and uncheck options remove
    public function getuncheckAutoadOptions(Request $request)
    {
       
       $displayoptions = json_decode($request['displayoptions']);
       $datta = array();
        foreach($displayoptions as $options){
            $datta[] = strtolower(str_replace(' ', '_', $options));
        
        }
       
        $count = Autosprice::where([
                                    ['autos_id', '=', $request['id']],
                                    ['price_key', '=', $request['price_key']],
                                ])->count();
        if($count > 0){
            Autos::where('id', $request['id'])->update([$request['option_type'] => serialize($datta)]);
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
           'status' => 'required',
           //'autotype' => 'required'
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
         $editauto->autotype = $editauto->autotype;
         $editauto->autorikshaw_options = serialize($request->input('autodisplay'));
         $editauto->erikshaw_options = serialize($request->input('erikshawdisplay'));
         $editauto->light_option = $request->input('autolighting');
         $editauto->auto_number = $request->input('autosnumber');
         $editauto->discount = $request->input('autodiscount');

        if($request->hasFile('image')){
            $file = $request->file('image');
            $filename = time() .'.'. $file->getClientOriginalExtension();
            $location = public_path("images\autos\\" . $filename);
            Image::make($file)->resize(800, 400)->save($location);
            $oldimage = $editauto->image;
            $editauto->image = $filename;
        }

       $editauto->update();

        //auto display prices insertion
        if($editauto->autotype == 'auto_rikshaw'){
            if($request->has('price_sticker')){
                $this->updateAutoPrice($ID, 'price_sticker', $request->input('price_sticker'),'number_sticker', $request->input('number_sticker'),'duration_sticker', $request->input('duration_sticker'), 'auto_rikshaw');
            }
            
         

            if($request->has('price_auto_hood')){
                $this->updateAutoPrice($ID, 'price_auto_hood', $request->input('price_auto_hood'), 'number_auto_hood', $request->input('number_auto_hood'), 'duration_auto_hood', $request->input('duration_auto_hood'), 'auto_rikshaw');
            }
            
          

            if($request->has('price_backboard')){
                $this->updateAutoPrice($ID, 'price_backboard', $request->input('price_backboard'), 'number_backboard', $request->input('number_backboard'), 'duration_backboard', $request->input('duration_backboard'), 'auto_rikshaw');
            }
        
             if($request->has('price_full_auto')){
                $this->updateAutoPrice($ID, 'price_full_auto', $request->input('price_full_auto'), 'number_full_auto', $request->input('number_full_auto'), 'duration_full_auto', $request->input('duration_full_auto'), 'auto_rikshaw');
            }
            
           
        }

        if($editauto->autotype == 'e_rikshaw'){
            if($request->has('price_back_board')){
                $this->updateAutoPrice($ID, 'price_back_board', $request->input('price_back_board'), 'number_back_board', $request->input('number_back_board'), 'duration_back_board', $request->input('duration_back_board'), 'e_rikshaw');
            }
            
           
            
            if($request->has('price_stepney_tier')){
                $this->updateAutoPrice($ID, 'price_stepney_tier', $request->input('price_stepney_tier'), 'number_stepney_tier', $request->input('number_stepney_tier'), 'duration_stepney_tier', $request->input('duration_stepney_tier'), 'e_rikshaw');
            }
      
           
        }
       

        //return to auto product list
       return redirect()->route('dashboard.getAutoList')->with('message', 'Successfully Edited!');
    }

    public function updateAutoPrice( $id, $pricekey, $pricevalue, $numkey, $numvalue, $durkey, $durvalue, $type){
        $count = Autosprice::where([
                                    ['autos_id', '=', $id],
                                    ['price_key', '=', $pricekey],
                                ])->count();
        if($count < 1){
            $this->addAutoPrice($id, $pricekey, $pricevalue, $numkey, $numvalue, $durkey, $durvalue, $type);
        }else{
            $update = Autosprice::where([
                                    ['autos_id', '=', $id],
                                    ['price_key', '=', $pricekey],
                                ])->update(['price_value' => $pricevalue, 'number_value' => $numvalue, 'duration_value' => $durvalue]);
        }
        
   }


   //Fliter Functions
   public function getFilterAutoAds(Request $request)
   {
        
        $autoPrice = new Autosprice();
        $filterResults = $autoPrice->FilterAutosAds($request->all());

        if(count($filterResults)>0){
            foreach($filterResults as $searchAuto){
                $this->auto_ads($searchAuto, $request->all());
            }

        }else{
            echo "<img src='../images/oops.png' class='img-responsive oops-img'>";
        }

        $content = ob_get_contents();
        ob_get_clean();
        return $content;
  
   }

   public function auto_ads($searchAuto, $fileroptions)
   { 
         ?>
       
       <div class="col-md-3 col-sm-3 "> 
        <div class="pro-item"> 
            <div class=" cat-opt-img "> <img src="<?= asset('images/autos/'.$searchAuto->auto->image) ?>"> </div>
            <p class="font-1"><?= $searchAuto->auto->title ?></p>
            <p class="font-2"><?= $searchAuto->auto->location ?>, <?= $searchAuto->auto->city ?>, <?= $searchAuto->auto->state ?></p>
            <div class="row">
                <div class="col-md-6">
                    <p class="font-3"><?= $searchAuto->number_value ?> <?= ucwords(substr(str_replace('_', ' ', $searchAuto->price_key), 6))?> <br>for <br> <?= $searchAuto->duration_value?> months</p>
                    </div>
                <div class="col-md-6">
                        <p class="font-4"><del class="lighter">Rs <?= $searchAuto->price_value?> </del><br>Rs <?= $searchAuto->price_value?> </p>
                </div>
            
            </div>

            <?php
            $options = $searchAuto->price_value.'+'.$searchAuto->price_key;
            $session_key = 'autos'.'_'.$searchAuto->price_key.'_'.$searchAuto->auto->id;
            $printsession = (array) Session::get('cart');
                            
           ?>
            <div class="clearfix"> 
                <button class="glass add-cartButton" data-href="<?= route('auto.addtocartAfterSearch', ['id' => $searchAuto->auto->id, 'variation' => $options, 'fileroption' => http_build_query($fileroptions)]) ?>"><span class="fa fa-star"></span>
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
        $flag = false;
        $auto_ad = Autos::where('id', $id)->first()->toArray();
       
        $selectDisplayOpt = explode("+", $variation);
        if($selectDisplayOpt[1] !== 'tricycle'){
            $flag = true;
           
            $autoprice = new Autosprice();
            $auto_price =$autoprice->getAutoPriceForCart($id, $selectDisplayOpt[1]);
           

            $auto_ad = array_merge($auto_ad, $auto_price);
        }
    
        $oldCart = Session::has('cart') ? Session::get('cart') : null;
                
        $cart = new Cart($oldCart);

        $cart->addorRemove($auto_ad, $auto_ad['id'], 'autos', $flag); //pass full auto details, id and model name like "autos"
        
        $request->session()->put('cart', $cart);
        //Session::forget('cart');

        return redirect()->back()->with(['status' => 'added']);
    }

    // Search Option

    public function getAddToCartBySearch(Request $request, $id, $variation, $fileroption)
    {
        $auto_ad = Autos::where('id', $id)->first()->toArray();
        
        $autoPrice = new Autosprice();
        $auto_price = $autoPrice->getAutospriceCart($id, $variation);
       
        $auto_Ad = array_merge($auto_ad, $auto_price);
       
        $oldCart = Session::has('cart') ? Session::get('cart') : null;
                
        $cart = new Cart($oldCart);

        $status = $cart->addorRemove($auto_Ad, $auto_ad['id'], 'autos', $flag=true); //pass full auto details, id and model name like "autos"
        
        $request->session()->put('cart', $cart);
        //Session::forget('cart');

        return response(['status' => $status, 'quatity' => $cart->totalQty, 'total' => $cart->totalPrice], 200);
    }

 
}

