<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use Session;
use App\Shoppingmalls;
use App\Shoppingmallsprice;
use Image;
use App\Product;
use Illuminate\Support\Facades\File;
use App\Cart;
use App\Order;


class ShoppingmallController extends Controller
{
    
    //frontend function starts
    
    public function getfrontendAllShoppingmallads()
    {
       $shoppingmall_ads = Shoppingmalls::all();
       return view('frontend-mediatype.shoppingmalls.shoppingmallads-list', ['products' => $shoppingmall_ads]);
    }
    public function getfrontShoppingmalladByOption($shoppingmallOption)
    {
       $shoppingmall_ads = Shoppingmalls::all()->toArray();
       
        $shoppingmallOption1 = '%'.$shoppingmallOption.'%';
        $shoppingmalls = array();
        foreach($shoppingmall_ads as $shoppingmall){
            $count = Shoppingmallsprice::where([
                                    ['shoppingmalls_id', '=', $shoppingmall['id']],
                                    ['price_key', 'LIKE', $shoppingmallOption1],
                                   ])->get()->count();
            if($count > 0){
                 $shoppingmallpriceOptions = Shoppingmallsprice::where([
                                    ['shoppingmalls_id', '=', $shoppingmall['id']],
                                    ['price_key', 'LIKE', $shoppingmallOption1],
                                   ])->get(array('price_key', 'price_value', 'number_key', 'number_value', 'duration_key', 'duration_value'))->toArray();
                array_push($shoppingmall, $shoppingmallpriceOptions);
                $shoppingmalls[] = array_flatten($shoppingmall);
            }
       }
       
        return view('frontend-mediatype.shoppingmalls.shoppingmall-single', ['products' => $shoppingmalls, 'shoppingmallOption' => $shoppingmallOption]);
    }
    
    public function getfrontShoppingmallad($id)
    {
        $shoppingmallad = Shoppingmalls::find($id);
        if($shoppingmallad){
            if($shoppingmallad->status === '3' || $shoppingmallad->status === '2'){
                return redirect()->back();
            }else{
                 $shoppingmallprice = Shoppingmallsprice::where('shoppingmalls_id', $id)->get();
                return view('frontend-mediatype.shoppingmalls.shoppingmall-single', ['shoppingmallad' => $shoppingmallad, 'shoppingmallprice' => $shoppingmallprice]);
            }
        }else{
            return redirect()->back();
        }
       
    }
    
    
    // frontend functions ends

    //Backend functions below


    // get list of all the products in shoppingmall stop media type
    public function getDashboardShoppingmallList(){
        $shoppingmall_ads = Shoppingmalls::all();
        return view('backend.mediatypes.shoppingmalls.shoppingmall-list', ['shoppingmall_ads' => $shoppingmall_ads]);
    }
    
    // get form of shoppingmall stop media type
     public function getDashboardShoppingmallForm()
    {
        return view('backend.mediatypes.shoppingmalls.shoppingmall-addform');
    }
    
    // post list of all the products in shoppingmall media type

