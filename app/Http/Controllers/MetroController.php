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

        $this->metro_line = array('blue_line' => 'Blue line', 'red_line' => 'Red line', 'yellow_line' => 'Yellow line', 'green_line' => 'Green line', 'violet_line' => 'Violet line', 'orange_line' => 'Orange line');


        $this->metro_options = array('backlit' => 'Backlit', 'ambilit' => 'Ambilit');

        $this->media = array('platform' => 'Platform', 'entry_exit' => 'Entry / Exit');
               
    }
    //frontend function starts
    
    public function getfrontendAllMetroads()
    {
       $metro_ads = Metros::all();
       if(count($metro_ads)>0){
            $mediatypes= new Mainaddtype();
            $ad_cats = $mediatypes->mediatype('Metro');
            $location_filter = Metros::select('location')->distinct()->get();
            return view('frontend-mediatype.metros.metroads-list', ['products' => $metro_ads, 'mediacat' => $ad_cats,'metro_line' => $this->metro_line,'filter_location'=>$location_filter]);
       }
       return view('partials.comingsoon');
    }

       
    public function getfrontByLine($line)
    {
        
        $metros = Metros::where('metro_line', '=', $line)->get(array('id'));
        $ids = array();
        foreach($metros as $metro){
            $ids[] = $metro->id;
        }
        $metroprice = Metrosprice::whereIn('metros_id', $ids)
                    ->get();
        
        return view('frontend-mediatype.metros.metro-single', ['metros' => $metroprice,'price_key' => $line]);
    
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
        return view('backend.mediatypes.metros.metro-addform', [
                                                                'metro_line' => $this->metro_line,
                                                                'metro_options' => $this->metro_options,
                                                                'media' => $this->media]);
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
                'light_option' => $request->input('light_option'),
                'discount' => $request->input('metrodiscount'),
                'media' => $request->input('media'),
                'metro_line' => $request->input('metro_line'),
                'reference_mail' => $request->input('reference_mail')
        ]);

        $metro->save();

        $lastinsert_ID = $metro->id;



        //metro display prices insertion
        if($request->has('price_backlit')){
            $this->addMetroPrice($lastinsert_ID,'price_backlit', $request->input('price_backlit'), $request->input('number_of_face_backlit'), $request->input('dimension_backlit'), $request->input('price_backlit'), $request->input('printing_price_backlit'), $request->input('total_price_backlit'));
        }
      
       
        if($request->has('price_ambilit')){
            $this->addMetroPrice($lastinsert_ID,'price_ambilit', $request->input('price_ambilit'), $request->input('number_of_face_ambilit'), $request->input('dimension_ambilit'), $request->input('price_ambilit'), $request->input('printing_price_ambilit'), $request->input('total_price_ambilit'));
        }
       
        //return to metro product list
       return redirect()->route('dashboard.getMetroList')->with('message', 'Successfully Added!');
    }

    //insert price data to metro price table
    public function addMetroPrice($id,$price_key, $unit, $facenumber, $dimension, $baseprice, $printingcharge, $totalprice)
    {

        $insert = new Metrosprice();

        $insert->metros_id = $id;
        $insert->price_key = $price_key;
        $insert->unit = $unit;
        $insert->number_face = $facenumber;
        $insert->dimension = $dimension;
        $insert->base_price = $baseprice;
        $insert->printing_charge = $printingcharge;
        $insert->totalprice = $totalprice;
       
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
        return view('backend.mediatypes.metros.metro-editform', ['metro' => $metroData,'metro_line' => $this->metro_line,'metro_options' => $this->metro_options,'media' => $this->media, 'metropricemeta' => $metropriceData, 'fieldData' => $fieldDatas]);
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

        if($request->has('price_backlit')){
            $this->updateMetroPrice($ID,'price_backlit', $request->input('price_backlit'), $request->input('number_of_face_backlit'), $request->input('dimension_backlit'), $request->input('price_backlit'), $request->input('printing_price_backlit'), $request->input('total_price_backlit'));
        }
      
       
        if($request->has('price_ambilit')){
            $this->updateMetroPrice($ID,'price_ambilit', $request->input('price_ambilit'), $request->input('number_of_face_ambilit'), $request->input('dimension_ambilit'), $request->input('price_ambilit'), $request->input('printing_price_ambilit'), $request->input('total_price_ambilit'));
        }
      
       

        //return to metro product list
       return redirect()->route('dashboard.getMetroList')->with('message', 'Successfully Edited!');
    }

    public function updateMetroPrice($id,$price_key, $unit, $facenumber, $dimension, $baseprice, $printingcharge, $totalprice){
        $count = Metrosprice::where([
                                    ['metros_id', '=', $id],
                                    ['price_key', '=', $price_key],
                                ])->count();
        if($count < 1){
            $this->addMetroPrice($id,$price_key, $unit, $facenumber, $dimension, $baseprice, $printingcharge, $totalprice);
        }else{
            $update = Metrosprice::where([
                                    ['metros_id', '=', $id],
                                    ['price_key', '=', $price_key],
                                ])->update(['price_key' => $price_key,
                                            'unit' => $unit,
                                            'number_face' => $facenumber,
                                            'dimension' => $dimension,
                                            'base_price' => $baseprice,
                                            'printing_charge' => $printingcharge,
                                            'totalvalue' => $totalprice
                                            ]);
        }
        
   }

   //Fliter Functions
   public function getFilterMetroAds(Request $request){
       $metroPrice = new Metrosprice();
        
        $filterResults = $metroPrice->FilterMetrosAds($request->all());

        if(count($filterResults)>0){
            foreach($filterResults as $searchMetro){
                $this->metro_ads($searchMetro, $request->all());
            }

        }else{
            echo "<img src='../images/oops.jpg' class='img-responsive oops-img'>";
           
        }

        $content = ob_get_contents();
        ob_get_clean();
        return $content;
       
       
   }
   public function metro_ads($searchMetro, $fileroptions)
   { 
         ?>
       
       <div class="col-md-3 col-sm-3 "> 
        <div class="pro-item"> 
            <div class=" cat-opt-img "> <img src="<?= asset('images/metros/'.$searchMetro->metro->image) ?>"> </div>
            <p class="font-1"><?= $searchMetro->metro->title ?></p>
            <p class="font-2"><?= $searchMetro->metro->location ?>, <?= $searchMetro->metro->city ?>, <?= $searchMetro->metro->state ?></p>
            <div class="row">
                <div class="col-md-6">
                    <p class="font-3"><?= $searchMetro->time_band_value ?> <?= ucwords(substr(str_replace('_', ' ', $searchMetro->price_key), 6))?> <br>for <br> 1 months</p>
                    </div>
                <div class="col-md-6">
                        <p class="font-4"><del class="lighter">Rs <?= $searchMetro->totalprice?> </del><br>Rs <?= $searchMetro->totalprice?> </p>
                </div>
            
            </div>

            <?php
            $options = $searchMetro->totalprice.'+'.$searchMetro->price_key;
            $session_key = 'metros'.'_'.$searchMetro->price_key.'_'.$searchMetro->metro->id;
            $printsession = (array) Session::get('cart');
                            
           ?>
            <div class="clearfix"> 
                <button class="glass add-cartButton" data-href="<?= route('metro.addtocartAfterSearch', ['id' => $searchMetro->metro->id, 'variation' => $options, 'fileroption' => http_build_query($fileroptions)]) ?>"><span class="fa fa-star"></span>
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
        $metro_ad = Metros::where('id', $id)->first()->toArray();
       
        $metroPrice = new Metrosprice();

        $metro_price = $metroPrice->getMetrosPriceCart($id, $variation);

        
        $metro_Ad = array_merge($metro_ad, $metro_price);
       
        $oldCart = Session::has('cart') ? Session::get('cart') : null;
                
        $cart = new Cart($oldCart);

        $status = $cart->addorRemoveMetro($metro_Ad, $metro_ad['id'], 'metros'); //pass full metro details, id and model name like "metros"
        
        $request->session()->put('cart', $cart);
        //Session::forget('cart');

        return redirect()->back()->with(['status' => $status]);
    }

 
}
