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
use App\cart;
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
        //$newspaperprice = Newspapersprice::where('newspapers_id', $id)->get();
       $newspapergeneralprice = Newspapersprice::where([
                                    ['newspapers_id', '=', $id],
                                    ['option_type', '=', 'general'],
                                ])->get();
        $newspaperotherprice = Newspapersprice::where([
                                    ['newspapers_id', '=', $id],
                                    ['option_type', '=', 'other'],
                                ])->get();
        $newspaperclassifiedprice = Newspapersprice::where([
                                    ['newspapers_id', '=', $id],
                                    ['option_type', '=', 'classified'],
                                ])->get();
        $newspaperpricingprice = Newspapersprice::where([
                                    ['newspapers_id', '=', $id],
                                    ['option_type', '=', 'pricing'],
                                ])->get();
        return view('frontend-mediatype.newspapers.newspaper-single', ['newspaperad' => $newspaperad, 'generaloptions' => $newspapergeneralprice, 'otheroptions' => $newspaperotherprice, 'classified' => $newspaperclassifiedprice, 'pricingoption' => $newspaperpricingprice]);
    }
    
    
    // frontend functions ends
  

    //Backend functions below


    // get list of all the products in newspaper
   public function getDashboardNewspaperList(){
        $newspaper_ads = Newspapers::all();
        return view('backend.mediatypes.newspapers.newspaper-list', ['newspaper_ads' => $newspaper_ads]);
    }
    
     // get form of Newspaper media type
    public function getDashboardNewspaperForm()
    {
        return view('backend.mediatypes.newspapers.newspaper-addform');
    }


    // post list of all the products in newspaper media type

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
            $location = public_path("images\\newspapers\\" . $filename);
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
                'language' => $request->input('language'),
                'general_options' => serialize($request->input('newspaperdisplay')),
                'other_options' => serialize($request->input('otherdisplay')),
                'classified_options' => serialize($request->input('classifieddisplay')),
                'pricing_options' => serialize($request->input('pricingdisplay')),
                'numberofnewspapers' => $request->input('number'),
                'circulations' => $request->input('circulation'),
                'discount' => $request->input('discount')
        ]);

        $newspaper->save();

        $lastinsert_ID = $newspaper->id;


        //newspaper display prices insertion

   	   if($request->has('price_page1')){
            $this->addNewspaperPrice($lastinsert_ID, 'price_page1', $request->input('price_page1'), 'general');
        }
      
       if($request->has('number_page1')){
            $this->addNewspaperPrice($lastinsert_ID, 'number_page1', $request->input('number_page1'), 'general');
        }

       if($request->has('duration_page1')){
            $this->addNewspaperPrice($lastinsert_ID, 'duration_page1', $request->input('duration_page1'), 'general');
        }


        if($request->has('price_page3')){
            $this->addNewspaperPrice($lastinsert_ID, 'price_page3', $request->input('price_page3'), 'general');
        }
        if($request->has('number_page3')){
            $this->addNewspaperPrice($lastinsert_ID, 'number_page3', $request->input('number_page3'), 'general');
        }
        if($request->has('duration_page3')){
            $this->addNewspaperPrice($lastinsert_ID, 'duration_page3', $request->input('duration_page3'), 'general');
        }

        if($request->has('price_last_page')){
            $this->addNewspaperPrice($lastinsert_ID, 'price_last_page', $request->input('price_last_page'), 'general');
        }
        if($request->has('number_last_page')){
            $this->addNewspaperPrice($lastinsert_ID, 'number_last_page', $request->input('number_last_page'), 'general');
        }
        if($request->has('duration_last_page')){
            $this->addNewspaperPrice($lastinsert_ID, 'duration_last_page', $request->input('duration_last_page'), 'general');
        }

        if($request->has('price_any_page')){
            $this->addNewspaperPrice($lastinsert_ID, 'price_any_page', $request->input('price_any_page'), 'general');
        }
        if($request->has('number_any_page')){
            $this->addNewspaperPrice($lastinsert_ID, 'number_any_page', $request->input('number_any_page'), 'general');
        }
        if($request->has('duration_any_page')){
            $this->addNewspaperPrice($lastinsert_ID, 'duration_any_page', $request->input('duration_any_page'), 'general');
        }
        //other options

        if($request->has('price_jacket_front_page')){
            $this->addNewspaperPrice($lastinsert_ID, 'price_jacket_front_page', $request->input('price_any_page'), 'other');
        }
        if($request->has('number_jacket_front_page')){
            $this->addNewspaperPrice($lastinsert_ID, 'number_jacket_front_page', $request->input('number_jacket_front_page'), 'other');
        }
        if($request->has('duration_jacket_front_page')){
            $this->addNewspaperPrice($lastinsert_ID, 'duration_jacket_front_page', $request->input('duration_jacket_front_page'), 'other');
        }

        if($request->has('price_jacket_front_inside')){
            $this->addNewspaperPrice($lastinsert_ID, 'price_jacket_front_inside', $request->input('price_jacket_front_inside'), 'other');
        }
        if($request->has('number_jacket_front_inside')){
            $this->addNewspaperPrice($lastinsert_ID, 'number_jacket_front_inside', $request->input('number_jacket_front_inside'), 'other');
        }
        if($request->has('duration_jacket_front_inside')){
            $this->addNewspaperPrice($lastinsert_ID, 'duration_jacket_front_inside', $request->input('duration_jacket_front_inside'), 'other');
        }
        
        if($request->has('price_pointer_ad')){
            $this->addNewspaperPrice($lastinsert_ID, 'price_pointer_ad', $request->input('price_pointer_ad'), 'other');
        }
        if($request->has('number_pointer_ad')){
            $this->addNewspaperPrice($lastinsert_ID, 'number_pointer_ad', $request->input('number_pointer_ad'), 'other');
        }
        if($request->has('duration_pointer_ad')){
            $this->addNewspaperPrice($lastinsert_ID, 'duration_pointer_ad', $request->input('duration_pointer_ad'), 'other');
        }
        
        if($request->has('price_sky_bus')){
            $this->addNewspaperPrice($lastinsert_ID, 'price_sky_bus', $request->input('price_sky_bus'), 'other');
        }
        if($request->has('number_sky_bus')){
            $this->addNewspaperPrice($lastinsert_ID, 'number_sky_bus', $request->input('number_sky_bus'), 'other');
        }
        if($request->has('duration_sky_bus')){
            $this->addNewspaperPrice($lastinsert_ID, 'duration_sky_bus', $request->input('duration_sky_bus'), 'other');
        }

        if($request->has('price_ear_panel')){
            $this->addNewspaperPrice($lastinsert_ID, 'price_ear_panel', $request->input('price_ear_panel'), 'other');
        }
        if($request->has('number_ear_panel')){
            $this->addNewspaperPrice($lastinsert_ID, 'number_ear_panel', $request->input('number_ear_panel'), 'other');
        }
        if($request->has('duration_ear_panel')){
            $this->addNewspaperPrice($lastinsert_ID, 'duration_ear_panel', $request->input('duration_ear_panel'), 'other');
        }
  
        if($request->has('price_half_page')){
            $this->addNewspaperPrice($lastinsert_ID, 'price_half_page', $request->input('price_half_page'), 'other');
        }
        if($request->has('number_half_page')){
            $this->addNewspaperPrice($lastinsert_ID, 'number_half_page', $request->input('number_half_page'), 'other');
        }
        if($request->has('duration_half_page')){
            $this->addNewspaperPrice($lastinsert_ID, 'duration_half_page', $request->input('duration_half_page'), 'other');
        }
        
        if($request->has('price_quarter_page')){
            $this->addNewspaperPrice($lastinsert_ID, 'price_quarter_page', $request->input('price_quarter_page'), 'other');
        }
        if($request->has('number_quarter_page')){
            $this->addNewspaperPrice($lastinsert_ID, 'number_quarter_page', $request->input('number_quarter_page'), 'other');
        }
        if($request->has('duration_quarter_page')){
            $this->addNewspaperPrice($lastinsert_ID, 'duration_quarter_page', $request->input('duration_quarter_page'), 'other');
        }
        
        if($request->has('price_pamphlets')){
            $this->addNewspaperPrice($lastinsert_ID, 'price_pamphlets', $request->input('price_pamphlets'), 'other');
        }
        if($request->has('number_pamphlets')){
            $this->addNewspaperPrice($lastinsert_ID, 'number_pamphlets', $request->input('number_pamphlets'), 'other');
        }
        if($request->has('duration_pamphlets')){
            $this->addNewspaperPrice($lastinsert_ID, 'duration_pamphlets', $request->input('duration_pamphlets'), 'other');
        }
  
        if($request->has('price_flyers')){
            $this->addNewspaperPrice($lastinsert_ID, 'price_flyers', $request->input('price_flyers'), 'other');
        }
        if($request->has('number_flyers')){
            $this->addNewspaperPrice($lastinsert_ID, 'number_flyers', $request->input('number_flyers'), 'other');
        }
        if($request->has('duration_flyers')){
            $this->addNewspaperPrice($lastinsert_ID, 'duration_flyers', $request->input('duration_flyers'), 'other');
        }
        //classified options

        if($request->has('price_matrimonial')){
            $this->addNewspaperPrice($lastinsert_ID, 'price_matrimonial', $request->input('price_matrimonial'), 'classified');
        }
        if($request->has('number_matrimonial')){
            $this->addNewspaperPrice($lastinsert_ID, 'number_matrimonial', $request->input('number_matrimonial'), 'classified');
        }
        if($request->has('duration_matrimonial')){
            $this->addNewspaperPrice($lastinsert_ID, 'duration_matrimonial', $request->input('duration_matrimonial'), 'classified');
        }
        
        if($request->has('price_recruitment')){
            $this->addNewspaperPrice($lastinsert_ID, 'price_recruitment', $request->input('price_recruitment'), 'classified');
        }
        if($request->has('number_recruitment')){
            $this->addNewspaperPrice($lastinsert_ID, 'number_recruitment', $request->input('number_recruitment'), 'classified');
        }
        if($request->has('duration_recruitment')){
            $this->addNewspaperPrice($lastinsert_ID, 'duration_recruitment', $request->input('duration_recruitment'), 'classified');
        }
        
        if($request->has('price_business')){
            $this->addNewspaperPrice($lastinsert_ID, 'price_business', $request->input('price_business'), 'classified');
        }
        if($request->has('number_business')){
            $this->addNewspaperPrice($lastinsert_ID, 'number_business', $request->input('number_business'), 'classified');
        }
        if($request->has('duration_business')){
            $this->addNewspaperPrice($lastinsert_ID, 'duration_business', $request->input('duration_business'), 'classified');
        }
        
        if($request->has('price_property')){
            $this->addNewspaperPrice($lastinsert_ID, 'price_property', $request->input('price_property'), 'classified');
        }
        if($request->has('number_property')){
            $this->addNewspaperPrice($lastinsert_ID, 'number_property', $request->input('number_property'), 'classified');
        }
        if($request->has('duration_property')){
            $this->addNewspaperPrice($lastinsert_ID, 'duration_property', $request->input('duration_property'), 'classified');
        }
        
        if($request->has('price_education')){
            $this->addNewspaperPrice($lastinsert_ID, 'price_education', $request->input('price_education'), 'classified');
        }
        if($request->has('number_education')){
            $this->addNewspaperPrice($lastinsert_ID, 'number_education', $request->input('number_education'), 'classified');
        }
        if($request->has('duration_education')){
            $this->addNewspaperPrice($lastinsert_ID, 'duration_education', $request->input('duration_education'), 'classified');
        }
        
        if($request->has('price_astrology')){
            $this->addNewspaperPrice($lastinsert_ID, 'price_astrology', $request->input('price_astrology'), 'classified');
        }
        if($request->has('number_astrology')){
            $this->addNewspaperPrice($lastinsert_ID, 'number_astrology', $request->input('number_astrology'), 'classified');
        }
        if($request->has('duration_astrology')){
            $this->addNewspaperPrice($lastinsert_ID, 'duration_astrology', $request->input('duration_astrology'), 'classified');
        }
        
        if($request->has('price_public_notices')){
            $this->addNewspaperPrice($lastinsert_ID, 'price_public_notices', $request->input('price_public_notices'), 'classified');
        }
        if($request->has('number_public_notices')){
            $this->addNewspaperPrice($lastinsert_ID, 'number_public_notices', $request->input('number_public_notices'), 'classified');
        }
        if($request->has('duration_public_notices')){
            $this->addNewspaperPrice($lastinsert_ID, 'duration_public_notices', $request->input('duration_public_notices'), 'classified');
        }
        
        if($request->has('price_services')){
            $this->addNewspaperPrice($lastinsert_ID, 'price_services', $request->input('price_services'), 'classified');
        }
        if($request->has('number_services')){
            $this->addNewspaperPrice($lastinsert_ID, 'number_services', $request->input('number_services'), 'classified');
        }
        if($request->has('duration_services')){
            $this->addNewspaperPrice($lastinsert_ID, 'duration_services', $request->input('duration_services'), 'classified');
        }
        
        if($request->has('price_automobile')){
            $this->addNewspaperPrice($lastinsert_ID, 'price_automobile', $request->input('price_automobile'), 'classified');
        }
        if($request->has('number_automobile')){
            $this->addNewspaperPrice($lastinsert_ID, 'number_automobile', $request->input('number_automobile'), 'classified');
        }
        if($request->has('duration_automobile')){
            $this->addNewspaperPrice($lastinsert_ID, 'duration_automobile', $request->input('duration_automobile'), 'classified');
        }

        if($request->has('price_shopping')){
            $this->addNewspaperPrice($lastinsert_ID, 'price_shopping', $request->input('price_shopping'), 'classified');
        }
        if($request->has('number_shopping')){
            $this->addNewspaperPrice($lastinsert_ID, 'number_shopping', $request->input('number_shopping'), 'classified');
        }
        if($request->has('duration_shopping')){
            $this->addNewspaperPrice($lastinsert_ID, 'duration_shopping', $request->input('duration_shopping'), 'classified');
        }

        //pricing options
        
        if($request->has('price_per_sq_cm')){
            $this->addNewspaperPrice($lastinsert_ID, 'price_per_sq_cm', $request->input('price_per_sq_cm'), 'pricing');
        }
        if($request->has('number_per_sq_cm')){
            $this->addNewspaperPrice($lastinsert_ID, 'number_per_sq_cm', $request->input('number_per_sq_cm'), 'pricing');
        }
        if($request->has('duration_per_sq_cm')){
            $this->addNewspaperPrice($lastinsert_ID, 'duration_per_sq_cm', $request->input('duration_per_sq_cm'), 'pricing');
        }
        
        if($request->has('price_per_day')){
            $this->addNewspaperPrice($lastinsert_ID, 'price_per_day', $request->input('price_per_day'), 'pricing');
        }
        if($request->has('number_per_day')){
            $this->addNewspaperPrice($lastinsert_ID, 'number_per_day', $request->input('number_per_day'), 'pricing');
        }
        if($request->has('duration_per_day')){
            $this->addNewspaperPrice($lastinsert_ID, 'duration_per_day', $request->input('duration_per_day'), 'pricing');
        }
  
        if($request->has('price_per_inserts')){
            $this->addNewspaperPrice($lastinsert_ID, 'price_per_inserts', $request->input('price_per_inserts'), 'pricing');
        }
        if($request->has('number_per_inserts')){
            $this->addNewspaperPrice($lastinsert_ID, 'number_per_inserts', $request->input('number_per_inserts'), 'pricing');
        }
        if($request->has('duration_per_inserts')){
            $this->addNewspaperPrice($lastinsert_ID, 'duration_per_inserts', $request->input('duration_per_inserts'), 'pricing');
        }
 
     
        //return to newspaper product list
       return redirect()->route('dashboard.getNewspaperList')->with('message', 'Successfully Added!');
    }

    //insert price data to newspaper price table
    public function addNewspaperPrice($id, $key, $value, $type)
    {
        $insert = new Newspapersprice();
        
        $insert->newspapers_id = $id;
        $insert->price_key = $key;
        $insert->price_value = $value;
        $insert->option_type = $type;
        $insert->save();

    }

    // delete newspaper product and price form db tables

    public function getDeleteNewspaperad($newspaperadID)
    {
        $delele_newspaperad = Newspapers::where('id', $newspaperadID)->first();
        $delele_newspaperad->delete();
        $delete_newspaperadprice = Newspapersprice::where('newspapers_id', $newspaperadID);
        $delete_newspaperadprice->delete();
        
        return redirect()->route('dashboard.getNewspaperList')->with(['message' => "Successfully Deleted From the List!"]);
    }

    // update newspaper product
    public function getUpdateeNewspaperad($ID)
    {
        $newspaperData = Newspapers::find($ID);
        $newspaperpriceData = Newspapersprice::where('newspapers_id', $ID)->get();
        $fieldData = array();
        $newspaperpriceDatas = Newspapersprice::where([
                                    ['newspapers_id', '=', $ID],
                                    ['price_key', 'like', 'price_%'],
                                ])->get();
        
        foreach($newspaperpriceDatas as $pricenewspaper){
           $fieldData[] = $pricenewspaper->price_key;
        }
       
        $name_key = array_chunk($fieldData, 3);
        $datta = array();
         $j = 0; 
		foreach($name_key as $options){
			$datta[$j] = ucwords(str_replace('_', ' ', substr($options[0], 6)));
			$j++;
		}
       $fieldDatas = serialize($datta);
        
        return view('backend.mediatypes.newspapers.newspaper-editform', ['newspaper' => $newspaperData, 'newspaperpricemeta' => $newspaperpriceData, 'fieldData' => $fieldDatas]);
    }
    //check and uncheck options remove
    public function getuncheckNewspaperadOptions(Request $request, $table)
    {
        $displayoptions =json_decode($request['displayoptions']);
        
        $count = Newspapersprice::where([
                                    ['newspapers_id', '=', $request['id']],
                                    ['price_key', '=', $request['price_key']],
                                ])->count();
        if($count > 0){
            Newspapers::where('id', $request['id'])->update([$request['option_type'] => serialize($displayoptions)]);
            $newspapersprice = Newspapersprice::where([
                                    ['newspapers_id', '=', $request['id']],
                                    ['price_key', '=', $request['price_key']]
                                ])->first();
            $newspapersprice->delete();
            $newspapersnumber = Newspapersprice::where([
                                    ['newspapers_id', '=', $request['id']],
                                    ['price_key', '=', $request['number_key']]
                                ])->first();
            $newspapersnumber->delete();
            $newspapersduration = Newspapersprice::where([
                                    ['newspapers_id', '=', $request['id']],
                                    ['price_key', '=', $request['duration_key']]
                                ])->first();
            $newspapersduration->delete();

            return response(['msg' => 'price deleted'], 200);
        }
              
            return response(['msg' => 'Value not present in db!'], 200);
        
    }

    public function postUpdateeNewspaperad(Request $request, $ID)
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

        $editnewspaper = Newspapers::find($ID);

         $editnewspaper->title = $request->input('title');
         $editnewspaper->price = $request->input('price');
         $editnewspaper->location = $request->input('location');
         $editnewspaper->state = $request->input('state');
         $editnewspaper->city = $request->input('city');
         $editnewspaper->rank = $request->input('rank');
         $editnewspaper->description = $request->input('description');
         $editnewspaper->status = $request->input('status');
         $editnewspaper->language = $request->input('language');
         $editnewspaper->references = $request->input('reference');
         $editnewspaper->general_options = serialize($request->input('newspaperdisplay'));
         $editnewspaper->other_options = serialize($request->input('otherdisplay'));
         $editnewspaper->classified_options = serialize($request->input('classifieddisplay'));
         $editnewspaper->pricing_options = serialize($request->input('pricingdisplay'));
          $editnewspaper->numberofnewspapers = $request->input('number');
          $editnewspaper->discount = $request->input('discount');
          $editnewspaper->circulations = $request->input('circulation');

        if($request->hasFile('image')){
            $file = $request->file('image');
            $filename = time() .'.'. $file->getClientOriginalExtension();
            $location = public_path("images\\newspapers\\" . $filename);
            Image::make($file)->resize(800, 400)->save($location);
            $oldimage = $editnewspaper->image;
            $editnewspaper->image = $filename;
        }

       $editnewspaper->update();

        //newspaper display prices insertion
        if($request->has('price_page1')){
            $this->updateNewspaperPrice($ID, 'price_page1', $request->input('price_page1'));
        }
      
       if($request->has('number_page1')){
            $this->updateNewspaperPrice($ID, 'number_page1', $request->input('number_page1'));
        }

       if($request->has('duration_page1')){
            $this->updateNewspaperPrice($ID, 'duration_page1', $request->input('duration_page1'));
        }


        if($request->has('price_page3')){
            $this->updateNewspaperPrice($ID, 'price_page3', $request->input('price_page3'));
        }
        if($request->has('number_page3')){
            $this->updateNewspaperPrice($ID, 'number_page3', $request->input('number_page3'));
        }
        if($request->has('duration_page3')){
            $this->updateNewspaperPrice($ID, 'duration_page3', $request->input('duration_page3'));
        }

             if($request->has('price_last_page')){
            $this->updateNewspaperPrice($ID, 'price_last_page', $request->input('price_last_page'));
        }
        if($request->has('number_last_page')){
            $this->updateNewspaperPrice($ID, 'number_last_page', $request->input('number_last_page'));
        }
        if($request->has('duration_last_page')){
            $this->updateNewspaperPrice($ID, 'duration_last_page', $request->input('duration_last_page'));
        }

             if($request->has('price_any_page')){
            $this->updateNewspaperPrice($ID, 'price_any_page', $request->input('price_any_page'));
        }
        if($request->has('number_any_page')){
            $this->updateNewspaperPrice($ID, 'number_any_page', $request->input('number_any_page'));
        }
        if($request->has('duration_any_page')){
            $this->updateNewspaperPrice($ID, 'duration_any_page', $request->input('duration_any_page'));
        }

         //other options

        if($request->has('price_jacket_front_page')){
            $this->updateNewspaperPrice($ID, 'price_jacket_front_page', $request->input('price_any_page'));
        }
        if($request->has('number_jacket_front_page')){
            $this->updateNewspaperPrice($ID, 'number_jacket_front_page', $request->input('number_jacket_front_page'));
        }
        if($request->has('duration_jacket_front_page')){
            $this->updateNewspaperPrice($ID, 'duration_jacket_front_page', $request->input('duration_jacket_front_page'));
        }

        if($request->has('price_jacket_front_inside')){
            $this->updateNewspaperPrice($ID, 'price_jacket_front_inside', $request->input('price_jacket_front_inside'));
        }
        if($request->has('number_jacket_front_inside')){
            $this->updateNewspaperPrice($ID, 'number_jacket_front_inside', $request->input('number_jacket_front_inside'));
        }
        if($request->has('duration_jacket_front_inside')){
            $this->updateNewspaperPrice($ID, 'duration_jacket_front_inside', $request->input('duration_jacket_front_inside'));
        }
        
        if($request->has('price_pointer_ad')){
            $this->updateNewspaperPrice($ID, 'price_pointer_ad', $request->input('price_pointer_ad'));
        }
        if($request->has('number_pointer_ad')){
            $this->updateNewspaperPrice($ID, 'number_pointer_ad', $request->input('number_pointer_ad'));
        }
        if($request->has('duration_pointer_ad')){
            $this->updateNewspaperPrice($ID, 'duration_pointer_ad', $request->input('duration_pointer_ad'));
        }
        
        if($request->has('price_sky_bus')){
            $this->updateNewspaperPrice($ID, 'price_sky_bus', $request->input('price_sky_bus'));
        }
        if($request->has('number_sky_bus')){
            $this->updateNewspaperPrice($ID, 'number_sky_bus', $request->input('number_sky_bus'));
        }
        if($request->has('duration_sky_bus')){
            $this->updateNewspaperPrice($ID, 'duration_sky_bus', $request->input('duration_sky_bus'));
        }

        if($request->has('price_ear_panel')){
            $this->updateNewspaperPrice($ID, 'price_ear_panel', $request->input('price_ear_panel'));
        }
        if($request->has('number_ear_panel')){
            $this->updateNewspaperPrice($ID, 'number_ear_panel', $request->input('number_ear_panel'));
        }
        if($request->has('duration_ear_panel')){
            $this->updateNewspaperPrice($ID, 'duration_ear_panel', $request->input('duration_ear_panel'));
        }
  
        if($request->has('price_half_page')){
            $this->updateNewspaperPrice($ID, 'price_half_page', $request->input('price_half_page'));
        }
        if($request->has('number_half_page')){
            $this->updateNewspaperPrice($ID, 'number_half_page', $request->input('number_half_page'));
        }
        if($request->has('duration_half_page')){
            $this->updateNewspaperPrice($ID, 'duration_half_page', $request->input('duration_half_page'));
        }
        
        if($request->has('price_quarter_page')){
            $this->updateNewspaperPrice($ID, 'price_quarter_page', $request->input('price_quarter_page'));
        }
        if($request->has('number_quarter_page')){
            $this->updateNewspaperPrice($ID, 'number_quarter_page', $request->input('number_quarter_page'));
        }
        if($request->has('duration_quarter_page')){
            $this->updateNewspaperPrice($ID, 'duration_quarter_page', $request->input('duration_quarter_page'));
        }
        
        if($request->has('price_pamphlets')){
            $this->updateNewspaperPrice($ID, 'price_pamphlets', $request->input('price_pamphlets'));
        }
        if($request->has('number_pamphlets')){
            $this->updateNewspaperPrice($ID, 'number_pamphlets', $request->input('number_pamphlets'));
        }
        if($request->has('duration_pamphlets')){
            $this->updateNewspaperPrice($ID, 'duration_pamphlets', $request->input('duration_pamphlets'));
        }
  
        if($request->has('price_flyers')){
            $this->updateNewspaperPrice($ID, 'price_flyers', $request->input('price_flyers'));
        }
        if($request->has('number_flyers')){
            $this->updateNewspaperPrice($ID, 'number_flyers', $request->input('number_flyers'));
        }
        if($request->has('duration_flyers')){
            $this->updateNewspaperPrice($ID, 'duration_flyers', $request->input('duration_flyers'));
        }
        //classified options

        if($request->has('price_matrimonial')){
            $this->updateNewspaperPrice($ID, 'price_matrimonial', $request->input('price_matrimonial'));
        }
        if($request->has('number_matrimonial')){
            $this->updateNewspaperPrice($ID, 'number_matrimonial', $request->input('number_matrimonial'));
        }
        if($request->has('duration_matrimonial')){
            $this->updateNewspaperPrice($ID, 'duration_matrimonial', $request->input('duration_matrimonial'));
        }
        
        if($request->has('price_recruitment')){
            $this->updateNewspaperPrice($ID, 'price_recruitment', $request->input('price_recruitment'));
        }
        if($request->has('number_recruitment')){
            $this->updateNewspaperPrice($ID, 'number_recruitment', $request->input('number_recruitment'));
        }
        if($request->has('duration_recruitment')){
            $this->updateNewspaperPrice($ID, 'duration_recruitment', $request->input('duration_recruitment'));
        }
        
        if($request->has('price_business')){
            $this->updateNewspaperPrice($ID, 'price_business', $request->input('price_business'));
        }
        if($request->has('number_business')){
            $this->updateNewspaperPrice($ID, 'number_business', $request->input('number_business'));
        }
        if($request->has('duration_business')){
            $this->updateNewspaperPrice($ID, 'duration_business', $request->input('duration_business'));
        }
        
        if($request->has('price_property')){
            $this->updateNewspaperPrice($ID, 'price_property', $request->input('price_property'));
        }
        if($request->has('number_property')){
            $this->updateNewspaperPrice($ID, 'number_property', $request->input('number_property'));
        }
        if($request->has('duration_property')){
            $this->updateNewspaperPrice($ID, 'duration_property', $request->input('duration_property'));
        }
        
        if($request->has('price_education')){
            $this->updateNewspaperPrice($ID, 'price_education', $request->input('price_education'));
        }
        if($request->has('number_education')){
            $this->updateNewspaperPrice($ID, 'number_education', $request->input('number_education'));
        }
        if($request->has('duration_education')){
            $this->updateNewspaperPrice($ID, 'duration_education', $request->input('duration_education'));
        }
        
        if($request->has('price_astrology')){
            $this->updateNewspaperPrice($ID, 'price_astrology', $request->input('price_astrology'));
        }
        if($request->has('number_astrology')){
            $this->updateNewspaperPrice($ID, 'number_astrology', $request->input('number_astrology'));
        }
        if($request->has('duration_astrology')){
            $this->updateNewspaperPrice($ID, 'duration_astrology', $request->input('duration_astrology'));
        }
        
        if($request->has('price_public_notices')){
            $this->updateNewspaperPrice($ID, 'price_public_notices', $request->input('price_public_notices'));
        }
        if($request->has('number_public_notices')){
            $this->updateNewspaperPrice($ID, 'number_public_notices', $request->input('number_public_notices'));
        }
        if($request->has('duration_public_notices')){
            $this->updateNewspaperPrice($ID, 'duration_public_notices', $request->input('duration_public_notices'));
        }
        
        if($request->has('price_services')){
            $this->updateNewspaperPrice($ID, 'price_services', $request->input('price_services'));
        }
        if($request->has('number_services')){
            $this->updateNewspaperPrice($ID, 'number_services', $request->input('number_services'));
        }
        if($request->has('duration_services')){
            $this->updateNewspaperPrice($ID, 'duration_services', $request->input('duration_services'));
        }
        
        if($request->has('price_automobile')){
            $this->updateNewspaperPrice($ID, 'price_automobile', $request->input('price_automobile'));
        }
        if($request->has('number_automobile')){
            $this->updateNewspaperPrice($ID, 'number_automobile', $request->input('number_automobile'));
        }
        if($request->has('duration_automobile')){
            $this->updateNewspaperPrice($ID, 'duration_automobile', $request->input('duration_automobile'));
        }

        if($request->has('price_shopping')){
            $this->updateNewspaperPrice($ID, 'price_shopping', $request->input('price_shopping'));
        }
        if($request->has('number_shopping')){
            $this->updateNewspaperPrice($ID, 'number_shopping', $request->input('number_shopping'));
        }
        if($request->has('duration_shopping')){
            $this->updateNewspaperPrice($ID, 'duration_shopping', $request->input('duration_shopping'));
        }

        //pricing options
        
        if($request->has('price_per_sq_cm')){
            $this->updateNewspaperPrice($ID, 'price_per_sq_cm', $request->input('price_per_sq_cm'));
        }
        if($request->has('number_per_sq_cm')){
            $this->updateNewspaperPrice($ID, 'number_per_sq_cm', $request->input('number_per_sq_cm'));
        }
        if($request->has('duration_per_sq_cm')){
            $this->updateNewspaperPrice($ID, 'duration_per_sq_cm', $request->input('duration_per_sq_cm'));
        }
        
        if($request->has('price_per_day')){
            $this->updateNewspaperPrice($ID, 'price_per_day', $request->input('price_per_day'));
        }
        if($request->has('number_per_day')){
            $this->updateNewspaperPrice($ID, 'number_per_day', $request->input('number_per_day'));
        }
        if($request->has('duration_per_day')){
            $this->updateNewspaperPrice($ID, 'duration_per_day', $request->input('duration_per_day'));
        }
  
        if($request->has('price_per_inserts')){
            $this->updateNewspaperPrice($ID, 'price_per_inserts', $request->input('price_per_inserts'));
        }
        if($request->has('number_per_inserts')){
            $this->updateNewspaperPrice($ID, 'number_per_inserts', $request->input('number_per_inserts'));
        }
        if($request->has('duration_per_inserts')){
            $this->updateNewspaperPrice($ID, 'duration_per_inserts', $request->input('duration_per_inserts'));
        }
 
        

        //return to newspaper product list
       return redirect()->route('dashboard.getNewspaperList')->with('message', 'Successfully Edited!');
    }

    public function updateNewspaperPrice( $id, $meta_key, $meta_value, $type){
        $count = Newspapersprice::where([
                                    ['newspapers_id', '=', $id],
                                    ['price_key', '=', $meta_key],
                                ])->count();
        if($count < 1){
            $this->addNewspaperPrice($id, $meta_key, $meta_value, $type);
        }else{
            $update = Newspapersprice::where([
                                    ['newspapers_id', '=', $id],
                                    ['price_key', '=', $meta_key],
                                ])->update(['price_value' => $meta_value]);
        }
        
   }

    //cart functions
   // add or remove item to cart
   public function getAddToCart(Request $request, $id, $variation)
   {
        $newspaper_ad = Newspapers::where('id', $id)->first()->toArray();
        
        $selectDisplayOpt = explode("+", $variation);

        $main_key = substr($selectDisplayOpt[1], 6);
        
        $number_key = "number_".$main_key;
        $duration_key = "duration_".$main_key;

        $newspaper_price = Newspapersprice::where([
                                    ['newspapers_id', '=', $id],
                                    ['price_key', '=', $selectDisplayOpt[1]],
                                ])->first()->toArray();

        $newspaper_number = Newspapersprice::where([
                                    ['newspapers_id', '=', $id],
                                    ['price_key', '=', $number_key],
                                ])->first()->toArray();
        $newspaper_duration = Newspapersprice::where([
                                    ['newspapers_id', '=', $id],
                                    ['price_key', '=', $duration_key],
                                ])->first()->toArray();
        $newspaper_change_price = array();
        foreach($newspaper_price as $key => $value){
            if($key == 'price_key'){
                $newspaper_change_price[$key] = $value;
            }
            if($key == 'price_value'){
               $newspaper_change_price[$key] = $value;
            }
        }
        $newspaper_change_num = array();
        foreach($newspaper_number as $key => $value){
            if($key == 'price_key'){
                $key = 'number_key';
                $newspaper_change_num[$key] = $value;
            }
            if($key == 'price_value'){
                $key = 'number_value';
                $newspaper_change_num[$key] = $value;
            }
        }
        $newspaper_change_duration = array();
        foreach($newspaper_duration as $key => $value){
            if($key == 'price_key'){
                $key = 'duration_key';
                $newspaper_change_duration[$key] = $value;
            }
            if($key == 'price_value'){
                $key = 'duration_value';
                $newspaper_change_duration[$key] = $value;
            }
        }
        $newspaper_merge = array_merge($newspaper_change_num, $newspaper_change_duration);
        
        $newspaper_price = array_merge($newspaper_change_price, $newspaper_merge);
        
        $newspaper_Ad = array_merge($newspaper_ad, $newspaper_price);
       
        $oldNewspaper = Session::has('cart') ? Session::get('cart') : null;
                
        $cart = new Cart($oldNewspaper);

        $cart->addorRemove($newspaper_Ad, $newspaper_ad['id'], 'newspapers'); //pass full newspaper details, id and model name like "newspapers"
        
        $request->session()->put('cart', $cart);
        //Session::forget('cart');

        return redirect()->back()->with(['status' => 'added']);
    }

 
}
