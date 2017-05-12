<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Http\Requests;
use Session;
use App\Billboards;
use App\Billboardsprice;
use App\Mainaddtype;
use Image;
use App\Product;
use Illuminate\Support\Facades\File;
use App\Cart;
use App\Order;


class BillboardController extends Controller
{

    public function __construct()
    {
        $this->middleware('admin', ['only' => ['getDashboardBillboardList', 'getDashboardBillboardForm', 'postDashboardBillboardForm', 'addBillboardPrice', 'getDeleteBillboardad', 'getUpdateeBillboardad', 'getuncheckBillboardadOptions']]);
    }

     //frontend function starts
    
    public function getfrontendAllBillboardads()
    {
        $billboard_options = array(
                                'unipole' => 'Unipole',
                                'hoarding' => 'Hoarding',
                                'pole_kiosk' => 'Pole Kiosk',
                                'i_walker' => 'I Walker'
                            );

        $location = 'Delhi NCR';
        $media_type = new Mainaddtype();
        $ad_cats = $media_type->mediatype('Outdoor Advertising');

       return view('frontend-mediatype.outdooradvertisings.outdooradvertisingads-list', ['billboard_options' => $billboard_options, 'location' => $location, 'mediacat' => $ad_cats]);
    }


    public function getfrontBillboardadByOption($billboardOption)
    {
          
        $billboards = new Billboardsprice();

        $billboards = $billboards->getBillboardByFilter($billboardOption);
        
        return view('frontend-mediatype.outdooradvertisings.outdooradvertising-single', ['billboards' => $billboards, 'billboardOption' => $billboardOption]);
    }
    
    // public function getfrontBillboardad($id)
    // {
    //     $billboardad = Billboards::find($id);
    //     if($billboardad){
    //         if($billboardad->status === "3" || $billboardad->status === "2"){
    //             return redirect()->back();
    //         }else{
    //             $billboardprice = Billboardsprice::where('billboards_id', $id)->get();
    //             return view('frontend-mediatype.outdooradvertisings.outdooradvertising-single', ['billboardad' => $billboardad, 'billboardprice' => $billboardprice]);
    //         }
    //     }else{
    //         return redirect()->back();
    //     }
        
    //  }
    // frontend functions ends
    
    //Backend functions below


    // get list of all the products in billboard  media type
     public function getDashboardBillboardList(){
        $billboard_ads = Billboards::all();
        return view('backend.mediatypes.outdooradvertisings.outdooradvertising-list', ['billboard_ads' => $billboard_ads]);
    }
    
     // get form of Billboard media type
    public function getDashboardBillboardForm()
    {
        return view('backend.mediatypes.outdooradvertisings.outdooradvertising-addform');
    }


    // post list of all the products in billboard media type

