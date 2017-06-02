<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use Session;
use App\Televisions;
use App\Mainaddtype;
use App\Televisionsprice;
use Image;
use App\Product;
use Illuminate\Support\Facades\File;
use App\Cart;
use App\Order;


class TelevisionController extends Controller
{
 
public function __construct()
    {
        $this->middleware('admin', ['only' => ['getDashboardTelevisionList', 'getDashboardTelevisionForm', 'postDashboardTelevisionForm', 'getDeleteTelevisionad', 'getUpdateeTelevisionad', 'postUpdateeTelevisionad']]);
    }

  //frontend function starts
    
    public function getfrontendAllTelevisionads()
    {

        $television_ads = Televisions::all();
        $media_type = new Mainaddtype();
        $ad_cats = $media_type->mediatype('Television');
        $location_filter = Televisions::select('location')->distinct()->get();

        return view('frontend-mediatype.televisions.televisionads-list', ['televisions_ads' => $television_ads, 'mediacat' => $ad_cats,'filter_location'=>$location_filter]);
    }

    public function getfrontTelevisionad($id)
    {
         $televisionpricead = Televisionsprice::where('television_id', $id)->get();
                    
        return view('frontend-mediatype.televisions.television-single', ['televisionads' => $televisionpricead]);
    
        
     }


    //Backend functions below

	// get list of all the products in television stop media type
	public function getDashboardTelevisionList()
	{
        $television_ads = Televisions::all();
        return view('backend.mediatypes.televisions.television-list', ['television_ads' => $television_ads]);
    }

    // get form of television stop media type
     public function getDashboardTelevisionForm()
    {
        return view('backend.mediatypes.televisions.television-addform');
    }

    // post list of all the products in television media type

