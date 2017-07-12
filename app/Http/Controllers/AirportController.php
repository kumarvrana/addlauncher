<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use Session;
use App\Airports;
use App\Airportsprice;
use App\Mainaddtype;
use Image;
use App\Product;
use Illuminate\Support\Facades\File;
use App\Cart;
use App\CartModel;
use App\Order;
use DB;

use Sentinel;

class AirportController extends Controller
{
	protected $airport_options;
	protected $airport_locations;
	public function __construct()
	{
		$this->middleware('admin', ['only' => ['getDashboardAirportList', 'getDashboardAirportForm', 'postDashboardAirportForm', 'addAirportPrice', 'getDeleteAirportad', 'getUpdateeAirportad', 'getuncheckAirportadOptions']]);
		$this->airport_options = array(
			'backlit_panel' => 'Backlit Panel',
			'luggage_trolley' => 'Luggage Trolley',
			'totems' => 'Totems',
			'video_wall' => 'Video Wall',
			'ambient_lit' => 'Ambient Lit',
			'sav'  => 'Sav',
			'backlit_flex' => 'Backlit Flex',
			'banner' => 'Banner',
			'digital_screens' => 'Digital Screens',
			'scroller' => 'Scroller',
			'frontlit_flex' => 'Frontlit Flex',
			'frontline_flex' => 'Frontline Flex'
		);
		$this->airport_locations = array( 
			'after_security_check' => 'After Security Check',
			'domestic_arrival' => 'Domestic Arrival',
			'arrival' => 'Arrival',
			'1c_arrival_area' => '1C Arrival Area',
			'arrival_area' => 'Arrival Area',
			'arrival_canyon' => 'Arrival Canyon',
			'arrival_check_in_hall' => 'Arrival Check In Hall',
			'arrival_concourse' => 'Arrival Concourse',
			'arrival_hall' => 'Arrival Hall',
			'arrival_outdoor' => 'Arrival Outdoor',
			'arrival_piers' => 'Arrival Piers',
			'departure_area' => 'Departure Area',
			'departure_check_in_hall' => 'Departure Check In Hall',
			'domestic_departure_canyon' => 'Domestic Departure Canyon',
			'domestic_departure_frisking' => 'Domestic Departure Frisking',
			'departure_indoor' => 'Departure Indoor',
			'departure_outdoor' => 'Departure Outdoor',
			'departure_piers' => 'Departure Piers',
			'domestic_departure_sha' => 'Domestic Departure Sha',
			'domestic_departure' => 'Domestic Departure',
			'international_arrival_canyon' => 'International Arrival Canyon',
			'check_in_hall' => 'Check In Hall'
		);

	}

	//frontend function starts
	
	public function getfrontendAllAirportads()
	{
	   
	   $location = 'Delhi NCR';
	   $media_type = new Mainaddtype();
	   $ad_cats = $media_type->mediatype('Airport');
	   $location_filter = Airports::select('location')->distinct()->get();
	   
		$airport_options_with_values = Airportsprice::select(['displayoption'])->distinct()->get();

		if($airport_options_with_values->isEmpty()){
			return view('partials.commingsoon');
		}

		$airport_options_array = [];
		foreach($airport_options_with_values as $value){
			$airport_options_array[$value->displayoption] = $this->airport_options[$value->displayoption];
		}
		// return $airport_options_array;
	   return view('frontend-mediatype.airports.airportads-list', ['airport_options' => $airport_options_array, 'location' => $location,'mediacat' => $ad_cats, 'filter_location'=>$location_filter]);
	}

	public function getfrontAirportadByOption($airportOption){
		$airports = new Airportsprice();
		$airports = $airports->getAirportByFilter($airportOption);
		if($airports->isEmpty()){
			return view('partials.comingsoon');
		}else{
			return view('frontend-mediatype.airports.airport-single', ['airports' => $airports, 'airportOption' => $airportOption]);
		}
	}
	// frontend functions ends

	//Backend functions below

	// get list of all the products in airport stop media type
	public function getDashboardAirportList()
	{
		$airport_ads = Airports::all();
		return view('backend.mediatypes.airports.airport-list', ['airport_ads' => $airport_ads]);
	}
	
	// get form of airport stop media type
	public function getDashboardAirportForm()
	{
		return view('backend.mediatypes.airports.airport-addform', ['airport_options' => $this->airport_options, 'airport_locations' => $this->airport_locations]);
	}

	// post list of all the products in airport media type

