<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Http\Requests;
use Session;
use App\Newspapers;
use App\Newspapersprice;
use Image;
use App\Product;
use Illuminate\Support\Facades\File;
use App\Newspapert;
use App\Order;


class NewspaperController extends Controller
{
     //frontend function starts
    
    public function getfrontendAllNewspaperads()
    {
       $newspaper_ads = Newspapers::all();
       return view('frontend-mediatype.newspapers.newspaperads-list', ['products' => $newspaper_ads]);
    }
    
    public function getfrontNewspaperad($id)
    {
        $newspaperad = Newspapers::find($id);
        $newspaperprice = Newspapersprice::where('newspapers_id', $id)->get();
        return view('frontend-mediatype.newspapers.newspaper-single', ['newspaperad' => $newspaperad, 'newspaperprice' => $newspaperprice]);
    }
    
    
    // frontend functions ends
  

    //Backend functions below


    // get list of all the products in bus stop media type
   public function getDashboardNewspaperList(){
        $newspaper_ads = Newspapers::all();
        return view('backend.mediatypes.newspapers.newspaper-list', ['newspaper_ads' => $newspaper_ads]);
    }
    
     // get form of Newspaper media type
    public function getDashboardNewspaperForm()
    {
        return view('backend.mediatypes.newspapers.newspaper-addform');
    }


    // post list of all the products in bus media type

