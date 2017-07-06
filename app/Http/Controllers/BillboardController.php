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
    protected  $billboard_options;
    protected $ad_status;
    public function __construct()
    {
        $this->middleware('admin', ['only' => ['getDashboardBillboardList', 'getDashboardBillboardForm', 'postDashboardBillboardForm', 'addBillboardPrice', 'getDeleteBillboardad', 'getUpdateeBillboardad', 'getuncheckBillboardadOptions']]);
        $this->billboard_options = array(
                                'unipole' => 'Unipole',
                                'hoarding' => 'Hoarding',
                                'pole_kiosk' => 'Pole Kiosk',
                                'i_walker' => 'I Walker',
                                'billboard' => 'Billboard',
                                'dhalao' => 'Dhalao',
                                'front_lit_wall' => 'Front lit wall',
                                'front_lit_bridge_panel' => 'Front lit bridge panel',
                                'front_lit' => 'Front lit'
                            );
        $this->ad_status = array( 'available' => 'Available', 'booked' => 'Booked', 'completed' => 'Completed', 'queried'=> 'Queried', 'comming soon' => 'Comming Soon', 'sold out' => 'Sold Out' );
    }

     //frontend function starts
    
    public function getfrontendAllBillboardads()
    {
        $location = 'Delhi NCR';
        $media_type = new Mainaddtype();
        $ad_cats = $media_type->mediatype('Outdoor Advertising');
        $location_filter = Billboards::select('location')->distinct()->get();
        $distinctType = Billboards::select('category_type')->distinct()->get();
        if($distinctType->isEmpty()){
			return view('partials.comingsoon');
		}
        $billboardOptions = array();
		foreach($distinctType as $value){
			$billboardOptions[$value->category_type] = $value->category_type;
		}
       
        return view('frontend-mediatype.outdooradvertisings.outdooradvertisingads-list', ['billboard_options' => $billboardOptions, 'location' => $location, 'mediacat' => $ad_cats,'filter_location'=>$location_filter]);
    }


    public function getfrontBillboardadByOption(Request $request,$billboardOption)
    {
          
        $billboards = Billboards::where('category_type', $billboardOption)->paginate(12);
        if ($request->ajax()) {
    		$view = view('frontend-mediatype.outdooradvertisings.billboarddata',compact('billboards', 'billboardOption'))->render();
            return response()->json(['html'=>$view]);
        }
       
        return view('frontend-mediatype.outdooradvertisings.outdooradvertising-single',compact('billboards', 'billboardOption'));
    }
   
    //dashboard functions end

    // get list of all the products in billboard  media type
    public function getDashboardBillboardList()
    {
        $billboard_ads = Billboards::all();
        return view('backend.mediatypes.outdooradvertisings.outdooradvertising-list', ['billboard_ads' => $billboard_ads]);
    }
    
     // get form of Billboard media type
    public function getDashboardBillboardForm()
    {
        return view('backend.mediatypes.outdooradvertisings.outdooradvertising-addform', ['billboard_options' => $this->billboard_options, 'ad_status' => $this->ad_status]);
    }


    // post list of all the products in billboard media type

    public function postDashboardBillboardForm(Request $request)
    {
        $this->validate( $request, [
           'title' => 'required',
           'category_type' => 'required',
           'width' => 'numeric|required',
           'height' => 'numeric|required',
           'area' => 'numeric|required',
           'image' => 'required|image',
           'location' => 'required',
           'state' => 'required',
           'city' => 'required',
           'rank' => 'numeric',
           'description' => 'required',
           'status' => 'required',
           'ad_code' => 'required',
           'price' => 'numeric|required',
           'discount_price' => 'numeric|required',
        ]);

        if($request->hasFile('image')){
            $file = $request->file('image');
            $filename = time() .'.'. $file->getClientOriginalExtension();
            $location = public_path("images\outdooradvertising\\" . $filename);
            Image::make($file)->resize(800, 400)->save($location);
        }

        $billboard = new Billboards([
                'title' => $request->input('title'),
                'category_type' => $request->input('category_type'),
                'width' => $request->input('width'),
                'height' => $request->input('height'),
                'area' => $request->input('area'),
                'image' => $filename,
                'location' => $request->input('location'),
                'state' =>  $request->input('state'),
                'city' => $request->input('city'),
                'rank' => $request->input('rank'),
                'landmark' => $request->input('landmark'),
                'description' => $request->input('description'),
                'references' => $request->input('reference'),
                'status' => $request->input('status'),
                'light_option' => $request->input('billboardlighting'),
                'price' => $request->input('price'),
                'discount_price' => $request->input('discount_price'),
                'reference_mail' => $request->input('reference_mail'),
                'ad_code' => $request->input('ad_code')
        ]);
        $billboard->slug = $billboard->getUniqueSlug($request->input('title'));
        $billboard->save();

        $lastinsert_ID = $billboard->id;
        //return to billboard product list
       return redirect()->route('dashboard.getBillboardList')->with('message', 'Successfully Added!');
    }

    // delete billboard product and price form db tables

    public function getDeleteBillboardad($billboardadID)
    {
        $delele_billboardad = Billboards::where('id', $billboardadID)->first();
        $delele_billboardad->delete();
        return redirect()->route('dashboard.getBillboardList')->with(['message' => "Successfully Deleted From the List!"]);
    }

    // update billboard product
    public function getUpdateeBillboardad($ID)
    {
        $billboardData = Billboards::find($ID);
        return view('backend.mediatypes.outdooradvertisings.outdooradvertising-editform', ['billboard' => $billboardData, 'billboard_options' => $this->billboard_options, 'ad_status' => $this->ad_status]);
    }
   

    public function postUpdateeBillboardad(Request $request, $ID)
    {
        $this->validate( $request, [
           'title' => 'required',
           'category_type' => 'required',
           'width' => 'numeric|required',
           'height' => 'numeric|required',
           'area' => 'numeric|required',
           //'image' => 'required|image',
           'location' => 'required',
           'state' => 'required',
           'city' => 'required',
           'rank' => 'numeric',
           'description' => 'required',
           'status' => 'required',
           'ad_code' => 'required',
           'price' => 'numeric|required',
           'discount_price' => 'numeric|required',
        ]);

        $editbillboard = Billboards::find($ID);

        $editbillboard->title = $request->input('title');
        $editbillboard->width = $request->input('width');
        $editbillboard->height = $request->input('height');
        $editbillboard->area = $request->input('area');
        $editbillboard->location = $request->input('location');
        $editbillboard->state = $request->input('state');
        $editbillboard->city = $request->input('city');
        $editbillboard->rank = $request->input('rank');
        $editbillboard->landmark = $request->input('landmark');
        $editbillboard->description = $request->input('description');
        $editbillboard->status = $request->input('status');
        $editbillboard->references = $request->input('reference');
        $editbillboard->light_option = $request->input('billboardlighting');
        $editbillboard->discount_price = $request->input('discount_price');
        $editbillboard->price = $request->input('price');
        $editbillboard->reference_mail = $request->input('reference_mail');
        $editbillboard->ad_code = $request->input('ad_code');

        if($request->hasFile('image')){
            $file = $request->file('image');
            $filename = time() .'.'. $file->getClientOriginalExtension();
            $location = public_path("images\outdooradvertising\\" . $filename);
            Image::make($file)->resize(800, 400)->save($location);
            $oldimage = $editbillboard->image;
            $editbillboard->image = $filename;
        }

       $editbillboard->update();
        //return to billboard product list
       return redirect()->route('dashboard.getBillboardList')->with('message', 'Successfully Edited!');
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
   public function getAddToCart(Request $request, $id)
   {
        $billboard_ad = Billboards::where('id', $id)->first()->toArray();
               
        $oldCart = Session::has('cart') ? Session::get('cart') : null;
                
        $cart = new Cart($oldCart);

        $status = $cart->addorRemoveOutdoorAdvertising($billboard_ad, $billboard_ad['id'], 'outdooradvertising'); //pass full billboard details, id and model name like "billboards"
        
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

