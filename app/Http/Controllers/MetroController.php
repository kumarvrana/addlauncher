<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use Session;
use App\Metros;
use App\Metrosprice;
use App\Mainaddtype;
use Image;
use App\Product;
use Illuminate\Support\Facades\File;
use App\Cart;
use App\Order;


class MetroController extends Controller
{
    
    public function __construct()
    {
        $this->middleware('admin', ['only' => ['getDashboardMetroList', 'getDashboardMetroForm', 'postDashboardMetroForm', 'addMetroPrice', 'getDeleteMetroad', 'getUpdateeMetroad', 'getuncheckMetroadOptions']]);
    }
    //frontend function starts
    
    public function getfrontendAllMetroads()
    {
       $metro_ads = Metros::all();
       if(count($metro_ads)>0){
            $mediatypes= new Mainaddtype();
            $ad_cats = $mediatypes->mediatype('Metro');
            return view('frontend-mediatype.metros.metroads-list', ['products' => $metro_ads, 'mediacat' => $ad_cats]);
       }
       return view('partials.comingsoon');
    }

       
    public function getfrontMetroad($id)
    {
        $metroad = Metros::where('id', '=', $id)->get()->toArray();
        $metroad = array_flatten($metroad);
        $metropriceOptions = Metrosprice::where('metros_id', '=', $id)->get(array('price_key', 'price_value', 'number_key', 'number_value', 'duration_key', 'duration_value'))->toArray();
            
        return view('frontend-mediatype.metros.metro-single', ['products' => $metroad, 'productOptions' => $metropriceOptions]);
    }
    
    
    // frontend functions ends

    //Backend functions below


    // get list of all the products in metro stop media type
    public function getDashboardMetroList(){
        $metro_ads = Metros::all();
        return view('backend.mediatypes.metros.metro-list', ['metro_ads' => $metro_ads]);
    }
    
    // get form of metro stop media type
     public function getDashboardMetroForm()
    {
        return view('backend.mediatypes.metros.metro-addform');
    }

    // post list of all the products in metro media type