	public function postDashboardAirportForm(Request $request)
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
		   'reference_mail' => 'required',
		   'status' => 'required'
		]);

		if($request->hasFile('image')){
			$file = $request->file('image');
			$filename = time() .'.'. $file->getClientOriginalExtension();
			$location = public_path("/dev/images/airports/" . $filename);
			Image::make($file)->resize(800, 400)->save($location);
		}

		$airport = new Airports([
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
			//'display_options' => serialize($request->input('airportdisplay')),
			//'light_option' => $request->input('aplighting'),
			'discount' => $request->input('airportdiscount'),
			'airportnumber' => $request->input('airportsnumber'),
			'reference_mail' => $request->input('reference_mail')
		]);

		$airport->save();

		$lastinsert_ID = $airport->id;

		//airport display prices insertion

		$keys = array_keys($request->all());
		$count = 1;
		foreach($keys as $k ){
			if(strstr($k, 'airport_location') !== FALSE) {
				if($count === 1){
					$this->addAirportPrice($lastinsert_ID, $request->input('airport_location'), $request->input('airport_category'), $request->input('airport_dimensions'), $request->input('airport_price'), $request->input('airport_units'));
				}else{
					$alocation = 'airport_location'.$count;
					$acategory = 'airport_category'.$count;
					$adimension = 'airport_dimensions'.$count;
					$aprice = 'airport_price'.$count;
					$aunits = 'airport_units'.$count;
					$this->addAirportPrice($lastinsert_ID, $request->input($alocation), $request->input($acategory), $request->input($adimension), $request->input($aprice), $request->input($aunits));
				}
				$count++;
			} 
			
		} 
	   //return to airport product list
	   return redirect()->route('dashboard.getAirportList')->with('message', 'Successfully Added!');
	}

	//insert price data to airport price table
	public function addAirportPrice($id, $location, $category, $dimension, $price, $unit)
	{
		$insert = new Airportsprice();

		$insert->airports_id = $id;
		$insert->area = $location;
		$insert->displayoption = $category;
		$insert->dimensions = $dimension;
		$insert->optionprice = $price;
		$insert->units = $unit;
		$insert->ad_code = '';
		$insert->save();

	}

	// delete airport product and price form db tables

	public function getDeleteAirportad($airportadID)
	{
		$delele_airportad = Airports::where('id', $airportadID)->first();
		$delImage = $delele_airportad->image;          
		$delele_airportad->delete();
		$path = public_path();          
		$fullPath = $path."/dev/images/airports/";        
		$image_path = $fullPath.$delImage;        
		@unlink($image_path);  
		$delete_airportadprice = Airportsprice::where('airports_id', $airportadID);
		$delete_airportadprice->delete();
		return redirect()->route('dashboard.getAirportList')->with(['message' => "Successfully Deleted From the List!"]);
	}


	// update airport product

	public function getUpdateeAirportad($ID)
	{
	   
		$airportData = Airports::find($ID);
		// $airportpriceData = Airportsprice::where('airports_id', $ID)->get();
		// foreach($airportpriceData as $priceairport){
		// dd($priceairport);
		// }
				
		return view('backend.mediatypes.airports.airport-editform', ['airport_options'=> $this->airport_options, 'airport_locations' => $this->airport_locations, 'airport' => $airportData]);
	}
	//check and uncheck options remove

	public function getuncheckAirportadOptions(Request $request)
	{
	   
		$delete_airprice  = Airportsprice::where('id', '=', $request['deleteID'])->first();
		
		$delete_airprice->delete();
	

		
		return response(['message' => "Field Successfully Deleted!"], 200);
		
			  
	}

	// Update Airport product

	public function postUpdateeAirportad(Request $request, $ID)
	{
	   
		// dd($request->all());
	   $this->validate( $request, [
		   'title' => 'required',
		   'price' => 'numeric',
		   'location' => 'required',
		   'state' => 'required',
		   'city' => 'required',
		   'rank' => 'numeric',
		   'description' => 'required',
		   'reference_mail' => 'required',
		   'status' => 'required'
		]);

		$editairport = Airports::find($ID);

		 $editairport->title = $request->input('title');
		 $editairport->price = $request->input('price');
		 $editairport->location = $request->input('location');
		 $editairport->state = $request->input('state');
		 $editairport->city = $request->input('city');
		 $editairport->rank = $request->input('rank');
		 $editairport->landmark = $request->input('landmark');
		 $editairport->description = $request->input('description');
		 $editairport->status = $request->input('status');
		 $editairport->references = $request->input('reference');
		 // $editairport->display_options = serialize($request->input('airportdisplay'));
		 // $editairport->light_option = $request->input('aplighting');
		 $editairport->airportnumber = $request->input('airportsnumber');
		 $editairport->discount = $request->input('airportdiscount');
		 $editairport->reference_mail = $request->input('reference_mail');

		if($request->hasFile('image')){
			$file = $request->file('image');
			$filename = time() .'.'. $file->getClientOriginalExtension();
			$location = public_path("/dev/images/airports/" . $filename);
			Image::make($file)->resize(800, 400)->save($location);
			$oldimage = $editairport->image;
			$editairport->image = $filename;
		}

	   $editairport->update();

		Airportsprice::where('airports_id', '=', $ID)->delete();
		
	   $keys = array_keys($request->all());
		$count = 1;
		//dd($keys);
		foreach($keys as $k ){
			if(strstr($k, 'airport_location') !== FALSE) {
				if($count === 1){
					$this->addAirportPrice($ID, $request->input('airport_location'), $request->input('airport_category'), $request->input('airport_dimensions'), $request->input('airport_price'), $request->input('airport_units'));
				}else{
					
					$alocation = 'airport_location'.$count;
					
					if (strstr($k,  $alocation) !== FALSE)
					{                      
						$acategory = 'airport_category'.$count;
						$adimension = 'airport_dimensions'.$count;
						$aprice = 'airport_price'.$count;
						$aunits = 'airport_units'.$count;
						
						$this->addAirportPrice($ID, $request->input($alocation), $request->input($acategory), $request->input($adimension), $request->input($aprice), $request->input($aunits));
					}
				}
			   $count++;
			} 
			
		} 
		//return to airport product list

	   return redirect()->route('dashboard.getAirportList')->with('message', 'Successfully Edited!');
	}


   //Fliter Functions
   public function getFilterAirportAds(Request $request)
   {
		
		$airportPrice = new Airportsprice();
		$filterResults = $airportPrice->FilterAirportsAds($request->all());
		if(count($filterResults)>0){
			foreach($filterResults as $searchAirport){
				$this->airport_ads($searchAirport, $request->all());
			}

		}else{
			echo "<img src='../images/oops.jpg' class='img-responsive oops-img'>";
		}

		$content = ob_get_contents();
		ob_get_clean();
		return response('', 200);
  
   }

   public function airport_ads($searchAirport, $fileroptions)
   { 

		 ?>
	   <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12"> 
		<div class="pro-item"> 
			<div class=" cat-opt-img "> <img src="<?= asset('images/airports/'.$searchAirport->airport->image) ?>"> </div>
			<p class="font-1"> <?= $searchAirport->airport->title ?>, <?= $searchAirport->airport->state ?></p>
			<div class="cat_area">
				<p><b>Area: </b><?=  ucwords(str_replace('_', ' ', $searchAirport->area)) ?></p>
				<p><b>Dimension: </b><?= $searchAirport->dimensions ?></p>
			</div>
 
			<hr class="hr_1">
			<div class="row">
				<div class="col-md-6">
					<p class="font-3"> <span><?= ucwords(str_replace('_', ' ', $searchAirport->displayoption))?> Ad </span><br>for 1 Month</p>
					</div>
				<div class="col-md-6">
						<p class="font-4"><del class="lighter">Rs <?= $searchAirport->optionprice ?> </del><br>Rs <?= $searchAirport->optionprice ?> </p>
				</div>
			
			</div>

			<?php
			$options = $searchAirport->id;
			var_dump($options);
			$session_key = 'airports'.'_'.$searchAirport->id.'_'.$searchAirport->airport->id;
			$printsession = (array) Session::get('cart');
							
		   ?>
			<div class="clearfix"> 
				<button class="glass add-cartButton" data-href="<?= route('airport.addtocartAfterSearch', ['id' => $searchAirport->airport->id, 'variation' => $options, 'fileroption' => http_build_query($fileroptions)]) ?>">
				<?php
					if(count($printsession) > 0){
					 if(array_key_exists($session_key, $printsession['items'])){
					   echo "<span style='color: #47c7f6'><span class='lnr lnr-cross'></span> Remove From Cart </span>"; 
					}else{
						echo "<span class='lnr lnr-cart'></span> Advertise"; 
					}
					}else{
						echo "<span class='lnr lnr-cart'></span> Advertise";
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
		$airport_ad = Airports::where('id', $id)->get()->first()->toArray();

		$airport_price = Airportsprice::where('id', $variation)->get(array('airports_id', 'area', 'displayoption', 'dimensions', 'optionprice', 'units', 'ad_code'))->first()->toArray();
		$airport_price['variation_id'] = (int) $variation;
		
		$airport_Ad = array_merge($airport_ad, $airport_price);
		
		$oldCart = Session::has('cart') ? Session::get('cart') : null;
		
		$cart = new Cart($oldCart);

		$status = $cart->addorRemoveAirport($airport_Ad, $id, 'airports');
		
		$request->session()->put('cart', $cart);
		//Session::forget('cart');

		if($user = Sentinel::check()){
			
			$cart_model = new CartModel;
			$cart_model->update_cart_in_db($user->id);

		}else{

		}

		return redirect()->back()->with(['status' => $status]);
	}

	// Search Option

	public function getAddToCartBySearch(Request $request, $id, $variation, $fileroption)
	{
		$airport_ad = Airports::where('id', $id)->get()->first()->toArray();
		
		$airportPrice = new Airportsprice();
		$airport_price = $airportPrice->getAirportspriceCart($id, $variation);
	   
		$airport_Ad = array_merge($airport_ad, $airport_price);
	   
		$oldCart = Session::has('cart') ? Session::get('cart') : null;
				
		$cart = new Cart($oldCart);

		$status = $cart->addorRemoveAirport($airport_Ad, $airport_ad['id'], 'airports', $flag=true); //pass full airport details, id and model name like "airports"
		
		$request->session()->put('cart', $cart);
		Session::forget('cart');



		// $cart_model = new CartModel;
		// $cart_model->update_cart_in_db($cart);

		return response(['status' => $status, 'quatity' => $cart->totalQty, 'total' => $cart->totalPrice], 200);
	}
 
}
