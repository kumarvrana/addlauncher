<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Http\Requests;
use Session;
use App\Billboards;
use App\Billboardsprice;
use Image;
use App\Product;
use Illuminate\Support\Facades\File;
use App\Cart;
use App\Order;


class BillboardController extends Controller
{

     //frontend function starts
    
    public function getfrontendAllBillboardads()
    {
       $billboard_ads = Billboards::all();
       return view('frontend-mediatype.outdooradvertisings.outdooradvertisingads-list', ['products' => $billboard_ads]);
    }
    public function getfrontBillboardadByOption($billboardOption)
    {
       
        $billboard_ads = Billboards::all()->toArray();
       
        $billboardOption1 = '%'.$billboardOption.'%';
        $billboards = array();
        foreach($billboard_ads as $billboard){
            $count = Billboardsprice::where([
                                    ['billboards_id', '=', $billboard['id']],
                                    ['price_key', 'LIKE', $billboardOption1],
                                   ])->get(array('price_key', 'price_value'))->count();
            if($count > 0){
                 $billboardpriceOptions = Billboardsprice::where([
                                    ['billboards_id', '=', $billboard['id']],
                                    ['price_key', 'LIKE', $billboardOption1],
                                   ])->get(array('price_key', 'price_value'))->toArray();
                array_push($billboard, $billboardpriceOptions);
                $billboards[] = array_flatten($billboard);
            }
       }
       
        return view('frontend-mediatype.outdooradvertisings.outdooradvertising-single', ['products' => $billboards, 'billboardOption' => $billboardOption]); 
    }
    public function getfrontBillboardad($id)
    {
        $billboardad = Billboards::find($id);
        if($billboardad){
         if($billboardad->status === "3" || $billboardad->status === "2"){
         return redirect()->back();
         }else{   
        $billboardprice = Billboardsprice::where('billboards_id', $id)->get();
        return view('frontend-mediatype.outdooradvertisings.outdooradvertising-single', ['billboardad' => $billboardad, 'billboardprice' => $billboardprice]);
    }

    }else{
            return redirect()->back();
        }
    
    }
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
       $params = array_filter($request->all());
       foreach($params as $key=>$value){
            if($key == 'pricerange'){
                
                $filter_priceCamparsion = preg_replace('/[0-9]+/', '', $value); // comparion operator
                if($filter_priceCamparsion != '<>'){
                     $filter_price = preg_replace('/[^0-9]/', '', $value);
                     $billboardpriceOptions = Billboardsprice::where([
                                    ['price_key', 'LIKE', 'price_%'],                                    
                                    ['price_value', $filter_priceCamparsion, $filter_price],
                                    ])->get()->toArray();
                }else{
                     $filter_price = preg_replace('/[^0-9]/', '_', $value);
                     $filter_price = explode('_', $filter_price);
                    
                     $billboardpriceOptions = Billboardsprice::where([
                                    ['price_key', 'LIKE', 'price_%'],                                    
                                    ['price_value', '>=', $filter_price[0]],
                                    ['price_value', '<=', $filter_price[2]],
                                    ])->get()->toArray();   
                }
                if(count($billboardpriceOptions)>0){
                
                foreach($billboardpriceOptions as $key => $value){
                    $billboard_ads = Billboards::find($value['billboards_id'])->get()->toArray();
                    $filterLike = substr($value['price_key'], 6);
                    $billboardOption1 = '%'.$filterLike;
                    $billboards = array();
                    
                    $billboardpriceOptions = Billboardsprice::where([
                                ['billboards_id', '=', $value['billboards_id']],
                                ['price_key', 'LIKE', $billboardOption1],
                                //['price_value', $filter_priceCamparsion, $filter_price],
                                ])->get(array('price_key', 'price_value', 'number_key', 'number_value', 'duration_key', 'duration_value'))->toArray();
                        
                    array_push($billboard_ads, $billboardpriceOptions);
                    $billboards[] = array_flatten($billboard_ads);
                     
                   
               
                }
                if(count($billboards)>0){
                    echo "<pre>";
                    print_r($billboards);
                    echo "</pre>";
                    foreach($billboards as $searchBillboard){
                       $this->billboard_ads($searchBillboard);
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
   public function billboard_ads($searchBillboard)
   {
       ?>
       <div class="col-md-3 col-sm-3 "> 
        <div class="pro-item"> 
            <div class=" cat-opt-img "> <img src="<?= asset('images/billboards/'.$searchBillboard[11]) ?>"> </div>
            <p class="font-1"><?= $searchBillboard[3] ?></p>
            <p class="font-2"><?= $searchBillboard[5] ?> | <?= $searchBillboard[6] ?> | <?= $searchBillboard[7] ?></p>
            <p class="font-3"><?= $searchBillboard[21]?> <?= ucwords(substr(str_replace('_', ' ', $searchBillboard[18]), 6))?> for <?= $searchBillboard[23]?> months</p>
            <p class="font-2"><del class="lighter">Rs <?= $searchBillboard[19]?> </del>Rs <?= $searchBillboard[19]?> </p>
            <?php
            $options = $searchBillboard[19].'+'.$searchBillboard[18];
            $session_key = 'billboards'.'_'.$searchBillboard[18].'_'.$searchBillboard[0];
            $printsession = (array) Session::get('cart');
                            
           ?>
            <div class="clearfix"> 
                <a class="glass" href="<?= route('billboard.addtocart', ['id' => $searchBillboard[0], 'variation' => $options]) ?>"><span class="fa fa-star"></span>
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

    //billboardt functions
   // add or remove item to billboardt
   public function getAddToCart(Request $request, $id, $variation)
   {
        $billboard_ad = Billboards::where('id', $id)->first()->toArray();
        
        $selectDisplayOpt = explode("+", $variation);
        $main_key = substr($selectDisplayOpt[1], 6);
        
       
        $billboard_price = Billboardsprice::where([
                                    ['billboards_id', '=', $id],
                                    ['price_key', '=', $selectDisplayOpt[1]],
                                ])->first()->toArray();
       
        $billboard_Ad = array_merge($billboard_ad, $billboard_price);
       
        $oldCart = Session::has('cart') ? Session::get('cart') : null;
                
        $cart = new Cart($oldCart);

        $cart->addorRemove($billboard_Ad, $billboard_ad['id'], 'billboards', $flag=true); //pass full billboard details, id and model name like "billboards"
        
        $request->session()->put('cart', $cart);
        //Session::forget('cart');

        return redirect()->back()->with(['status' => 'added']);
    }

 
}

