<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use Session;
use App\Cinemas;
use App\Cinemasprice;
use App\Mainaddtype;
use Image;
use App\Product;
use Illuminate\Support\Facades\File;
use App\Cart;
use App\Order;


class CinemaController extends Controller
{
    protected $additionlsAds;
    protected $cinema_options;
    protected $cinema_category;
    public function __construct()
    {
        $this->middleware('admin', ['only' => ['getDashboardCinemaList', 'getDashboardCinemaForm', 'postDashboardCinemaForm', 'addCinemaPrice', 'getDeleteCinemaad', 'getUpdateeCinemaad', 'getuncheckCinemaadOptions']]);
        $this->cinema_options = array('video_ad' => 'Video Ad', 'trailor_ad' => 'Trailor Ad', 'mute_slide_ad' => 'Mute Slide Ad');
        $this->cinema_category = array('gold' => 'Gold', 'platinum' => 'Platinum', 'silver' => 'Silver'); 
        $this->additionlsAds = array(
                                    'ticket_jackets' => 'Ticket Jackets',
                                    'seat_branding' => 'Seat Branding',
                                    'audi_door_branding' => 'Audi Door Branding',
                                    'popcorn_tub_branding' => 'Popcorn Tub Branding',
                                    'coffee_tree_branding' => 'Coffee Tree Branding',
                                    'washroom_branding' => 'Washroom Branding',
                                    'women_frisking_cell' => 'Women Frisking Cell'
                                );
    }
    //frontend function starts
    
    public function getfrontendAllCinemaads()
    {
       $cinema_ads = Cinemas::all();
       if(count($cinema_ads) <= 0){
            return view('partials.comingsoon');
       }
       $mediatypes = new Mainaddtype();
       $ad_cats = $mediatypes->mediatype('Cinemas');
       $location_filter = Cinemas::select('location')->distinct()->get();

       return view('frontend-mediatype.cinemas.cinemaads-list', ['products' => $cinema_ads,'mediacat' => $ad_cats, 'filter_location'=>$location_filter]);
    }
    