    public function postDashboardMetroForm(Request $request)
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
            $location = public_path("images\metros\\" . $filename);
            Image::make($file)->resize(800, 400)->save($location);
        }

        $metro = new Metros([
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
                'display_options' => serialize($request->input('metrodisplay')),
                'light_option' => $request->input('metrolight'),
                'discount' => $request->input('metrodiscount'),
                'metronumber' => $request->input('metrosnumber'),
                 'reference_mail' => $request->input('reference_mail')
        ]);

        $metro->save();

        $lastinsert_ID = $metro->id;



        //metro display prices insertion
        if($request->has('price_full')){
            $this->addMetroPrice($lastinsert_ID, 'price_full', $request->input('price_full'), 'number_full', $request->input('number_full'), 'duration_full', $request->input('duration_full'));
        }
      
       
        if($request->has('price_roof_front')){
            $this->addMetroPrice($lastinsert_ID, 'price_roof_front', $request->input('price_roof_front'), 'number_roof_front', $request->input('number_roof_front'), 'duration_roof_front', $request->input('duration_roof_front'));
        }
        
        if($request->has('price_seat_backs')){
            $this->addMetroPrice($lastinsert_ID, 'price_seat_backs', $request->input('price_seat_backs'), 'number_seat_backs', $request->input('number_seat_backs'), 'duration_seat_backs', $request->input('duration_seat_backs'));
        }
         
      
       if($request->has('price_side_boards')){
            $this->addMetroPrice($lastinsert_ID, 'price_side_boards', $request->input('price_side_boards'), 'number_side_boards', $request->input('number_side_boards'), 'duration_side_boards', $request->input('duration_side_boards'));
        }
      

       
        //return to metro product list
       return redirect()->route('dashboard.getMetroList')->with('message', 'Successfully Added!');
    }

    //insert price data to metro price table
    public function addMetroPrice($id, $pricekey, $pricevalue, $numkey, $numvalue, $durkey, $durvalue)
    {
        $insert = new Metrosprice();

        $insert->metros_id = $id;
        $insert->price_key = $pricekey;
        $insert->price_value = $pricevalue;
        $insert->number_key = $numkey;
        $insert->number_value = $numvalue;
        $insert->duration_key = $durkey;
        $insert->duration_value = $durvalue;
       
        $insert->save();

    }

    // delete metro product and price form db tables

    public function getDeleteMetroad($metroadID)
    {
        $delele_metroad = Metros::where('id', $metroadID)->first();
        $delele_metroad->delete();
        $delete_metroadprice = Metrosprice::where('metros_id', $metroadID);
        $delete_metroadprice->delete();
       
        return redirect()->route('dashboard.getMetroList')->with(['message' => "Successfully Deleted From the List!"]);
    }

    // update metro product
    public function getUpdateeMetroad($ID)
    {
        $metroData = Metros::find($ID);
        $metropriceData = Metrosprice::where('metros_id', $ID)->get();
        $fieldData = array();
        foreach($metropriceData as $pricemetro){
           $fieldData[] = ucwords(str_replace('_', ' ', substr($pricemetro->price_key, 6)));
        }
        
       $fieldDatas = serialize($fieldData);
        return view('backend.mediatypes.metros.metro-editform', ['metro' => $metroData, 'metropricemeta' => $metropriceData, 'fieldData' => $fieldDatas]);
    }
    //check and uncheck options remove
    public function getuncheckMetroadOptions(Request $request)
    {
        $displayoptions = json_decode($request['displayoptions']);
        $datta = array();
        foreach($displayoptions as $options){
            $datta[] = strtolower(str_replace(' ', '_', $options));
        
        }
        $count = Metrosprice::where([
                                    ['metros_id', '=', $request['id']],
                                    ['price_key', '=', $request['price_key']],
                                ])->count();
        if($count > 0){
            Metros::where('id', $request['id'])->update(['display_options' => serialize($datta)]);
            $metros = Metrosprice::where([
                                    ['metros_id', '=', $request['id']],
                                    ['price_key', '=', $request['price_key']],
                                ])->first();
            $metros->delete();
            return response(['msg' => 'price deleted'], 200);
        }else{
              
        }    return response(['msg' => 'Value not present in db!'], 200);
        
    }

    public function postUpdateeMetroad(Request $request, $ID)
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

        $editmetro = Metros::find($ID);

         $editmetro->title = $request->input('title');
         $editmetro->price = $request->input('price');
         $editmetro->location = $request->input('location');
         $editmetro->state = $request->input('state');
         $editmetro->city = $request->input('city');
         $editmetro->rank = $request->input('rank');
         $editmetro->description = $request->input('description');
         $editmetro->status = $request->input('status');
         $editmetro->references = $request->input('reference');
         $editmetro->display_options = serialize($request->input('metrodisplay'));
          $editmetro->metronumber = $request->input('metrosnumber');
          $editmetro->discount = $request->input('metrodiscount');
          $editmetro->reference_mail = $request->input('reference_mail');

        if($request->hasFile('image')){
            $file = $request->file('image');
            $filename = time() .'.'. $file->getClientOriginalExtension();
            $location = public_path("images\metros\\" . $filename);
            Image::make($file)->resize(800, 400)->save($location);
            $oldimage = $editmetro->image;
            $editmetro->image = $filename;
        }

       $editmetro->update();

        //metro display prices insertion

        if($request->has('price_full')){
            $this->updateMetroPrice($ID, 'price_full', $request->input('price_full'), 'number_full', $request->input('number_full'), 'duration_full', $request->input('duration_full'));
        }
      
      

        if($request->has('price_roof_front')){
            $this->updateMetroPrice($ID, 'price_roof_front', $request->input('price_roof_front'), 'number_roof_front', $request->input('number_roof_front'), 'duration_roof_front', $request->input('duration_roof_front'));
        }
        
        if($request->has('price_seat_backs')){
            $this->updateMetroPrice($ID, 'price_seat_backs', $request->input('price_seat_backs'), 'number_seat_backs', $request->input('number_seat_backs'), 'duration_seat_backs', $request->input('duration_seat_backs'));
        }
        
      
       if($request->has('price_side_boards')){
            $this->updateMetroPrice($ID, 'price_side_boards', $request->input('price_side_boards'), 'number_side_boards', $request->input('number_side_boards'), 'duration_side_boards', $request->input('duration_side_boards'));
        }
      
       

        //return to metro product list
       return redirect()->route('dashboard.getMetroList')->with('message', 'Successfully Edited!');
    }

    public function updateMetroPrice($id, $pricekey, $pricevalue, $numkey, $numvalue, $durkey, $durvalue){
        $count = Metrosprice::where([
                                    ['metros_id', '=', $id],
                                    ['price_key', '=', $pricekey],
                                ])->count();
        if($count < 1){
            $this->addMetroPrice($id, $pricekey, $pricevalue, $numkey, $numvalue, $durkey, $durvalue);
        }else{
            $update = Metrosprice::where([
                                    ['metros_id', '=', $id],
                                    ['price_key', '=', $pricekey],
                                ])->update(['price_value' => $pricevalue, 'number_value' => $numvalue, 'duration_value' => $durvalue]);
        }
        
   }

   //Fliter Functions
   public function getFilterMetroAds(Request $request){
       $params = array_filter($request->all());
       foreach($params as $key=>$value){
            if($key == 'pricerange'){
                
                $filter_priceCamparsion = preg_replace('/[0-9]+/', '', $value); // comparion operator
                if($filter_priceCamparsion != '<>'){
                     $filter_price = preg_replace('/[^0-9]/', '', $value);
                     $metropriceOptions = Metrosprice::where([
                                    ['price_key', 'LIKE', 'price_%'],                                    
                                    ['price_value', $filter_priceCamparsion, $filter_price],
                                    ])->get()->toArray();
                }else{
                     $filter_price = preg_replace('/[^0-9]/', '_', $value);
                     $filter_price = explode('_', $filter_price);
                    
                     $metropriceOptions = Metrosprice::where([
                                    ['price_key', 'LIKE', 'price_%'],                                    
                                    ['price_value', '>=', $filter_price[0]],
                                    ['price_value', '<=', $filter_price[2]],
                                    ])->get()->toArray();   
                }
                if(count($metropriceOptions)>0){
                
                foreach($metropriceOptions as $key => $value){
                    $metro_ads = Metros::find($value['metroes_id'])->get()->toArray();
                    $filterLike = substr($value['price_key'], 6);
                    $metroOption1 = '%'.$filterLike;
                    $metroes = array();
                    
                    $metropriceOptions = Metrosprice::where([
                                ['metroes_id', '=', $value['metroes_id']],
                                ['price_key', 'LIKE', $metroOption1],
                                //['price_value', $filter_priceCamparsion, $filter_price],
                                ])->get(array('price_key', 'price_value', 'number_key', 'number_value', 'duration_key', 'duration_value'))->toArray();
                        
                    array_push($metro_ads, $metropriceOptions);
                    $metroes[] = array_flatten($metro_ads);
                     
                   
               
                }
                if(count($metroes)>0){
                    echo "<pre>";
                    print_r($metroes);
                    echo "</pre>";
                    foreach($metroes as $searchMetro){
                       $this->metro_ads($searchMetro);
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
   public function metro_ads($searchMetro)
   {
       ?>
       <div class="col-md-3 col-sm-3 "> 
        <div class="pro-item"> 
            <div class=" cat-opt-img "> <img src="<?= asset('images/metroes/'.$searchMetro[11]) ?>"> </div>
            <p class="font-1"><?= $searchMetro[3] ?></p>
            <p class="font-2"><?= $searchMetro[5] ?> | <?= $searchMetro[6] ?> | <?= $searchMetro[7] ?></p>
            <p class="font-3"><?= $searchMetro[21]?> <?= ucwords(substr(str_replace('_', ' ', $searchMetro[18]), 6))?> for <?= $searchMetro[23]?> months</p>
            <p class="font-2"><del class="lighter">Rs <?= $searchMetro[19]?> </del>Rs <?= $searchMetro[19]?> </p>
            <?php
            $options = $searchMetro[19].'+'.$searchMetro[18];
            $session_key = 'metroes'.'_'.$searchMetro[18].'_'.$searchMetro[0];
            $printsession = (array) Session::get('cart');
                            
           ?>
            <div class="clearfix"> 
                <a class="glass" href="<?= route('metro.addtocart', ['id' => $searchMetro[0], 'variation' => $options]) ?>"><span class="fa fa-star"></span>
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
        $metro_ad = Metros::where('id', $id)->first()->toArray();
        
        $selectDisplayOpt = explode("+", $variation);
        $main_key = substr($selectDisplayOpt[1], 6);
        
     
        $metro_price = Metrosprice::where([
                                    ['metros_id', '=', $id],
                                    ['price_key', '=', $selectDisplayOpt[1]],
                                ])->first()->toArray();
       
       
        
        $metro_Ad = array_merge($metro_ad, $metro_price);
       
        $oldCart = Session::has('cart') ? Session::get('cart') : null;
                
        $cart = new Cart($oldCart);

        $cart->addorRemove($metro_Ad, $metro_ad['id'], 'metros', $flag=true); //pass full metro details, id and model name like "metros"
        
        $request->session()->put('cart', $cart);
        //Session::forget('cart');

        return redirect()->back()->with(['status' => 'added']);
    }

 
}