    public function postDashboardBillboardForm(Request $request)
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
           'status' => 'required'
        ]);

        if($request->hasFile('image')){
            $file = $request->file('image');
            $filename = time() .'.'. $file->getClientOriginalExtension();
            $location = public_path("images\outdooradvertising\\" . $filename);
            Image::make($file)->resize(800, 400)->save($location);
        }

        $billboard = new Billboards([
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
                'display_options' => serialize($request->input('billboarddisplay')),
                'light_option' => $request->input('billboardlighting'),
                'discount' => $request->input('billboarddiscount'),
                'billboardnumber' => $request->input('billboardsnumber')
        ]);

        $billboard->save();

        $lastinsert_ID = $billboard->id;


        //billboard display prices insertion
       if($request->has('price_unipole')){
            $this->addBillboardPrice($lastinsert_ID, 'price_unipole', $request->input('price_unipole') , 'number_unipole', $request->input('number_unipole'), 'duration_unipole', $request->input('duration_unipole')) ;
        }
      
      

       if($request->has('price_hoarding')){
            $this->addBillboardPrice($lastinsert_ID, 'price_hoarding', $request->input('price_hoarding') , 'number_hoarding', $request->input('number_hoarding') , 'duration_hoarding', $request->input('duration_hoarding'));
        }
      
       

        if($request->has('price_pole_kiosk')){
            $this->addBillboardPrice($lastinsert_ID, 'price_pole_kiosk', $request->input('price_pole_kiosk'), 'number_pole_kiosk', $request->input('number_pole_kiosk'), 'duration_pole_kiosk', $request->input('duration_pole_kiosk'));
        }
        

        if($request->has('price_i_walker')){
            $this->addBillboardPrice($lastinsert_ID, 'price_i_walker', $request->input('price_i_walker'), 'number_i_walker', $request->input('number_i_walker'), 'duration_i_walker', $request->input('duration_i_walker'));
        }
        
      
        //return to billboard product list
       return redirect()->route('dashboard.getBillboardList')->with('message', 'Successfully Added!');
    }

    //insert price data to billboard price table
    public function addBillboardPrice($id, $pricekey, $pricevalue, $numkey, $numvalue, $durkey, $durvalue)
    {
        $insert = new Billboardsprice();

        $insert->billboards_id = $id;
        $insert->price_key = $pricekey;
        $insert->price_value = $pricevalue;
        $insert->number_key = $numkey;
        $insert->number_value = $numvalue;
        $insert->duration_key = $durkey;
        $insert->duration_value = $durvalue;
       
        $insert->save();

    }

    // delete billboard product and price form db tables

    public function getDeleteBillboardad($billboardadID)
    {
        $delele_billboardad = Billboards::where('id', $billboardadID)->first();
        $delele_billboardad->delete();
        $delete_billboardadprice = Billboardsprice::where('billboards_id', $billboardadID);
        $delete_billboardadprice->delete();
      
        return redirect()->route('dashboard.getBillboardList')->with(['message' => "Successfully Deleted From the List!"]);
    }

    // update billboard product
    public function getUpdateeBillboardad($ID)
    {
        $billboardData = Billboards::find($ID);
        $billboardpriceData = Billboardsprice::where('billboards_id', $ID)->get();
        $fieldData = array();
        foreach($billboardpriceData as $pricebillboard){
           $fieldData[] = ucwords(str_replace('_', ' ', substr($pricebillboard->price_key, 6)));
        }
        
       $fieldDatas = serialize($fieldData);
       
        return view('backend.mediatypes.outdooradvertisings.outdooradvertising-editform', ['billboard' => $billboardData, 'billboardpricemeta' => $billboardpriceData, 'fieldData' => $fieldDatas]);
    }
    //check and uncheck options remove
    public function getuncheckBillboardadOptions(Request $request)
    {
        $displayoptions = json_decode($request['displayoptions']);
        $datta = array();
        foreach($displayoptions as $options){
            $datta[] = strtolower(str_replace(' ', '_', $options));
        
        }
        
        $count = Billboardsprice::where([
                                    ['billboards_id', '=', $request['id']],
                                    ['price_key', '=', $request['price_key']],
                                ])->count();
        if($count > 0){
            Billboards::where('id', $request['id'])->update(['display_options' => serialize($datta)]);
            $billboards = Billboardsprice::where([
                                    ['billboards_id', '=', $request['id']],
                                    ['price_key', '=', $request['price_key']],
                                ])->first();
            $billboards->delete();
            
            return response(['msg' => 'price deleted'], 200);
        }else{
            return response(['msg' => 'Value not present in db!'], 200);
        }
    }

    public function postUpdateeBillboardad(Request $request, $ID)
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

        $editbillboard = Billboards::find($ID);

         $editbillboard->title = $request->input('title');
         $editbillboard->price = $request->input('price');
         $editbillboard->location = $request->input('location');
         $editbillboard->state = $request->input('state');
         $editbillboard->city = $request->input('city');
         $editbillboard->rank = $request->input('rank');
         $editbillboard->description = $request->input('description');
         $editbillboard->status = $request->input('status');
         $editbillboard->references = $request->input('reference');
         $editbillboard->display_options = serialize($request->input('billboarddisplay'));
          $editbillboard->light_option = $request->input('billboardlighting');
          $editbillboard->billboardnumber = $request->input('billboardsnumber');
          $editbillboard->discount = $request->input('billboarddiscount');

        if($request->hasFile('image')){
            $file = $request->file('image');
            $filename = time() .'.'. $file->getClientOriginalExtension();
            $location = public_path("images\outdooradvertising\\" . $filename);
            Image::make($file)->resize(800, 400)->save($location);
            $oldimage = $editbillboard->image;
            $editbillboard->image = $filename;
        }

       $editbillboard->update();

        //billboard display prices insertion

        if($request->has('price_unipole')){
            $this->updateBillboardPrice($ID, 'price_unipole', $request->input('price_unipole'), 'number_unipole', $request->input('number_unipole'), 'duration_unipole', $request->input('duration_unipole'));
        }
      
     
       if($request->has('price_hoarding')){
            $this->updateBillboardPrice($ID, 'price_hoarding', $request->input('price_hoarding'), 'number_hoarding', $request->input('number_hoarding'), 'duration_hoarding', $request->input('duration_hoarding'));
        }
      

        if($request->has('price_pole_kiosk')){
            $this->updateBillboardPrice($ID, 'price_pole_kiosk', $request->input('price_pole_kiosk'), 'number_pole_kiosk', $request->input('number_pole_kiosk'), 'duration_pole_kiosk', $request->input('duration_pole_kiosk'));
        }

        if($request->has('price_i_walker')){
            $this->updateBillboardPrice($ID, 'price_i_walker', $request->input('price_i_walker'), 'number_i_walker', $request->input('number_i_walker'), 'duration_i_walker', $request->input('duration_i_walker'));
        }

        //return to billboard product list
       return redirect()->route('dashboard.getBillboardList')->with('message', 'Successfully Edited!');
    }

    public function updateBillboardPrice( $id, $pricekey, $pricevalue, $numkey, $numvalue, $durkey, $durvalue){
        $count = Billboardsprice::where([
                                    ['billboards_id', '=', $id],
                                    ['price_key', '=', $pricekey],
                                ])->count();
        if($count < 1){
            $this->addBillboardPrice($id, $pricekey, $pricevalue, $numkey, $numvalue, $durkey, $durvalue);
        }else{
            $update = Billboardsprice::where([
                                    ['billboards_id', '=', $id],
                                    ['price_key', '=', $pricekey],
                                ])->update(['price_value' => $pricevalue, 'number_value' => $numvalue, 'duration_value' => $durvalue]);
        }
        
   }

   //Fliter Functions
   public function getFilterBillboardAds(Request $request){
        
        $billboardPrice = new Billboardsprice();
        $filterResults = $billboardPrice->FilterBillboardsAds($request->all());
        if(count($filterResults)>0){
            foreach($filterResults as $searchBillboard){
                $this->billboard_ads($searchBillboard, $request->all());
            }

        }else{
            echo "<img src='../images/oops.jpg' class='img-responsive oops-img'>";
        }

        $content = ob_get_contents();
        ob_get_clean();
        return $content;
  
   }
    public function billboard_ads($searchBillboard, $fileroptions)
   { 
         ?>
       
       <div class="col-md-3 col-sm-3 "> 
        <div class="pro-item"> 
            <div class=" cat-opt-img "> <img src="<?= asset('images/outdooradvertising/'.$searchBillboard->billboard->image) ?>"> </div>
            <p class="font-1"><?= $searchBillboard->billboard->title ?></p>
            <p class="font-2"><?= $searchBillboard->billboard->location ?>, <?= $searchBillboard->billboard->city ?>, <?= $searchBillboard->billboard->state ?></p>
            <div class="row">
                <div class="col-md-6">
                    <p class="font-3"><?= $searchBillboard->number_value ?> <?= ucwords(substr(str_replace('_', ' ', $searchBillboard->price_key), 6))?> <br>for <br> <?= $searchBillboard->duration_value?> months</p>
                    </div>
                <div class="col-md-6">
                        <p class="font-4"><del class="lighter">Rs <?= $searchBillboard->price_value?> </del><br>Rs <?= $searchBillboard->price_value?> </p>
                </div>
            
            </div>

            <?php
            $options = $searchBillboard->price_value.'+'.$searchBillboard->price_key;
            $session_key = 'billboards'.'_'.$searchBillboard->price_key.'_'.$searchBillboard->billboard->id;
            $printsession = (array) Session::get('cart');
                            
           ?>
            <div class="clearfix"> 
                <button class="glass add-cartButton" data-href="<?= route('billboard.addtocartAfterSearch', ['id' => $searchBillboard->billboard->id, 'variation' => $options, 'fileroption' => http_build_query($fileroptions)]) ?>"><span class="fa fa-star"></span>
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
   // add or remove item to billboardt
   public function getAddToCart(Request $request, $id, $variation)
   {
        $billboard_ad = Billboards::where('id', $id)->first()->toArray();

        $billboardPrice = new Billboardsprice();
        $billboard_price = $billboardPrice->getBillboardspriceCart($id, $variation);
               
        $billboard_Ad = array_merge($billboard_ad, $billboard_price);
        
        $oldCart = Session::has('cart') ? Session::get('cart') : null;
                
        $cart = new Cart($oldCart);

        $status = $cart->addorRemove($billboard_Ad, $billboard_ad['id'], 'billboards', $flag=true); //pass full billboard details, id and model name like "billboards"
        
        $request->session()->put('cart', $cart);
        //Session::forget('cart');

        return redirect()->back()->with(['status' => $status]);
    }

    // Search Option

    public function getAddToCartBySearch(Request $request, $id, $variation, $fileroption)
    {
        $billboard_ad = Billboards::where('id', $id)->first()->toArray();
        
        $billboardPrice = new Billboardsprice();
        $billboard_price = $billboardPrice->getBillboardspriceCart($id, $variation);
       
        $billboard_Ad = array_merge($billboard_ad, $billboard_price);
       
        $oldCart = Session::has('cart') ? Session::get('cart') : null;
                
        $cart = new Cart($oldCart);

        $status = $cart->addorRemove($billboard_Ad, $billboard_ad['id'], 'billboards', $flag=true); //pass full billboard details, id and model name like "billboards"
        
        $request->session()->put('cart', $cart);
        //Session::forget('cart');

        return response(['status' => $status, 'quatity' => $cart->totalQty, 'total' => $cart->totalPrice], 200);
    }

 
}