    public function postDashboardTelevisionForm(Request $request)
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
           'genre' => 'required'
        ]);

        if($request->hasFile('image')){
            $file = $request->file('image');
            $filename = time() .'.'. $file->getClientOriginalExtension();
            $location = public_path("images\\televisions\\" . $filename);
            Image::make($file)->resize(800, 400)->save($location);
        }

        $television = new Televisions([
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
                'genre' => $request->input('genre'),
                'status' => $request->input('status'),
                'news_options' => serialize($request->input('newsdisplay')),
                //'display_options' => serialize($request->input('televisiondisplay')),
                'discount' => $request->input('discount'),
                'television_number' => $request->input('televisionsnumber'),
                 'reference_mail' => $request->input('reference_mail')
        ]);

        $television->save();

         $lastinsert_ID = $television->id;

        if($request->input('genre') == 'News'){
            if($request->has('rate_ticker')){
                $this->addTelevisionPrice($lastinsert_ID, 'rate_ticker', $request->input('rate_ticker'),'time_band_ticker', $request->input('time_band_ticker'),'exposure_ticker', $request->input('exposure_ticker'), 'News');
            }
            
         

            if($request->has('rate_aston')){
                $this->addTelevisionPrice($lastinsert_ID, 'rate_aston', $request->input('rate_aston'),'time_band_aston', $request->input('time_band_aston'),'exposure_aston', $request->input('exposure_aston'), 'News');
            }
            
          

            if($request->has('rate_time_check')){
                $this->addTelevisionPrice($lastinsert_ID, 'rate_time_check', $request->input('rate_time_check'),'time_band_time_check', $request->input('time_band_time_check'),'exposure_time_check', $request->input('exposure_time_check'), 'News');
            }
        
             if($request->has('rate_fct')){
                $this->addTelevisionPrice($lastinsert_ID, 'rate_fct', $request->input('rate_fct'),'time_band_fct', $request->input('time_band_fct'),'exposure_fct', $request->input('exposure_fct'), 'News');
            }
            
           
        }
       
        //return to television product list
       return redirect()->route('dashboard.getTelevisionList')->with('message', 'Successfully Added!');
    }

    //insert price data to television price table
    public function addTelevisionPrice($id, $ratekey, $ratevalue, $timekey, $timevalue, $exposurekey, $exposurevalue, $type)
    {
        $insert = new Televisionsprice();

        $insert->television_id = $id;
        $insert->time_band_key = $timekey;
        $insert->time_band_value = $timevalue;
        $insert->rate_key = $ratekey;
        $insert->rate_value = $ratevalue;
        $insert->exposure_key = $exposurekey;
        $insert->exposure_value = $exposurevalue;
        $insert->genre = $type;
       
        $insert->save();

    }

    // delete television product and price form db tables 

    public function getDeleteTelevisionad($televisionadID)
    {
        $delele_televisionad = Televisions::where('id', $televisionadID)->first();
        $delele_televisionad->delete();
         $delete_televisionadprice = Televisionsprice::where('television_id', $televisionadID);
        $delete_televisionadprice->delete();
        
       
        return redirect()->route('dashboard.getTelevisionList')->with(['message' => "Successfully Deleted From the List!"]);
    }

    // update television product
    public function getUpdateeTelevisionad($ID)
    {
        $televisionData = Televisions::find($ID);
        $televisionpriceData = Televisionsprice::where('television_id', $ID)->get();
        $fieldData = array();
        foreach($televisionpriceData as $pricetelevision){
           $fieldData[] = ucwords(str_replace('_', ' ', substr($pricetelevision->rate_key, 5)));
        }

        $fieldDatas = serialize($fieldData);
        return view('backend.mediatypes.televisions.television-editform', ['television' => $televisionData, 'televisionpricemeta' => $televisionpriceData,  'fieldData' => $fieldDatas]);

    }

    //check and uncheck options remove
    public function getuncheckTelevisionadOptions(Request $request)
    {
       
       $displayoptions = json_decode($request['displayoptions']);
       $datta = array();
        foreach($displayoptions as $options){
            $datta[] = strtolower(str_replace(' ', '_', $options));
        
        }
       
        $count = Televisionsprice::where([
                                    ['television_id', '=', $request['id']],
                                    ['rate_key', '=', $request['rate_key']],
                                ])->count();
        if($count > 0){
            Televisions::where('id', $request['id'])->update([$request['genre'] => serialize($datta)]);
            $televisions = Televisionsprice::where([
                                    ['television_id', '=', $request['id']],
                                    ['rate_key', '=', $request['rate_key']],
                                ])->first();
            $televisions->delete();
           
            return response(['msg' => 'price deleted'], 200);
        }
              
            return response(['msg' => 'Value not present in db!'], 200);
        
    }

    public function postUpdateeTelevisionad(Request $request, $ID)
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
           //'genre' => 'required'
        ]);

        $edittelevision = Televisions::find($ID);

         $edittelevision->title = $request->input('title');
         $edittelevision->price = $request->input('price');
         $edittelevision->location = $request->input('location');
         $edittelevision->state = $request->input('state');
         $edittelevision->city = $request->input('city');
         $edittelevision->rank = $request->input('rank');
         $edittelevision->landmark = $request->input('landmark');
         $edittelevision->description = $request->input('description');
         $edittelevision->status = $request->input('status');
         $edittelevision->news_options = serialize($request->input('newsdisplay'));
         $edittelevision->references = $request->input('reference');
         $edittelevision->genre = $request->input('genre');
         $edittelevision->discount = $request->input('discount');
         //$edittelevision->display_options = serialize($request->input('televisiondisplay'));
         $edittelevision->television_number = $request->input('televisionnumber');
         $edittelevision->reference_mail = $request->input('reference_mail');

         
        if($request->hasFile('image')){
            $file = $request->file('image');
            $filename = time() .'.'. $file->getClientOriginalExtension();
            $location = public_path("images\\televisions\\" . $filename);
            Image::make($file)->resize(800, 400)->save($location);
            $oldimage = $edittelevision->image;
            $edittelevision->image = $filename;
        }

       $edittelevision->update();

        //television display prices insertion

        if($edittelevision->genre == 'News'){
            if($request->has('rate_ticker')){
                $this->updateTelevisionPrice($ID, 'rate_ticker', $request->input('rate_ticker'),'time_band_ticker', $request->input('time_band_ticker'),'exposure_ticker', $request->input('exposure_ticker'), 'News');
            }
            
         

            if($request->has('rate_aston')){
                $this->updateTelevisionPrice($ID, 'rate_aston', $request->input('rate_aston'),'time_band_aston', $request->input('time_band_aston'),'exposure_aston', $request->input('exposure_aston'), 'News');
            }
            
          

            if($request->has('rate_time_check')){
                $this->updateTelevisionPrice($ID, 'rate_time_check', $request->input('rate_time_check'),'time_band_time_check', $request->input('time_band_time_check'),'exposure_time_check', $request->input('exposure_time_check'), 'News');
            }
        
             if($request->has('rate_fct')){
                $this->updateTelevisionPrice($ID, 'rate_fct', $request->input('rate_fct'),'time_band_fct', $request->input('time_band_fct'),'exposure_fct', $request->input('exposure_fct'), 'News');
            }
            
           
        }

        //return to television product list
       return redirect()->route('dashboard.getTelevisionList')->with('message', 'Successfully Edited!');
    }



 public function updateTelevisionPrice( $id, $ratekey, $ratevalue, $timekey, $timevalue, $exposurekey, $exposurevalue, $type){
        $count = Televisionsprice::where([
                                    ['television_id', '=', $id],
                                    ['rate_key', '=', $ratekey],
                                ])->count();
        if($count < 1){
            $this->addTelevisionPrice($id, $timekey, $timevalue, $ratekey, $ratevalue, $exposurekey, $exposurevalue, $type);
        }else{
            $update = Televisionsprice::where([
                                    ['television_id', '=', $id],
                                    ['rate_key', '=', $ratekey],
                                ])->update(['rate_value' => $ratevalue, 'time_band_value' => $timevalue, 'exposure_value' => $exposurevalue]);
        }
        
   }

    //Fliter Functions
   public function getFilterTelevisionAds(Request $request)
   {
        
        $televisionPrice = new Televisionsprice();
        
        $filterResults = $televisionPrice->FilterTelevisionsAds($request->all());

        if(count($filterResults)>0){
            foreach($filterResults as $searchTelevision){
                $this->television_ads($searchTelevision, $request->all());
            }

        }else{
            echo "<img src='../images/oops.jpg' class='img-responsive oops-img'>";
           
        }

        $content = ob_get_contents();
        ob_get_clean();
        return $content;
  
   }

   public function television_ads($searchTelevision, $fileroptions)
   { 
         ?>
       
       <div class="col-md-3 col-sm-3 "> 
        <div class="pro-item"> 
            <div class=" cat-opt-img "> <img src="<?= asset('images/televisions/'.$searchTelevision->television->image) ?>"> </div>
            <p class="font-1"><?= $searchTelevision->television->title ?></p>
            <p class="font-2"><?= $searchTelevision->television->location ?>, <?= $searchTelevision->television->city ?>, <?= $searchTelevision->television->state ?></p>
            <div class="row">
                <div class="col-md-6">
                    <p class="font-3"><?= $searchTelevision->time_band_value ?> <?= ucwords(substr(str_replace('_', ' ', $searchTelevision->rate_key), 5))?> <br>for <br> <?= $searchTelevision->exposure_value?> months</p>
                    </div>
                <div class="col-md-6">
                        <p class="font-4"><del class="lighter">Rs <?= $searchTelevision->rate_value?> </del><br>Rs <?= $searchTelevision->rate_value?> </p>
                </div>
            
            </div>

            <?php
            $options = $searchTelevision->rate_value.'+'.$searchTelevision->rate_key;
            $session_key = 'televisions'.'_'.$searchTelevision->rate_key.'_'.$searchTelevision->television->id;
            $printsession = (array) Session::get('cart');
                            
           ?>
            <div class="clearfix"> 
                <button class="glass add-cartButton" data-href="<?= route('television.addtocartAfterSearch', ['id' => $searchTelevision->television->id, 'variation' => $options, 'fileroption' => http_build_query($fileroptions)]) ?>"><span class="fa fa-star"></span>
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
        $flag= true;
        $television_ad = Televisions::where('id', $id)->first()->toArray();
       
        $televisionPrice = new Televisionsprice();

        $television_price = $televisionPrice->getTelevisionsPriceCart($id, $variation);

        
        $television_Ad = array_merge($television_ad, $television_price);
       
        $oldCart = Session::has('cart') ? Session::get('cart') : null;
                
        $cart = new Cart($oldCart);

        $status = $cart->addorRemoveTelevision($television_Ad, $television_ad['id'], 'televisions', $flag=true); //pass full television details, id and model name like "televisions"
        
        $request->session()->put('cart', $cart);
        //Session::forget('cart');

        return redirect()->back()->with(['status' => $status]);
    }

}