    public function getfrontCinemaad($slug)
    {
        $cinema = new Cinemas();
        $id = $cinema->getIDFromSlug($slug);
        $generalCinemaoptions = Cinemasprice::where([
                                    ['cinemas_id', '=', $id],
                                    ['option_type', '=', 'general'],
                                ])->get();

        $additionalCinemaoptions = Cinemasprice::where([
                                    ['cinemas_id', '=', $id],
                                    ['option_type', '=', 'additional'],
                                ])->get();
       $location_filter = Cinemas::select('location')->distinct()->get();


        return view('frontend-mediatype.cinemas.cinema-single', ['generalCinemaads' => $generalCinemaoptions, 'additionalCinemaads' => $additionalCinemaoptions,'filter_location'=>$location_filter]);
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
        return view('backend.mediatypes.cinemas.cinema-addform', ['cinema_options' =>  $this->cinema_options,
                         'cinema_category'=> $this->cinema_category,
                         'additionlsAds' => $this->additionlsAds]
                         );
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
                'additional_adsoption'=> serialize($request->input('additionalsAds')),
                'discount' => $request->input('cinemadiscount'),
                'cinemanumber' => $request->input('cinemasnumber'),
                'audiseats' => $request->input('audiseats'),
                'audinumber' => $request->input('audinumber'),
                'cinemacategory' => $request->input('cinemacategory'),
                'reference_mail' => $request->input('reference_mail')
        ]);

        $cinema->slug = $cinema->getUniqueSlug($request->input('title'));

        $cinema->save();

        $lastinsert_ID = $cinema->id;


        //cinema display prices insertion
      
       if($request->has('price_video_ad')){
            $this->addCinemaPrice($lastinsert_ID, 'price_video_ad', $request->input('price_video_ad'), 'duration_video_ad', $request->input('duration_video_ad'), 'general');
        }      

       if($request->has('price_trailor_ad')){
            $this->addCinemaPrice($lastinsert_ID, 'price_trailor_ad', $request->input('price_trailor_ad'), 'duration_trailor_ad', $request->input('duration_trailor_ad'), 'general');
        } 
       
        if($request->has('price_mute_slide_ad')){
            $this->addCinemaPrice($lastinsert_ID, 'price_mute_slide_ad', $request->input('price_mute_slide_ad'), 'duration_mute_slide_ad', $request->input('duration_mute_slide_ad'), 'general');
        }
       
        if($request->has('price_ticket_jackets')){
            $this->addCinemaPrice($lastinsert_ID, 'price_ticket_jackets', $request->input('price_ticket_jackets'), 'duration_ticket_jackets', $request->input('duration_ticket_jackets'), 'additional');
        }

        if($request->has('price_seat_branding')){
            $this->addCinemaPrice($lastinsert_ID, 'price_seat_branding', $request->input('price_seat_branding'), 'duration_seat_branding', $request->input('duration_seat_branding'), 'additional');
        }
        if($request->has('price_audi_door_branding')){
            $this->addCinemaPrice($lastinsert_ID, 'price_audi_door_branding', $request->input('price_audi_door_branding'), 'duration_audi_door_branding', $request->input('duration_audi_door_branding'), 'additional');
        }
        if($request->has('price_popcorn_tub_branding')){
            $this->addCinemaPrice($lastinsert_ID, 'price_popcorn_tub_branding', $request->input('price_popcorn_tub_branding'), 'duration_popcorn_tub_branding', $request->input('duration_popcorn_tub_branding'), 'additional');
        }
        if($request->has('price_coffee_tree_branding')){
            $this->addCinemaPrice($lastinsert_ID, 'price_coffee_tree_branding', $request->input('price_coffee_tree_branding'), 'duration_coffee_tree_branding', $request->input('duration_coffee_tree_branding'), 'additional');
        }
        if($request->has('price_washroom_branding')){
            $this->addCinemaPrice($lastinsert_ID, 'price_washroom_branding', $request->input('price_washroom_branding'), 'duration_washroom_branding', $request->input('duration_washroom_branding'), 'additional');
        }
        if($request->has('price_women_frisking_cell')){
            $this->addCinemaPrice($lastinsert_ID, 'price_women_frisking_cell', $request->input('price_women_frisking_cell'), 'duration_women_frisking_cell', $request->input('duration_women_frisking_cell'), 'additional');
        }

       
        //return to cinema product list
       return redirect()->route('dashboard.getCinemaList')->with('message', 'Successfully Added!');
    }

    //insert price data to cinema price table
    public function addCinemaPrice($id, $pricekey, $pricevalue, $durkey, $durvalue, $optionType)
    {
        $insert = new Cinemasprice();

        $insert->cinemas_id = $id;
        $insert->price_key = $pricekey;
        $insert->price_value = $pricevalue;
        $insert->duration_key = $durkey;
        $insert->duration_value = $durvalue;
        $insert->option_type = $optionType;
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
    public function getUpdateeCinemaad($ID, Cinemasprice $cinemasprice)
    {
        $cinemaData = Cinemas::find($ID);
        $cinemapriceData = $cinemasprice->where('cinemas_id', $ID)->get();
        $fieldData = array();
        foreach($cinemapriceData as $pricecinema){
            $fieldData[] = ucwords(str_replace('_', ' ', substr($pricecinema->price_key, 6)));
        }

       $fieldDatas = serialize($fieldData);
        return view('backend.mediatypes.cinemas.cinema-editform', ['cinema_options' =>  $this->cinema_options,
                         'cinema_category'=> $this->cinema_category,
                         'additionlsAds' => $this->additionlsAds, 'cinema' => $cinemaData, 'fieldData' => $fieldDatas, 'generalOptions' => serialize($cinemasprice->getGeneralOptions($ID)), 'additionalOptions' => serialize($cinemasprice->getAdditionalOptions($ID))]);
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
            Cinemas::where('id', $request['id'])->update([$request['option'] => serialize($datta)]);
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
         $editcinema->additional_adsoption = serialize($request->input('additionalsAds'));
         $editcinema->cinemanumber = $request->input('cinemasnumber');
         $editcinema->discount = $request->input('cinemadiscount');
         $editcinema->audiseats = $request->input('audiseats');
         $editcinema->audinumber = $request->input('audinumber');
         $editcinema->cinemacategory = $request->input('cinemacategory');
         $editcinema->reference_mail = $request->input('reference_mail');
         $editcinema->slug = $editcinema->slug;
         
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

      
       if($request->has('price_video_ad')){
            $this->updateCinemaPrice($ID, 'price_video_ad', $request->input('price_video_ad'), 'duration_video_ad', $request->input('duration_video_ad'), 'general');
        }      

       if($request->has('price_trailor_ad')){
            $this->updateCinemaPrice($ID, 'price_trailor_ad', $request->input('price_trailor_ad'), 'duration_trailor_ad', $request->input('duration_trailor_ad'), 'general');
        } 
       
        if($request->has('price_mute_slide_ad')){
            $this->updateCinemaPrice($ID, 'price_mute_slide_ad', $request->input('price_mute_slide_ad'), 'duration_mute_slide_ad', $request->input('duration_mute_slide_ad'), 'general');
        }
       
        if($request->has('price_ticket_jackets')){
            $this->updateCinemaPrice($ID, 'price_ticket_jackets', $request->input('price_ticket_jackets'), 'duration_ticket_jackets', $request->input('duration_ticket_jackets'), 'additional');
        }

        if($request->has('price_seat_branding')){
            $this->updateCinemaPrice($ID, 'price_seat_branding', $request->input('price_seat_branding'), 'duration_seat_branding', $request->input('duration_seat_branding'), 'additional');
        }
        if($request->has('price_audi_door_branding')){
            $this->updateCinemaPrice($ID, 'price_audi_door_branding', $request->input('price_audi_door_branding'), 'duration_audi_door_branding', $request->input('duration_audi_door_branding'), 'additional');
        }
        if($request->has('price_popcorn_tub_branding')){
            $this->updateCinemaPrice($ID, 'price_popcorn_tub_branding', $request->input('price_popcorn_tub_branding'), 'duration_popcorn_tub_branding', $request->input('duration_popcorn_tub_branding'), 'additional');
        }
        if($request->has('price_coffee_tree_branding')){
            $this->updateCinemaPrice($ID, 'price_coffee_tree_branding', $request->input('price_coffee_tree_branding'), 'duration_coffee_tree_branding', $request->input('duration_coffee_tree_branding'), 'additional');
        }
        if($request->has('price_washroom_branding')){
            $this->updateCinemaPrice($ID, 'price_washroom_branding', $request->input('price_washroom_branding'), 'duration_washroom_branding', $request->input('duration_washroom_branding'), 'additional');
        }
        if($request->has('price_women_frisking_cell')){
            $this->updateCinemaPrice($ID, 'price_women_frisking_cell', $request->input('price_women_frisking_cell'), 'duration_women_frisking_cell', $request->input('duration_women_frisking_cell'), 'additional');
        }


        //return to cinema product list
       return redirect()->route('dashboard.getCinemaList')->with('message', 'Successfully Edited!');
    }

    public function updateCinemaPrice( $id, $pricekey, $pricevalue, $durkey, $durvalue, $optionType){
        $count = Cinemasprice::where([
                                    ['cinemas_id', '=', $id],
                                    ['price_key', '=', $pricekey],
                                ])->count();
        if($count < 1){
            $this->addCinemaPrice($id, $pricekey, $pricevalue, $durkey, $durvalue, $optionType);
        }else{
            $update = Cinemasprice::where([
                                    ['cinemas_id', '=', $id],
                                    ['price_key', '=', $pricekey],
                                ])->update(['price_value' => $pricevalue, 'duration_value' => $durvalue]);
        }
        
   }

   //Fliter Functions
   public function getFilterCinemaAds(Request $request){
       $cinemaPrice = new Cinemasprice();
        
        $filterResults = $cinemaPrice->FilterCinemasAds($request->all());

        if(count($filterResults)>0){
            foreach($filterResults as $searchCinema){
                $this->cinema_ads($searchCinema, $request->all());
            }

        }else{
            echo "<img src='../images/oops.jpg' class='img-responsive oops-img'>";
           
        }

        $content = ob_get_contents();
        ob_get_clean();
        return $content;
       
       
   }
   public function cinema_ads($searchCinema, $fileroptions)
   {
       ?>
       
       <div class="col-md-3 col-sm-3 "> 
        <div class="pro-item"> 
            <div class=" cat-opt-img "> <img src="<?= asset('images/cinemas/'.$searchCinema->cinema->image) ?>"> </div>
            <p class="font-1"><?= $searchCinema->cinema->title ?></p>
            <p class="font-2"><?= $searchCinema->cinema->location ?>, <?= $searchCinema->cinema->city ?>, <?= $searchCinema->cinema->state ?></p>
            <div class="row">
                <div class="col-md-6">
                    <p class="font-3"><?= $searchCinema->number_value ?> <?= ucwords(substr(str_replace('_', ' ', $searchCinema->price_key), 6))?> <br>for <br> <?= $searchCinema->duration_value?> months</p>
                    </div>
                <div class="col-md-6">
                        <p class="font-4"><del class="lighter">Rs <?= $searchCinema->price_value?> </del><br>Rs <?= $searchCinema->price_value?> </p>
                </div>
            
            </div>

            <?php
            $options = $searchCinema->price_value.'+'.$searchCinema->price_key;
            $session_key = 'cinemas'.'_'.$searchCinema->price_key.'_'.$searchCinema->cinema->id;
            $printsession = (array) Session::get('cart');
                            
           ?>
            <div class="clearfix"> 
                <button class="glass add-cartButton" data-href="<?= route('cinema.addtocartAfterSearch', ['id' => $searchCinema->cinema->id, 'variation' => $options, 'fileroption' => http_build_query($fileroptions)]) ?>"><span class="fa fa-star"></span>
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
       $cinema_ad = Cinemas::where('id', $id)->first()->toArray();
       
        $cinemaPrice = new Cinemasprice();

        $cinema_price = $cinemaPrice->getCinemasPriceCart($id, $variation);

        
        $cinema_Ad = array_merge($cinema_ad, $cinema_price);
       
        $oldCart = Session::has('cart') ? Session::get('cart') : null;
                
        $cart = new Cart($oldCart);

        $status = $cart->addorRemove($cinema_Ad, $cinema_ad['id'], 'cinemas', $flag=true); //pass full cinema details, id and model name like "cinemas"
        
        $request->session()->put('cart', $cart);
        //Session::forget('cart');

        return redirect()->back()->with(['status' => $status]);
    }

    public function getAddToCartBySearch(Request $request, $id, $variation, $fileroption)
    {
        $cinema_ad = Cinemas::where('id', $id)->first()->toArray();
        
        $cinemaPrice = new Cinemasprice();
        $cinema_price = $cinemaPrice->getCinemasPriceCart($id, $variation);
       
        $cinema_Ad = array_merge($cinema_ad, $cinema_price);
       
        $oldCart = Session::has('cart') ? Session::get('cart') : null;
                
        $cart = new Cart($oldCart);

        $status = $cart->addorRemove($cinema_Ad, $cinema_ad['id'], 'cinemaes', $flag=true); //pass full cinema details, id and model name like "cinemaes"
        
        $request->session()->put('cart', $cart);
        //Session::forget('cart');

        return response(['status' => $status, 'quatity' => $cart->totalQty, 'total' => $cart->totalPrice], 200);
    }

 
}
