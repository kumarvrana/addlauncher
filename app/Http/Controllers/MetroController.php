<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use Session;
use App\Metros;
use App\Metrosprice;
use App\Mainaddtype;
use App\Metroline;
use Image;
use App\Product;
use Illuminate\Support\Facades\File;
use App\Cart;
use App\Order;


class MetroController extends Controller
{ 
    protected $metro_zone;
    protected $metro_options;
    protected $media;
    public function __construct()
    {
        $this->middleware('admin', ['only' => ['getDashboardMetroList', 'getDashboardMetroForm', 'postDashboardMetroForm', 'addMetroPrice', 'getDeleteMetroad', 'getUpdateeMetroad', 'getuncheckMetroadOptions']]);

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
        
        $search = \Request::get('search');
        $metro_ads = Metros::where('location', 'LIKE', '%'.$search.'%')->paginate(2);
        
        return view('backend.mediatypes.metros.metro-list', ['metro_ads' => $metro_ads]);
    }
    
    // get form of metro stop media type
     public function getDashboardMetroForm()
    {
        $metro_line = Metroline::all();
        
        return view('backend.mediatypes.metros.metro-addform', [
                                                                'metro_line' => $metro_line,
                                                                'metro_options' => $this->metro_options,
                                                                'media' => $this->media]);
    }

    // post list of all the products in metro media type

    public function postDashboardMetroForm(Request $request)
    {
        $regex = "/^(?=.+)(?:[1-9]\d*|0)?(?:\.\d+)?$/";
        $this->validate( $request, [
           'metroline_id' => 'required',
           'station_name' => 'required',
           'image' => 'required|image',
           'location' => 'required',
           'media' => 'required',
           'city' => 'required',
           'units' => 'required|numeric',
           'faces' => 'numeric',
           'width' => 'required|numeric',
           'height' => 'required|numeric',
           'area' => 'required|numeric',
           'description' => 'required',
           'status' => 'required',
           'ad_code' => 'required',
           'price' => array('required','regex:'.$regex),
           'discount_price' => array('required','regex:'.$regex)
        ]);

        if($request->hasFile('image')){
            $file = $request->file('image');
            $filename = time() .'.'. $file->getClientOriginalExtension();
            $location = public_path("images\metros\\" . $filename);
            Image::make($file)->resize(800, 400)->save($location);
        }

        $metro = new Metros([
                'metroline_id' => $request->input('metroline_id'),
                'station_name' => $request->input('station_name'),
                'media' => $request->input('media'),
                'price' => $request->input('price'),
                'image' => $filename,
                'location' => $request->input('location'),
                'city' => $request->input('city'),
                'units' => $request->input('units'),
                'faces' => $request->input('faces'),
                'width' => $request->input('width'),
                'height' => $request->input('height'),
                'area' => $request->input('area'),
                'discount_price' => $request->input('discount_price'),
                'description' => $request->input('description'),
                'references' => $request->input('reference'),
                'status' => $request->input('status'),
                'ad_code' => $request->input('ad_code'),
                'source' => $request->input('source'),
                'reference_mail' => $request->input('reference_mail')
        ]);

        $metro->save();
       
        //return to metro product list
       return redirect()->route('dashboard.getMetroList')->with('message', 'Successfully Added!');
    }

    
    // delete metro product and price form db tables

    public function getDeleteMetroad($metroadID)
    {
        $delele_metroad = Metros::where('id', $metroadID)->first();
        $delele_metroad->delete();

        return redirect()->route('dashboard.getMetroList')->with(['message' => "Successfully Deleted From the List!"]);
    }

    // update metro product
    public function getUpdateeMetroad($ID)
    {
        $metroData = Metros::find($ID);

        $metro_line = Metroline::all();

        return view('backend.mediatypes.metros.metro-editform', ['metro' => $metroData,'metro_line' => $metro_line]);
    }
   
    public function postUpdateeMetroad(Request $request, $ID)
    {
        $regex = "/^(?=.+)(?:[1-9]\d*|0)?(?:\.\d+)?$/";
        $this->validate( $request, [
           'metroline_id' => 'required',
           'station_name' => 'required',
           'price' => array('required','regex:'.$regex),
           'discount_price' => array('required','regex:'.$regex),
           'location' => 'required',
           'media' => 'required',
           'city' => 'required',
           'units' => 'required|numeric',
           'faces' => 'numeric',
           'width' => 'required|numeric',
           'height' => 'required|numeric',
           'area' => 'required|numeric',
           'description' => 'required',
           'status' => 'required',
           'ad_code' => 'required',
        ]);
        
        $editmetro = Metros::find($ID);

        $editmetro->metroline_id = $request->input('metroline_id');
        $editmetro->price = $request->input('price');
        $editmetro->discount_price = $request->input('discount_price');
        $editmetro->location = $request->input('location');
        $editmetro->city = $request->input('city');
        $editmetro->media = $request->input('media');
        $editmetro->units = $request->input('units');
        $editmetro->faces = $request->input('faces');
        $editmetro->width = $request->input('width');
        $editmetro->height = $request->input('height');
        $editmetro->area = $request->input('area');
        $editmetro->reference_mail = $request->input('reference_mail');
        $editmetro->description = $request->input('description');
        $editmetro->status = $request->input('status');
        $editmetro->references = $request->input('reference');
        $editmetro->source = $request->input('source');
        $editmetro->ad_code = $request->input('ad_code');
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

        //return to metro product list
        return redirect()->route('dashboard.getMetroList')->with('message', 'Successfully Edited!');
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
        return response('', 200);
       
       
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
       
        $oldCart = Session::has('cart') ? Session::get('cart') : null;
                
        $cart = new Cart($oldCart);

        $status = $cart->addorRemoveMetro($metro_ad, $metro_ad['id'], 'metros'); //pass full metro details, id and model name like "metros"
        
        $request->session()->put('cart', $cart);
        //Session::forget('cart');

        return redirect()->back()->with(['status' => $status]);
    }

    // Search Option

    public function getAddToCartBySearch(Request $request, $id, $variation, $fileroption)
    {
        $metro_ad = Metros::where('id', $id)->first()->toArray();
        
        $metroPrice = new Metrosprice();
        $metro_price = $metroPrice->getMetrospriceCart($id, $variation);
       
        $metro_Ad = array_merge($metro_ad, $metro_price);
       
        $oldCart = Session::has('cart') ? Session::get('cart') : null;
                
        $cart = new Cart($oldCart);

        $status = $cart->addorRemoveMetro($metro_Ad, $metro_ad['id'], 'metros', $flag=true); //pass full metro details, id and model name like "metros"
        
        $request->session()->put('cart', $cart);
        //Session::forget('cart');

        return response(['status' => $status, 'quatity' => $cart->totalQty, 'total' => $cart->totalPrice], 200);
    }

 
}