    public function postDashboardShoppingmallForm(Request $request)
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
            $location = public_path("images\shoppingmalls\\" . $filename);
            Image::make($file)->resize(800, 400)->save($location);
        }

        $shoppingmall = new Shoppingmalls([
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
                'display_options' => serialize($request->input('shoppingmalldisplay')),
                'light_option' => $request->input('shoppingmalllighting'),
                'discount' => $request->input('discount'),
                'numberofshoppingmalls' => $request->input('shoppingmallsnumber')
        ]);

        $shoppingmall->save();

        $lastinsert_ID = $shoppingmall->id;



        //shoppingmall display prices insertion

        if($request->has('price_danglers')){
            $this->addShoppingmallPrice($lastinsert_ID, 'price_danglers', $request->input('price_danglers'), 'number_danglers', $request->input('number_danglers'), 'duration_danglers', $request->input('duration_danglers'));
        }
        

        if($request->has('price_drop_down_banners')){
            $this->addShoppingmallPrice($lastinsert_ID, 'price_drop_down_banners', $request->input('price_drop_down_banners'), 'number_drop_down_banners', $request->input('number_drop_down_banners'), 'duration_drop_down_banners', $request->input('duration_drop_down_banners'));
        }
      
       

        if($request->has('price_signage')){
            $this->addShoppingmallPrice($lastinsert_ID, 'price_signage', $request->input('price_signage'), 'number_signage', $request->input('number_signage'), 'duration_signage', $request->input('duration_signage'));
        }
        

        if($request->has('price_pillar_branding')){
            $this->addShoppingmallPrice($lastinsert_ID, 'price_pillar_branding', $request->input('price_pillar_branding'), 'number_pillar_branding', $request->input('number_pillar_branding'), 'duration_pillar_branding', $request->input('duration_pillar_branding'));
        }
       

        if($request->has('price_washroom_branding')){
            $this->addShoppingmallPrice($lastinsert_ID, 'price_washroom_branding', $request->input('price_washroom_branding'), 'number_washroom_branding', $request->input('number_washroom_branding'), 'duration_washroom_branding', $request->input('duration_washroom_branding'));
        }
        
        if($request->has('price_wall_branding')){
            $this->addShoppingmallPrice($lastinsert_ID, 'price_wall_branding', $request->input('price_wall_branding'), 'number_wall_branding', $request->input('number_wall_branding'), 'duration_wall_branding', $request->input('duration_wall_branding'));
        }
        

        if($request->has('price_popcorn_tub_branding')){
            $this->addShoppingmallPrice($lastinsert_ID, 'price_popcorn_tub_branding', $request->input('price_popcorn_tub_branding'), 'number_popcorn_tub_branding', $request->input('number_popcorn_tub_branding'), 'duration_popcorn_tub_branding', $request->input('duration_popcorn_tub_branding'));
        }
        
        
        if($request->has('price_product_kiosk')){
            $this->addShoppingmallPrice($lastinsert_ID, 'price_product_kiosk', $request->input('price_product_kiosk'), 'number_product_kiosk', $request->input('number_product_kiosk'), 'duration_product_kiosk', $request->input('duration_product_kiosk'));
        }
       

        if($request->has('price_digital_plasma_screen')){
            $this->addShoppingmallPrice($lastinsert_ID, 'price_digital_plasma_screen', $request->input('price_digital_plasma_screen'), 'number_digital_plasma_screen', $request->input('number_digital_plasma_screen'), 'duration_digital_plasma_screen', $request->input('duration_digital_plasma_screen'));
        }
        

        if($request->has('price_standee')){
            $this->addShoppingmallPrice($lastinsert_ID, 'price_standee', $request->input('price_standee'), 'number_standee', $request->input('number_standee'), 'duration_standee', $request->input('duration_standee'));
        }
        

        if($request->has('price_seat_branding')){
            $this->addShoppingmallPrice($lastinsert_ID, 'price_seat_branding', $request->input('price_seat_branding'), 'number_seat_branding', $request->input('number_seat_branding'), 'duration_seat_branding', $request->input('duration_seat_branding'));
        }

        if($request->has('price_audi_door_branding')){
            $this->addShoppingmallPrice($lastinsert_ID, 'price_audi_door_branding', $request->input('price_audi_door_branding'), 'number_audi_door_branding', $request->input('number_audi_door_branding'), 'duration_audi_door_branding', $request->input('duration_audi_door_branding'));
        }
        
    
       
        //return to shoppingmall product list
       return redirect()->route('dashboard.getShoppingmallList')->with('message', 'Successfully Added!');
    }

    //insert price data to shoppingmall price table
    public function addShoppingmallPrice($id, $pricekey, $pricevalue, $numkey, $numvalue, $durkey, $durvalue)
    {
        $insert = new Shoppingmallsprice();

        $insert->shoppingmalls_id = $id;
        $insert->price_key = $pricekey;
        $insert->price_value = $pricevalue;
        $insert->number_key = $numkey;
        $insert->number_value = $numvalue;
        $insert->duration_key = $durkey;
        $insert->duration_value = $durvalue;
       
        $insert->save();

    }

    // delete shoppingmall product and price form db tables

    public function getDeleteShoppingmallad($shoppingmalladID)
    {
        $delele_shoppingmallad = Shoppingmalls::where('id', $shoppingmalladID)->first();
        $delele_shoppingmallad->delete();
        $delete_shoppingmalladprice = Shoppingmallsprice::where('shoppingmalls_id', $shoppingmalladID);
        $delete_shoppingmalladprice->delete();
      
        return redirect()->route('dashboard.getShoppingmallList')->with(['message' => "Successfully Deleted From the List!"]);
    }

    // update shoppingmall product
    public function getUpdateeShoppingmallad($ID)
    {
        $shoppingmallData = Shoppingmalls::find($ID);
        $shoppingmallpriceData = Shoppingmallsprice::where('shoppingmalls_id', $ID)->get();
        $fieldData = array();
        foreach($shoppingmallpriceData as $priceshoppingmall){
            $fieldData[] = ucwords(str_replace('_', ' ', substr($priceshoppingmall->price_key, 6)));
        }

       $fieldDatas = serialize($fieldData);
        return view('backend.mediatypes.shoppingmalls.shoppingmall-editform', ['shoppingmall' => $shoppingmallData, 'shoppingmallpricemeta' => $shoppingmallpriceData, 'fieldData' => $fieldDatas]);
    }
    //check and uncheck options remove
    public function getuncheckShoppingmalladOptions(Request $request)
    {
        $displayoptions = json_decode($request['displayoptions']);
        $datta = array();
        foreach($displayoptions as $options){
			$datta[] = strtolower(str_replace(' ', '_', $options));
		
		}
        
        $count = Shoppingmallsprice::where([
                                    ['shoppingmalls_id', '=', $request['id']],
                                    ['price_key', '=', $request['price_key']],
                                ])->count();
        if($count > 0){
            Shoppingmalls::where('id', $request['id'])->update(['display_options' => serialize($datta)]);
            $shoppingmalls = Shoppingmallsprice::where([
                                    ['shoppingmalls_id', '=', $request['id']],
                                    ['price_key', '=', $request['price_key']],
                                ])->first();
            $shoppingmalls->delete();
           
            return response(['msg' => 'price deleted'], 200);
        }else{
              
            return response(['msg' => 'Value not present in db!'], 200);
        }
    }

    public function postUpdateeShoppingmallad(Request $request, $ID)
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

        $editshoppingmall = Shoppingmalls::find($ID);

         $editshoppingmall->title = $request->input('title');
         $editshoppingmall->price = $request->input('price');
         $editshoppingmall->location = $request->input('location');
         $editshoppingmall->state = $request->input('state');
         $editshoppingmall->city = $request->input('city');
         $editshoppingmall->rank = $request->input('rank');
         $editshoppingmall->description = $request->input('description');
         $editshoppingmall->status = $request->input('status');
         $editshoppingmall->references = $request->input('reference');
         $editshoppingmall->display_options = serialize($request->input('shoppingmalldisplay'));
          $editshoppingmall->numberofshoppingmalls = $request->input('shoppingmallsnumber');
          $editshoppingmall->discount = $request->input('discount');

        if($request->hasFile('image')){
            $file = $request->file('image');
            $filename = time() .'.'. $file->getClientOriginalExtension();
            $location = public_path("images\shoppingmalls\\" . $filename);
            Image::make($file)->resize(800, 400)->save($location);
            $oldimage = $editshoppingmall->image;
            $editshoppingmall->image = $filename;
        }

       $editshoppingmall->update();

        //shoppingmall display prices insertion

        if($request->has('price_danglers')){
            $this->updateShoppingmallPrice($ID, 'price_danglers', $request->input('price_danglers'), 'number_danglers', $request->input('number_danglers'), 'duration_danglers', $request->input('duration_danglers'));
        }
       

        if($request->has('price_drop_down_banners')){
            $this->updateShoppingmallPrice($ID, 'price_drop_down_banners', $request->input('price_drop_down_banners'), 'number_drop_down_banners', $request->input('number_drop_down_banners'), 'duration_drop_down_banners', $request->input('duration_drop_down_banners'));
        }
      
      

        if($request->has('price_signage')){
            $this->updateShoppingmallPrice($ID, 'price_signage', $request->input('price_signage'), 'number_signage', $request->input('number_signage'), 'duration_signage', $request->input('duration_signage'));
        }
       
        

        if($request->has('price_pillar_branding')){
            $this->updateShoppingmallPrice($ID, 'price_pillar_branding', $request->input('price_pillar_branding'), 'number_pillar_branding', $request->input('number_pillar_branding'), 'duration_pillar_branding', $request->input('duration_pillar_branding'));
        }
       

        if($request->has('price_washroom_branding')){
            $this->updateShoppingmallPrice($ID, 'price_washroom_branding', $request->input('price_washroom_branding'), 'number_washroom_branding', $request->input('number_washroom_branding'), 'duration_washroom_branding', $request->input('duration_washroom_branding'));
        }
        

        if($request->has('price_wall_branding')){
            $this->updateShoppingmallPrice($ID, 'price_wall_branding', $request->input('price_wall_branding'), 'number_wall_branding', $request->input('number_wall_branding'), 'duration_wall_branding', $request->input('duration_wall_branding'));
        }
        

        if($request->has('price_popcorn_tub_branding')){
            $this->updateShoppingmallPrice($ID, 'price_popcorn_tub_branding', $request->input('price_popcorn_tub_branding'), 'number_popcorn_tub_branding', $request->input('number_popcorn_tub_branding'), 'duration_popcorn_tub_branding', $request->input('duration_popcorn_tub_branding'));
        }
       
        
        if($request->has('price_product_kiosk')){
            $this->updateShoppingmallPrice($ID, 'price_product_kiosk', $request->input('price_product_kiosk'), 'number_product_kiosk', $request->input('number_product_kiosk'), 'duration_product_kiosk', $request->input('duration_product_kiosk'));
        }
       
        if($request->has('price_digital_plasma_screen')){
            $this->updateShoppingmallPrice($ID, 'price_digital_plasma_screen', $request->input('price_digital_plasma_screen'), 'number_digital_plasma_screen', $request->input('number_digital_plasma_screen'), 'duration_digital_plasma_screen', $request->input('duration_digital_plasma_screen'));
        }
       

        if($request->has('price_standee')){
            $this->updateShoppingmallPrice($ID, 'price_standee', $request->input('price_standee'), 'number_standee', $request->input('number_standee'), 'duration_standee', $request->input('duration_standee'));
        }
        

         if($request->has('price_seat_branding')){
            $this->updateShoppingmallPrice($ID, 'price_seat_branding', $request->input('price_seat_branding'), 'number_seat_branding', $request->input('number_seat_branding'), 'duration_seat_branding', $request->input('duration_seat_branding'));
        }
        

        if($request->has('price_audi_door_branding')){
            $this->updateShoppingmallPrice($ID, 'price_audi_door_branding', $request->input('price_audi_door_branding'), 'number_audi_door_branding', $request->input('number_audi_door_branding'), 'duration_audi_door_branding', $request->input('duration_audi_door_branding'));
        }
  
        //return to shoppingmall product list
       return redirect()->route('dashboard.getShoppingmallList')->with('message', 'Successfully Edited!');
    }

    public function updateShoppingmallPrice( $id, $pricekey, $pricevalue, $numkey, $numvalue, $durkey, $durvalue){
        $count = Shoppingmallsprice::where([
                                    ['shoppingmalls_id', '=', $id],
                                    ['price_key', '=', $pricekey],
                                ])->count();
        if($count < 1){
            $this->addShoppingmallPrice($id, $pricekey, $pricevalue, $numkey, $numvalue, $durkey, $durvalue);
        }else{
            $update = Shoppingmallsprice::where([
                                    ['shoppingmalls_id', '=', $id],
                                    ['price_key', '=', $pricekey],
                                ])->update(['price_value' => $pricevalue, 'number_value' => $numvalue, 'duration_value' => $durvalue]);
        }
        
   }

   //Fliter Functions
   public function getFilterShoppingmallAds(Request $request)
   {
       if(!empty($request['locationFilter']) && !empty($request['pricerange'])){
            $filter_priceCamparsion = preg_replace('/[0-9]+/', '', $request['pricerange']); // comparion operator
            if($filter_priceCamparsion != '<>'){
                    $filter_price = preg_replace('/[^0-9]/', '', $request['pricerange']);
                    $shoppingmallpriceOptions = Shoppingmallsprice::where([
                                ['price_key', 'LIKE', 'price_%'],                                    
                                ['price_value', $filter_priceCamparsion, $filter_price],
                                ])->get(array('shoppingmalls_id','price_key', 'price_value', 'number_key', 'number_value', 'duration_key', 'duration_value'))->toArray();
            }else{
                    $filter_price = preg_replace('/[^0-9]/', '_', $request['pricerange']);
                    $filter_price = explode('_', $filter_price);
                
                    $shoppingmallpriceOptions = Shoppingmallsprice::where([
                                ['price_key', 'LIKE', 'price_%'],                                    
                                ['price_value', '>=', $filter_price[0]],
                                ['price_value', '<=', $filter_price[2]],
                                ])->get(array('shoppingmalls_id','price_key', 'price_value', 'number_key', 'number_value', 'duration_key', 'duration_value'))->toArray();   
            }
            if(count($shoppingmallpriceOptions)>0){
               
                $shoppingmalls = array(); 
                foreach($shoppingmallpriceOptions as $key => $value){
                    $location = "%".$request['locationFilter']."%";
            
                    $shoppingmall_ad = Shoppingmalls::where('id', '=', $value['shoppingmalls_id'])->where('location', 'LIKE', $location)->Where('city', 'LIKE', $location)->get()->toArray();
                    if(count($shoppingmall_ad) > 0){
                        $shoppingmallpriceiterate = Shoppingmallsprice::where([
                                        ['shoppingmalls_id', '=', $value['shoppingmalls_id']],
                                        ['price_key', 'LIKE', $value['price_key']],
                                    
                                        ])->get(array('price_key', 'price_value', 'number_key', 'number_value', 'duration_key', 'duration_value'))->first()->toArray();
                        array_push($shoppingmall_ad, $shoppingmallpriceiterate);
                        $shoppingmalls[] = array_flatten($shoppingmall_ad);
                    }
                
                }
                if(count($shoppingmalls)>0){
                    
                    foreach($shoppingmalls as $searchShoppingmall){
                        $this->shoppingmall_ads($searchShoppingmall);
                    }
            
                }else{
                    echo "<b>No results to display!</b>";
                }

            }else{
                echo "<b>No results to display!</b>";
            }    
       }

       if(!empty($request['pricerange']) && empty($request['locationFilter'])){
            $filter_priceCamparsion = preg_replace('/[0-9]+/', '', $request['pricerange']); // comparion operator
            if($filter_priceCamparsion != '<>'){
                    $filter_price = preg_replace('/[^0-9]/', '', $request['pricerange']);
                    $shoppingmallpriceOptions = Shoppingmallsprice::where([
                                ['price_key', 'LIKE', 'price_%'],                                    
                                ['price_value', $filter_priceCamparsion, $filter_price],
                                ])->get(array('shoppingmalls_id','price_key', 'price_value', 'number_key', 'number_value', 'duration_key', 'duration_value'))->toArray();
            }else{
                    $filter_price = preg_replace('/[^0-9]/', '_', $request['pricerange']);
                    $filter_price = explode('_', $filter_price);
                
                    $shoppingmallpriceOptions = Shoppingmallsprice::where([
                                ['price_key', 'LIKE', 'price_%'],                                    
                                ['price_value', '>=', $filter_price[0]],
                                ['price_value', '<=', $filter_price[2]],
                                ])->get(array('shoppingmalls_id','price_key', 'price_value', 'number_key', 'number_value', 'duration_key', 'duration_value'))->toArray();   
            }
            if(count($shoppingmallpriceOptions)>0){
                
                $shoppingmalls = array(); 
                foreach($shoppingmallpriceOptions as $key => $value){
                    
                    $shoppingmall_ad = Shoppingmalls::where('id', '=', $value['shoppingmalls_id'])->get()->toArray();
                    
                    $shoppingmallpriceiterate = Shoppingmallsprice::where([
                                        ['shoppingmalls_id', '=', $value['shoppingmalls_id']],
                                        ['price_key', 'LIKE', $value['price_key']],
                                    
                                        ])->get(array('price_key', 'price_value', 'number_key', 'number_value', 'duration_key', 'duration_value'))->first()->toArray();
                    array_push($shoppingmall_ad, $shoppingmallpriceiterate);
                    $shoppingmalls[] = array_flatten($shoppingmall_ad);
                
                }
                if(count($shoppingmalls)>0){
            
                    foreach($shoppingmalls as $searchShoppingmall){
                        $this->shoppingmall_ads($searchShoppingmall);
                    }
            
                }else{
                    echo "<b>No results to display!</b>";
                }

            }else{
                echo "<b>No results to display!</b>";
            }
            
           
       }
       if(!empty($request['locationFilter']) && empty($request['pricerange'])){
            $location = "%".$request['locationFilter']."%";
            $shoppingmall_ad = Shoppingmalls::where('location', 'LIKE', $location)->orWhere('city', 'LIKE', $location)->get()->toArray();
             
            if(count($shoppingmall_ad)>0){
                foreach($shoppingmall_ad as $shoppingmall){
                    $shoppingmallpriceOptions = Shoppingmallsprice::where([
                                    ['shoppingmalls_id', 'LIKE',  $shoppingmall['id']],                                 
                                    ])->get(array('price_key', 'price_value', 'number_key',
                                    'number_value', 'duration_key', 'duration_value'))->toArray();
                   
                    if(count($shoppingmallpriceOptions)>0){
                        
                        foreach($shoppingmallpriceOptions as $priceOptions){
                           //for($i = 1;$i<=count($shoppingmallpriceOptions);$i++){
                                array_push($shoppingmall, $priceOptions);
                                
                                $shoppingmalls[] = array_flatten($shoppingmall);
                           //}
                          
                        }
                       
                    }else{
                        echo "<b>No results to display!</b>";
                    }
                    
                }
                if(count($shoppingmalls)>0){
            
                    foreach($shoppingmalls as $searchShoppingmall){
                        //$this->shoppingmall_ads($searchShoppingmall);
                    }
            
                }else{
                    echo "<b>No results to display!</b>";
                }
            }else{
                echo "<b>No results to display!</b>";
            }
       }
       
       
        $content = ob_get_contents();
        ob_get_clean();
        return $content;
       
       
   }
   public function shoppingmall_ads($searchShoppingmall)
   {
       ?>
       <div class="col-md-3 col-sm-3 "> 
        <div class="pro-item"> 
            <div class=" cat-opt-img "> <img src="<?= asset('images/shoppingmalls/'.$searchShoppingmall[11]) ?>"> </div>
            <p class="font-1"><?= $searchShoppingmall[3] ?></p>
            <p class="font-2"><?= $searchShoppingmall[5] ?> | <?= $searchShoppingmall[6] ?> | <?= $searchShoppingmall[7] ?></p>
            <p class="font-3"><?= $searchShoppingmall[21]?> <?= ucwords(substr(str_replace('_', ' ', $searchShoppingmall[18]), 6))?> for <?= $searchShoppingmall[23]?> months</p>
            <p class="font-2"><del class="lighter">Rs <?= $searchShoppingmall[19]?> </del>Rs <?= $searchShoppingmall[19]?> </p>
            <?php
            $options = $searchShoppingmall[19].'+'.$searchShoppingmall[18];
            $session_key = 'shoppingmalls'.'_'.$searchShoppingmall[18].'_'.$searchShoppingmall[0];
            $printsession = (array) Session::get('cart');
                            
           ?>
            <div class="clearfix"> 
                <a class="glass" href="<?= route('shoppingmall.addtocart', ['id' => $searchShoppingmall[0], 'variation' => $options]) ?>"><span class="fa fa-star"></span>
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
        $shoppingmall_ad = Shoppingmalls::where('id', $id)->first()->toArray();
        
        $selectDisplayOpt = explode("+", $variation);
        $main_key = substr($selectDisplayOpt[1], 6);
        

        $shoppingmall_price = Shoppingmallsprice::where([
                                    ['shoppingmalls_id', '=', $id],
                                    ['price_key', '=', $selectDisplayOpt[1]],
                                ])->first()->toArray();

        
        $shoppingmall_Ad = array_merge($shoppingmall_ad, $shoppingmall_price);
       
        $oldCart = Session::has('cart') ? Session::get('cart') : null;
                
        $cart = new Cart($oldCart);

        $cart->addorRemove($shoppingmall_Ad, $shoppingmall_ad['id'], 'shoppingmalls', $flag=true); //pass full shoppingmall details, id and model name like "shoppingmalls"
        
        $request->session()->put('cart', $cart);
        //Session::forget('cart');

        return redirect()->back()->with(['status' => 'added']);
    }

 
}
