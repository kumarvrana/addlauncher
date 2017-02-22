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
       return view('frontend-mediatype.billboards.billboardads-list', ['products' => $billboard_ads]);
    }
    
    public function getfrontBillboardad($id)
    {
        $billboardad = Billboards::find($id);
        $billboardprice = Billboardsprice::where('billboards_id', $id)->get();
        return view('frontend-mediatype.billboards.billboard-single', ['billboardad' => $billboardad, 'billboardprice' => $billboardprice]);
    }
    
    
    // frontend functions ends
    
  

    //Backend functions below


    // get list of all the products in billboard  media type
     public function getDashboardBillboardList(){
        $billboard_ads = Billboards::all();
        return view('backend.mediatypes.billboards.billboard-list', ['billboard_ads' => $billboard_ads]);
    }
    
     // get form of Billboard media type
    public function getDashboardBillboardForm()
    {
        return view('backend.mediatypes.billboards.billboard-addform');
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
            $location = public_path("images\billboards\\" . $filename);
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

   	   if($request->has('price_hoarding')){
            $this->addBillboardPrice($lastinsert_ID, 'price_hoarding', $request->input('price_hoarding'));
        }
      
       if($request->has('number_hoarding')){
            $this->addBillboardPrice($lastinsert_ID, 'number_hoarding', $request->input('number_hoarding'));
        }

       if($request->has('duration_hoarding')){
            $this->addBillboardPrice($lastinsert_ID, 'duration_hoarding', $request->input('duration_hoarding'));
        }

        if($request->has('price_pole_kiosk')){
            $this->addBillboardPrice($lastinsert_ID, 'price_pole_kiosk', $request->input('price_pole_kiosk'));
        }
        if($request->has('number_pole_kiosk')){
            $this->addBillboardPrice($lastinsert_ID, 'number_pole_kiosk', $request->input('number_pole_kiosk'));
        }
        if($request->has('duration_pole_kiosk')){
            $this->addBillboardPrice($lastinsert_ID, 'duration_pole_kiosk', $request->input('duration_pole_kiosk'));
        }

          if($request->has('price_billboard_shelters')){
            $this->addBillboardPrice($lastinsert_ID, 'price_billboard_shelters', $request->input('price_billboard_shelters'));
        }
        if($request->has('number_billboard_shelters')){
            $this->addBillboardPrice($lastinsert_ID, 'number_billboard_shelters', $request->input('number_billboard_shelters'));
        }
        if($request->has('duration_billboard_shelters')){
            $this->addBillboardPrice($lastinsert_ID, 'duration_billboard_shelters', $request->input('duration_billboard_shelters'));
        }
      
      
      

       
        //return to billboard product list
       return redirect()->route('dashboard.getBillboardList')->with('message', 'Successfully Added!');
    }

    //insert price data to billboard price table
    public function addBillboardPrice($id, $key, $value)
    {
        $insert = new Billboardsprice();

        $insert->billboards_id = $id;
        $insert->price_key = $key;
        $insert->price_value = $value;
       
        $insert->save();

    }

    // delete billboard product and price form db tables

    public function getDeleteBillboardad($billboardadID)
    {
        $delele_billboardad = Billboards::where('id', $billboardadID)->first();
        $delele_billboardad->delete();
        $delete_billboardadprice = Billboardsprice::where('billboards_id', $billboardadID);
        $delete_billboardadprice->delete();
        // $delete_product = Product::where([
        //                             ['media_id', '=', $billboardadID],
        //                             ['media_type', '=', 'Billboards'],
        //                         ])->first();
        // $delete_product->delete();
        return redirect()->route('dashboard.getBillboardList')->with(['message' => "Successfully Deleted From the List!"]);
    }

    // update billboard product
    public function getUpdateeBillboardad($ID)
    {
        $billboardData = Billboards::find($ID);
        $billboardpriceData = Billboardsprice::where('billboards_id', $ID)->get();
        $fieldData = array();
        foreach($billboardpriceData as $pricebillboard){
           $fieldData[] = ucwords(substr(str_replace("_", " ", $pricebillboard->price_key), 6));
        }
       $fieldData = serialize($fieldData);
        return view('backend.mediatypes.billboards.billboard-editform', ['billboard' => $billboardData, 'billboardpricemeta' => $billboardpriceData, 'fieldData' => $fieldData]);
    }
    //check and uncheck options remove
    public function getuncheckBillboardadOptions(Request $request)
    {
        $count = Billboardsprice::where([
                                    ['billboards_id', '=', $request['id']],
                                    ['price_key', '=', $request['price_key']],
                                ])->count();
        if($count > 0){
            Billboards::where('id', $request['id'])->update(['display_options' => serialize($request['displayoptions'])]);
            $billboards = Billboardsprice::where([
                                    ['billboards_id', '=', $request['id']],
                                    ['price_key', '=', $request['price_key']],
                                ])->first();
            $billboards->delete();
            return response(['msg' => 'price deleted'], 200);
        }
              
            return response(['msg' => 'Value not present in db!'], 200);
        
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

        if($request->hasFile('image')){
            $file = $request->file('image');
            $filename = time() .'.'. $file->getClientOriginalExtension();
            $location = public_path("images\billboards\\" . $filename);
            Image::make($file)->resize(800, 400)->save($location);
            $oldimage = $editbillboard->image;
            $editbillboard->image = $filename;
        }

       $editbillboard->update();

        //billboard display prices insertion

        
     
   	   if($request->has('price_hoarding')){
            $this->updateBillboardPrice($ID, 'price_hoarding', $request->input('price_hoarding'));
        }
      
       if($request->has('number_hoarding')){
            $this->updateBillboardPrice($ID, 'number_hoarding', $request->input('number_hoarding'));
        }

       if($request->has('duration_hoarding')){
            $this->updateBillboardPrice($ID, 'duration_hoarding', $request->input('duration_hoarding'));
        }

        if($request->has('price_pole_kiosk')){
            $this->updateBillboardPrice($ID, 'price_pole_kiosk', $request->input('price_pole_kiosk'));
        }
        if($request->has('number_pole_kiosk')){
            $this->updateBillboardPrice($ID, 'number_pole_kiosk', $request->input('number_pole_kiosk'));
        }
        if($request->has('duration_pole_kiosk')){
            $this->updateBillboardPrice($ID, 'duration_pole_kiosk', $request->input('duration_pole_kiosk'));
        }

          if($request->has('price_billboard_shelters')){
            $this->updateBillboardPrice($ID, 'price_billboard_shelters', $request->input('price_billboard_shelters'));
        }
        if($request->has('number_billboard_shelters')){
            $this->updateBillboardPrice($ID, 'number_billboard_shelters', $request->input('number_billboard_shelters'));
        }
        if($request->has('duration_billboard_shelters')){
            $this->updateBillboardPrice($ID, 'duration_billboard_shelters', $request->input('duration_billboard_shelters'));
        }

        

        //return to billboard product list
       return redirect()->route('dashboard.getBillboardList')->with('message', 'Successfully Edited!');
    }

    public function updateBillboardPrice( $id, $meta_key, $meta_value){
        $count = Billboardsprice::where([
                                    ['billboards_id', '=', $id],
                                    ['price_key', '=', $meta_key],
                                ])->count();
        if($count < 1){
            $this->addBillboardPrice($id, $meta_key, $meta_value);
        }else{
            $update = Billboardsprice::where([
                                    ['billboards_id', '=', $id],
                                    ['price_key', '=', $meta_key],
                                ])->update(['price_value' => $meta_value]);
        }
        
   }

    //billboardt functions
   // add or remove item to billboardt
   public function getAddToBillboardt(Request $request, $id, $variation)
   {
        $billboard_ad = Billboards::where('id', $id)->first()->toArray();
        
        $selectDisplayOpt = explode("+", $variation);
        $billboard_price = Billboardsprice::where([
                                    ['billboards_id', '=', $id],
                                    ['price_key', '=', $selectDisplayOpt[1]],
                                ])->first()->toArray();
        
        $billboard_Ad = array_merge($billboard_ad, $billboard_price);
       
        $oldBillboardt = Session::has('billboardt') ? Session::get('billboardt') : null;
                
        $billboardt = new Billboardt($oldBillboardt);

        $billboardt->addorRemove($billboard_Ad, $billboard_ad['id'], 'billboards'); //pass full billboard details, id and model name like "billboards"
        
        $request->session()->put('billboardt', $billboardt);
        //Session::forget('billboardt');

        return redirect()->back()->with(['status' => 'added']);
    }

 
}