    public function postDashboardNewspaperForm(Request $request)
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
            $location = public_path("images\buses\\" . $filename);
            Image::make($file)->resize(800, 400)->save($location);
        }

        $newspaper = new Newspapers([
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
                'general_options' => serialize($request->input('busdisplay')),
                'numberofnewspapers' => $request->input('newspapersnumber')
        ]);

        $newspaper->save();

        $lastinsert_ID = $newspaper->id;


        //bus display prices insertion

   	   if($request->has('price_full')){
            $this->addNewspaperPrice($lastinsert_ID, 'price_full', $request->input('price_full'));
        }
      
       if($request->has('number_full')){
            $this->addNewspaperPrice($lastinsert_ID, 'number_full', $request->input('number_full'));
        }

       if($request->has('duration_full')){
            $this->addNewspaperPrice($lastinsert_ID, 'duration_full', $request->input('duration_full'));
        }

        if($request->has('price_full_outside_only')){
            $this->addNewspaperPrice($lastinsert_ID, 'price_full_outside_only', $request->input('price_full_outside_only'));
        }
        if($request->has('number_full_outside_only')){
            $this->addNewspaperPrice($lastinsert_ID, 'number_full_outside_only', $request->input('number_full_outside_only'));
        }
        if($request->has('duration_full_outside_only')){
            $this->addNewspaperPrice($lastinsert_ID, 'duration_full_outside_only', $request->input('duration_full_outside_only'));
        }
      
      
      

       
        //return to bus product list
       return redirect()->route('dashboard.getNewspaperList')->with('message', 'Successfully Added!');
    }

    //insert price data to bus price table
    public function addNewspaperPrice($id, $key, $value)
    {
        $insert = new Newspapersprice();

        $insert->newspapers_id = $id;
        $insert->price_key = $key;
        $insert->price_value = $value;
       
        $insert->save();

    }

    // delete bus product and price form db tables

    public function getDeleteBusstopad($busstopadID)
    {
        $delele_busad = Busstops::where('id', $busstopadID)->first();
        $delele_busad->delete();
        $delete_busstopadprice = Busstopsprice::where('busstops_id', $busstopadID);
        $delete_busstopadprice->delete();
        // $delete_product = Product::where([
        //                             ['media_id', '=', $busstopadID],
        //                             ['media_type', '=', 'Busstops'],
        //                         ])->first();
        // $delete_product->delete();
        return redirect()->route('dashboard.getBusstopList')->with(['message' => "Successfully Deleted From the List!"]);
    }

    // update bus product
    public function getUpdateeBusad($ID)
    {
        $busstopData = Buses::find($ID);
        $busstoppriceData = Busesprice::where('buses_id', $ID)->get();
        $fieldData = array();
        foreach($busstoppriceData as $pricebus){
           $fieldData[] = ucwords(substr(str_replace("_", " ", $pricebus->price_key), 6));
        }
       $fieldData = serialize($fieldData);
        return view('backend.mediatypes.buses.bus-editform', ['bus' => $busstopData, 'buspricemeta' => $busstoppriceData, 'fieldData' => $fieldData]);
    }
    //check and uncheck options remove
    public function getuncheckBusadOptions(Request $request)
    {
        $count = Busesprice::where([
                                    ['buses_id', '=', $request['id']],
                                    ['price_key', '=', $request['price_key']],
                                ])->count();
        if($count > 0){
            Buses::where('id', $request['id'])->update(['display_options' => serialize($request['displayoptions'])]);
            $buses = Busesprice::where([
                                    ['buses_id', '=', $request['id']],
                                    ['price_key', '=', $request['price_key']],
                                ])->first();
            $buses->delete();
            return response(['msg' => 'price deleted'], 200);
        }
              
            return response(['msg' => 'Value not present in db!'], 200);
        
    }

    public function postUpdateeBusad(Request $request, $ID)
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

        $editbus = Buses::find($ID);

         $editbus->title = $request->input('title');
         $editbus->price = $request->input('price');
         $editbus->location = $request->input('location');
         $editbus->state = $request->input('state');
         $editbus->city = $request->input('city');
         $editbus->rank = $request->input('rank');
         $editbus->description = $request->input('description');
         $editbus->status = $request->input('status');
         $editbus->references = $request->input('reference');
         $editbus->display_options = serialize($request->input('busdisplay'));
          $editbus->busnumber = $request->input('busesnumber');

        if($request->hasFile('image')){
            $file = $request->file('image');
            $filename = time() .'.'. $file->getClientOriginalExtension();
            $location = public_path("images\buses\\" . $filename);
            Image::make($file)->resize(800, 400)->save($location);
            $oldimage = $editbus->image;
            $editbus->image = $filename;
        }

       $editbus->update();

        //bus display prices insertion

        if($request->has('price_full')){
            $this->updateBusPrice($ID, 'price_full', $request->input('price_full'));
        }
        if($request->has('price_both_side')){
            $this->updateBusPrice($ID, 'price_both_side', $request->input('price_both_side'));
        }
        if($request->has('price_left_side')){
            $this->updateBusPrice($ID, 'price_left_side', $request->input('price_left_side'));
        }
        if($request->has('price_right_side')){
            $this->updateBusPrice($ID, 'price_right_side', $request->input('price_right_side'));
        }
        if($request->has('price_back_side')){
            $this->updateBusPrice($ID, 'price_back_side', $request->input('price_back_side'));
        }
        if($request->has('price_back_glass')){
            $this->updateBusPrice($ID, 'price_back_glass', $request->input('price_back_glass'));
        }
        if($request->has('price_internal_ceiling')){
            $this->updateBusPrice($ID, 'price_internal_ceiling', $request->input('price_internal_ceiling'));
        }
        if($request->has('price_bus_grab_handles')){
            $this->updateBusPrice($ID, 'price_bus_grab_handles', $request->input('price_bus_grab_handles'));
        }
        if($request->has('price_inside_billboards')){
            $this->updateBusPrice($ID, 'price_inside_billboards', $request->input('price_inside_billboards'));
        }

        

        //return to bus product list
       return redirect()->route('dashboard.getBusList')->with('message', 'Successfully Edited!');
    }

    public function updateBusPrice( $id, $meta_key, $meta_value){
        $count = Busesprice::where([
                                    ['buses_id', '=', $id],
                                    ['price_key', '=', $meta_key],
                                ])->count();
        if($count < 1){
            $this->addBusPrice($id, $meta_key, $meta_value);
        }else{
            $update = Busesprice::where([
                                    ['buses_id', '=', $id],
                                    ['price_key', '=', $meta_key],
                                ])->update(['price_value' => $meta_value]);
        }
        
   }

    //newspapert functions
   // add or remove item to newspapert
   public function getAddToNewspapert(Request $request, $id, $variation)
   {
        $busstop_ad = Buses::where('id', $id)->first()->toArray();
        
        $selectDisplayOpt = explode("+", $variation);
        $busstop_price = Busesprice::where([
                                    ['buses_id', '=', $id],
                                    ['price_key', '=', $selectDisplayOpt[1]],
                                ])->first()->toArray();
        
        $busstop_Ad = array_merge($busstop_ad, $busstop_price);
       
        $oldNewspapert = Session::has('newspapert') ? Session::get('newspapert') : null;
                
        $newspapert = new Newspapert($oldNewspapert);

        $newspapert->addorRemove($busstop_Ad, $busstop_ad['id'], 'buses'); //pass full bus details, id and model name like "buses"
        
        $request->session()->put('newspapert', $newspapert);
        //Session::forget('newspapert');

        return redirect()->back()->with(['status' => 'added']);
    }

 
}
