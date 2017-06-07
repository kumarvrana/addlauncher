<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Http\Requests;
use Session;
use App\Newspapers;
use App\Newspapersprice;
use App\Magazineprice;
use Image;
use Illuminate\Support\Facades\File;
use App\cart;
use App\Order;
use Sentinel;


class NewspaperController extends Controller
{
    protected $printMedia_type;
    protected $magezineOption;
    protected $megazineGenre;
    protected $newspaper_options;
    protected $newspaperGenre;
    protected $toi;
    
    public function __construct()
    {
        $this->middleware('admin', ['only' => ['getDashboardNewspaperList', 'getDashboardNewspaperForm', 'postDashboardNewspaperForm', 'addNewspaperPrice', 'getDeleteNewspaperad', 'getUpdateeNewspaperad', 'getuncheckNewspaperadOptions']]);

        $this->printMedia_type = array('newspaper' => 'Newspaper', 'magazine' => 'Magazine');

        $this->magezineOption = array('full_page' => 'Full Page', 'half_page' => 'Half Page', 'strip_vertical' => 'Strip Vertical', 'strip_horizontal' => 'Strip Horizontal', 'double_spread' => 'Double Spread', 'half_double_spread' => 'Half Double Spread', 'inside_cover' => 'Inside Cover', 'back_cover' => 'Back Cover', 'centre_spread'=> 'Centre Spread', 'one_column' => 'One Column', 'two_columns' => 'Two Columns', 'quarter_page' => 'Quarter Page', 'last_page' => 'Last Page', 'centre_spread' => 'Centre spread','electronics_mart' => 'Electronics Mart');

        $this->megazineGenre = array('Political', 'Culture', 'Young Interest', 'Women interest', 'Examinations', 'Entertainment', 'Car & Bike', 'Information ', 'News', 'Kids', 'Agriculture', 'Allied Industries', 'Stories', 'Electronics', 'Technology');

        $this->newspaper_options = array('page1' => 'Page1', 'page3' => 'Page3', 'last_page' => 'Last Page', 'any_page' => 'Any Page', 'full_page' => 'Full Page', 'half_page' => 'Half Page', 'quarter_page' => 'Quarter Page', 'mini_a4' => 'Mini A4', 'full_page_centre_spread' => 'Full Page Centre Spread', 'mini_a4_centre_spread' => 'Mini A4 Centre Spread', 'horizontal_strip' => 'Horizontal Strip', 'vertical_strip' => 'Vertical Strip', 'page_3_horizontal_solus' => 'Page 3 Horizontal Solus', 'inside_front_cover' => 'Inside Front Cover', 'inside_back_cover' => 'Inside_Back_Cover', 'back_page' => 'Back Page', 'front_false_cover' => 'Front False Cover', 'front_and_back_false_cover' => 'Front And Back False Cover', 'front_gate_fold' => 'Front Gate Fold', 'reverse_gate_fold' => 'Reverse Gate Fold', 'front_and_back_tab' => 'Front And Back Tab', 'front_tab' => 'Front Tab', 'jacket_front_page' => 'Jacket Front Page', 'jacket_front_insider' => 'Jacket Front Inside','pointer_ad' => 'Pointer Ad');
      
         $this->newspaperGenre = array('matrimonial' => 'Matrimonial', 'recruitment' => 'Recruitment','business' => 'Business','property' => 'Property','education' => 'Education','astrology' => 'Astrology','public_notices' => 'Public Notices','services' => 'Services','automobile' => 'Automobile','shopping' => 'Shopping', 'appointment' =>'Appointment', 'computers' => 'Computers', 'personal' => 'Personal', 'travel' => 'Travel', 'package'=>'Package');

         $this->toi = array('matrimonial' => 'Matrimonial','business' => 'Business','property' => 'Property','education' => 'Education','public_notices' => 'Public Notices','services' => 'Services','automobile' => 'Automobile','shopping' => 'Shopping', 'appointment' =>'Appointment', 'computers' => 'Computers', 'personal' => 'Personal', 'travel' => 'Travel', 'package'=>'Package');
           
    }
        
     //frontend function starts
    public function getfrontendAllPrintMedia()
    {
        return view('frontend-mediatype.newspapers.printmedia');
    }

    public function getfrontendAllNewspaperads()
    {
       $newspaper_ads = Newspapers::Where('printmedia_type', '=', 'newspaper')->get();
       return view('frontend-mediatype.newspapers.newspaperads-list', ['products' => $newspaper_ads, 'printmediaType' => 'newspaper']);
    }

    public function getfrontendAllMagazineads()
    {
       $magazine_ads = Newspapers::Where('printmedia_type', '=', 'magazine')->get();
       return view('frontend-mediatype.newspapers.newspaperads-list', ['products' => $magazine_ads, 'printmediaType' => 'magazine']);
    }
    public function getfrontPrintMediaAd($printmedia, $slug)
    {
        $getprintmedia = new Newspapers();
        $id = $getprintmedia->getIDFromSlug($slug);
        if($printmedia === 'newspaper'){
            $priceData = Newspapersprice::where('newspaper_id', $id)->get();
        }else{
            $priceData = Magazineprice::where('magazine_id', $id)->get();
        }
       
       return view('frontend-mediatype.newspapers.newspaper-single', ['priceData' => $priceData, 'printmediaType' => $printmedia]);
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
     
       return view('backend.mediatypes.newspapers.newspaper-addform', [
                                                                'printMedia_type' => $this->printMedia_type,
                                                                'magezineOption' => $this->magezineOption,
                                                                'megazineGenre' => $this->megazineGenre,
                                                                'newspaper_options' => $this->newspaper_options,
                                                                'classified_options' => $this->newspaperGenre,
                                                                'toiOptions' => $this->toi]);
    }


    // post list of all the products in newspaper media type

    public function postDashboardNewspaperForm(Request $request)
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
                'printmedia_type' => $request->input('printmedia_type'),
                'printmedia_name' => $request->input('printmedia_name'),
                'genre' => serialize($request->input('genre')),
                'language' => $request->input('language'),
                'magazine_options' => serialize($request->input('magazinedisplay')),
                'general_options' => serialize($request->input('newspaperdisplay')),
                'circulations' => $request->input('circulation'),
                'discount' => $request->input('discount'),
                 'reference_mail' => $request->input('reference_mail')
        ]);
        $newspaper->slug = $newspaper->getUniqueSlug($request->input('title'));
        $newspaper->save();

        $lastinsert_ID = $newspaper->id;


        //newspaper display prices insertion
        if($newspaper->printmedia_type === 'magazine'){
            if($request->has('price_full_page')){
                $this->addMagazinePrice($lastinsert_ID, 'price_full_page', $request->input('price_full_page'), $request->input('number_half_page'), 'megazine');
            }
            if($request->has('price_half_page')){
                $this->addMagazinePrice($lastinsert_ID, 'price_half_page', $request->input('price_half_page'), $request->input('number_half_page'), 'megazine');
            }
            if($request->has('price_strip_vertical')){
                $this->addMagazinePrice($lastinsert_ID, 'price_strip_vertical', $request->input('price_strip_vertical'), $request->input('number_strip_vertical'), 'megazine');
            }
            if($request->has('price_strip_horizontal')){
                $this->addMagazinePrice($lastinsert_ID, 'price_strip_horizontal', $request->input('price_strip_horizontal'), $request->input('number_strip_horizontal'), 'megazine');
            }
            if($request->has('price_double_spread')){
                $this->addMagazinePrice($lastinsert_ID, 'price_double_spread', $request->input('price_double_spread'),$request->input('number_double_spread'), 'megazine');
            }
            if($request->has('price_half_double_spread')){
                $this->addMagazinePrice($lastinsert_ID, 'price_half_double_spread', $request->input('price_half_double_spread'), $request->input('number_half_double_spread'), 'megazine');
            }
            if($request->has('price_inside_cover')){
                $this->addMagazinePrice($lastinsert_ID, 'price_inside_cover', $request->input('price_inside_cover'), $request->input('number_inside_cover'), 'megazine');
            }
            if($request->has('price_back_cover')){
                $this->addMagazinePrice($lastinsert_ID, 'price_back_cover', $request->input('price_back_cover'),$request->input('number_back_cover'), 'megazine');
            }
           
            if($request->has('price_centre_spread')){
                $this->addMagazinePrice($lastinsert_ID, 'price_centre_spread', $request->input('price_centre_spread'),$request->input('number_centre_spread'), 'megazine');
            }
            if($request->has('price_one_column')){
                $this->addMagazinePrice($lastinsert_ID, 'price_one_column', $request->input('price_one_column'),$request->input('number_one_column'), 'megazine');
            }
            if($request->has('price_two_columns')){
                $this->addMagazinePrice($lastinsert_ID, 'price_two_columns', $request->input('price_two_columns'),$request->input('number_two_columns'), 'megazine');
            }
            if($request->has('price_quarter_page')){
                $this->addMagazinePrice($lastinsert_ID, 'price_quarter_page', $request->input('price_quarter_page'),$request->input('number_quarter_page'), 'megazine');
            }
            if($request->has('price_last_page')){
                $this->addMagazinePrice($lastinsert_ID, 'price_last_page', $request->input('price_last_page'),$request->input('number_last_page'), 'megazine');
            }
            if($request->has('price_centre_spread')){
                $this->addMagazinePrice($lastinsert_ID, 'price_centre_spread', $request->input('price_centre_spread'),$request->input('number_centre_spread'), 'megazine');
            }
            if($request->has('price_electronics_mart')){
                $this->addMagazinePrice($lastinsert_ID, 'price_electronics_mart', $request->input('price_electronics_mart'),$request->input('number_electronics_mart'), 'megazine');
            }
        }else{

            if($request->has('base_price_page1')){
                $this->addNewspaperPrice($lastinsert_ID, 'price_page1', $request->input('base_price_page1'),$request->input('add_on_price_page1'),$request->input('total_price_page1'),$request->input('genre_page1'),$request->input('rate_page1'),$request->input('color_page1'), 'newspaper');
            }
            
            if($request->has('base_price_page3')){
                $this->addNewspaperPrice($lastinsert_ID, 'price_page3', $request->input('base_price_page3'),$request->input('add_on_price_page3'),$request->input('total_price_page3'),$request->input('genre_page3'),$request->input('rate_page3'),$request->input('color_page3'), 'newspaper');
            }


            if($request->has('base_price_last_page')){
                $this->addNewspaperPrice($lastinsert_ID, 'price_last_page', $request->input('base_price_last_page'),$request->input('add_on_price_last_page'),$request->input('total_price_last_page'),$request->input('genre_last_page'),$request->input('rate_last_page'),$request->input('color_last_page'), 'newspaper');
            }
            

            if($request->has('base_price_any_page')){
                $this->addNewspaperPrice($lastinsert_ID, 'price_any_page', $request->input('base_price_any_page'),$request->input('add_on_price_any_page'),$request->input('total_price_any_page'),$request->input('genre_any_page'),$request->input('rate_any_page'),$request->input('color_any_page'), 'newspaper');
            }
            
            if($request->has('base_price_full_page')){
                $this->addNewspaperPrice($lastinsert_ID, 'price_full_page', $request->input('base_price_full_page'),$request->input('add_on_price_full_page'),$request->input('total_price_full_page'),$request->input('genre_full_page'),$request->input('rate_full_page'),$request->input('color_full_page'), 'newspaper');
            }

            if($request->has('base_price_half_page')){
                $this->addNewspaperPrice($lastinsert_ID, 'price_half_page', $request->input('base_price_half_page'),$request->input('add_on_price_half_page'),$request->input('total_price_half_page'),$request->input('genre_half_page'),$request->input('rate_half_page'),$request->input('color_half_page'), 'newspaper');
            }

            if($request->has('base_price_quarter_page')){
                $this->addNewspaperPrice($lastinsert_ID, 'price_quarter_page', $request->input('base_price_quarter_page'),$request->input('add_on_price_quarter_page'),$request->input('total_price_quarter_page'),$request->input('genre_quarter_page'),$request->input('rate_quarter_page'),$request->input('color_quarter_page'), 'newspaper');
            }

            if($request->has('base_price_mini_a4')){
                $this->addNewspaperPrice($lastinsert_ID, 'price_mini_a4', $request->input('base_price_mini_a4'),$request->input('add_on_price_mini_a4'),$request->input('total_price_mini_a4'),$request->input('genre_mini_a4'),$request->input('rate_mini_a4'),$request->input('color_mini_a4'), 'newspaper');
            }

            if($request->has('base_price_full_page_centre_spread')){
                $this->addNewspaperPrice($lastinsert_ID, 'price_full_page_centre_spread', $request->input('base_price_full_page_centre_spread'),$request->input('add_on_price_full_page_centre_spread'),$request->input('total_price_full_page_centre_spread'),$request->input('genre_full_page_centre_spread'),$request->input('rate_full_page_centre_spread'),$request->input('color_full_page_centre_spread'), 'newspaper');
            }

            if($request->has('base_price_mini_a4_centre_spread')){
                $this->addNewspaperPrice($lastinsert_ID, 'price_mini_a4_centre_spread', $request->input('base_price_mini_a4_centre_spread'),$request->input('add_on_price_mini_a4_centre_spread'),$request->input('total_price_mini_a4_centre_spread'),$request->input('genre_mini_a4_centre_spread'),$request->input('rate_mini_a4_centre_spread'),$request->input('color_mini_a4_centre_spread'), 'newspaper');
            }

            if($request->has('base_price_horizontal_strip')){
                $this->addNewspaperPrice($lastinsert_ID, 'price_horizontal_strip', $request->input('base_price_horizontal_strip'),$request->input('add_on_price_horizontal_strip'),$request->input('total_price_horizontal_strip'),$request->input('genre_horizontal_strip'),$request->input('rate_horizontal_strip'),$request->input('color_horizontal_strip'), 'newspaper');
            }

            if($request->has('base_price_vertical_strip')){
                $this->addNewspaperPrice($lastinsert_ID, 'price_vertical_strip', $request->input('base_price_vertical_strip'),$request->input('add_on_price_vertical_strip'),$request->input('total_price_vertical_strip'),$request->input('genre_vertical_strip'),$request->input('rate_vertical_strip'),$request->input('color_vertical_strip'), 'newspaper');
            }

            if($request->has('base_price_page_3_horizontal_solus')){
                $this->addNewspaperPrice($lastinsert_ID, 'price_page_3_horizontal_solus', $request->input('base_price_page_3_horizontal_solus'),$request->input('add_on_price_page_3_horizontal_solus'),$request->input('total_price_page_3_horizontal_solus'),$request->input('genre_page_3_horizontal_solus'),$request->input('rate_page_3_horizontal_solus'),$request->input('color_page_3_horizontal_solus'), 'newspaper');
            }

            if($request->has('base_price_inside_front_cover')){
                $this->addNewspaperPrice($lastinsert_ID, 'price_inside_front_cover', $request->input('base_price_inside_front_cover'),$request->input('add_on_price_inside_front_cover'),$request->input('total_price_inside_front_cover'),$request->input('genre_inside_front_cover'),$request->input('rate_inside_front_cover'),$request->input('color_inside_front_cover'), 'newspaper');
            }

            if($request->has('base_price_inside_back_cover')){
                $this->addNewspaperPrice($lastinsert_ID, 'price_inside_back_cover', $request->input('base_price_inside_back_cover'),$request->input('add_on_price_inside_back_cover'),$request->input('total_price_inside_back_cover'),$request->input('genre_inside_back_cover'),$request->input('rate_inside_back_cover'),$request->input('color_inside_back_cover'), 'newspaper');
            }

            if($request->has('base_price_back_page')){
                $this->addNewspaperPrice($lastinsert_ID, 'price_back_page', $request->input('base_price_back_page'),$request->input('add_on_price_back_page'),$request->input('total_price_back_page'),$request->input('genre_back_page'),$request->input('rate_back_page'),$request->input('color_back_page'), 'newspaper');
            }

            if($request->has('base_price_front_false_cover')){
                $this->addNewspaperPrice($lastinsert_ID, 'price_front_false_cover', $request->input('base_price_front_false_cover'),$request->input('add_on_price_front_false_cover'),$request->input('total_price_front_false_cover'),$request->input('genre_front_false_cover'),$request->input('rate_front_false_cover'),$request->input('color_front_false_cover'), 'newspaper');
            }

            if($request->has('base_price_front_and_back_false_cover')){
                $this->addNewspaperPrice($lastinsert_ID, 'price_front_and_back_false_cover', $request->input('base_price_front_and_back_false_cover'),$request->input('add_on_price_front_and_back_false_cover'),$request->input('total_price_front_and_back_false_cover'),$request->input('genre_front_and_back_false_cover'),$request->input('rate_front_and_back_false_cover'),$request->input('color_front_and_back_false_cover'), 'newspaper');
            }

            if($request->has('base_price_front_gate_fold')){
                $this->addNewspaperPrice($lastinsert_ID, 'price_front_gate_fold', $request->input('base_price_front_gate_fold'),$request->input('add_on_price_front_gate_fold'),$request->input('total_price_front_gate_fold'),$request->input('genre_front_gate_fold'),$request->input('rate_front_gate_fold'),$request->input('color_front_gate_fold'), 'newspaper');
            }

            if($request->has('base_price_reverse_gate_fold')){
                $this->addNewspaperPrice($lastinsert_ID, 'price_reverse_gate_fold', $request->input('base_price_reverse_gate_fold'),$request->input('add_on_price_reverse_gate_fold'),$request->input('total_price_reverse_gate_fold'),$request->input('genre_reverse_gate_fold'),$request->input('rate_reverse_gate_fold'),$request->input('color_reverse_gate_fold'), 'newspaper');
            }

            if($request->has('base_price_front_and_back_tab')){
                $this->addNewspaperPrice($lastinsert_ID, 'price_front_and_back_tab', $request->input('base_price_front_and_back_tab'),$request->input('add_on_price_front_and_back_tab'),$request->input('total_price_front_and_back_tab'),$request->input('genre_front_and_back_tab'),$request->input('rate_front_and_back_tab'),$request->input('color_front_and_back_tab'), 'newspaper');
            }

            if($request->has('base_price_front_tab')){
                $this->addNewspaperPrice($lastinsert_ID, 'price_front_tab', $request->input('base_price_front_tab'),$request->input('add_on_price_front_tab'),$request->input('total_price_front_tab'),$request->input('genre_front_tab'),$request->input('rate_front_tab'),$request->input('color_front_tab'), 'newspaper');
            }

            if($request->has('base_price_front_tab')){
                $this->addNewspaperPrice($lastinsert_ID, 'price_front_tab', $request->input('base_price_front_tab'),$request->input('add_on_price_front_tab'),$request->input('total_price_front_tab'),$request->input('genre_front_tab'),$request->input('rate_front_tab'),$request->input('color_front_tab'), 'newspaper');
            }

            if($request->has('base_price_jacket_front_page')){
                $this->addNewspaperPrice($lastinsert_ID, 'price_jacket_front_page', $request->input('base_price_jacket_front_page'),$request->input('add_on_price_jacket_front_page'),$request->input('total_price_jacket_front_page'),$request->input('genre_jacket_front_page'),$request->input('rate_jacket_front_page'),$request->input('color_jacket_front_page'), 'newspaper');
            }

            if($request->has('base_price_jacket_front_inside')){
                $this->addNewspaperPrice($lastinsert_ID, 'price_jacket_front_inside', $request->input('base_price_jacket_front_inside'),$request->input('add_on_price_jacket_front_inside'),$request->input('total_price_jacket_front_inside'),$request->input('genre_jacket_front_inside'),$request->input('rate_jacket_front_inside'),$request->input('color_jacket_front_inside'), 'newspaper');
            }

            if($request->has('base_price_pointer_ad')){
                $this->addNewspaperPrice($lastinsert_ID, 'price_pointer_ad', $request->input('base_price_pointer_ad'),$request->input('add_on_price_pointer_ad'),$request->input('total_price_pointer_ad'),$request->input('genre_pointer_ad'),$request->input('rate_pointer_ad'),$request->input('color_pointer_ad'), 'newspaper');
            }
            //TOI AND NAV Bharat options

            if($request->has('base_price_matrimonial')){
                $this->addNewspaperPrice($lastinsert_ID, 'price_matrimonial', $request->input('base_price_matrimonial'),$request->input('add_on_price_matrimonial'),$request->input('total_price_matrimonial'),$request->input('genre_matrimonial'),$request->input('rate_matrimonial'),$request->input('color_matrimonial'), 'newspaper');
            }
           
            
            if($request->has('base_price_business')){
                $this->addNewspaperPrice($lastinsert_ID, 'price_business', $request->input('base_price_business'),$request->input('add_on_price_business'),$request->input('total_price_business'),$request->input('genre_business'),$request->input('rate_business'),$request->input('color_business'), 'newspaper');
            }
           

            if($request->has('base_price_property')){
                $this->addNewspaperPrice($lastinsert_ID, 'price_property', $request->input('base_price_property'),$request->input('add_on_price_property'),$request->input('total_price_property'),$request->input('genre_property'),$request->input('rate_property'),$request->input('color_property'), 'newspaper');
            }
            
    
            if($request->has('base_price_education')){
                $this->addNewspaperPrice($lastinsert_ID, 'price_education', $request->input('base_price_education'),$request->input('add_on_price_education'),$request->input('total_price_education'),$request->input('genre_education'),$request->input('rate_education'),$request->input('color_education'), 'newspaper');
            }
           
            
            if($request->has('base_price_public_notices')){
                $this->addNewspaperPrice($lastinsert_ID, 'price_public_notices', $request->input('base_price_public_notices'),$request->input('add_on_price_public_notices'),$request->input('total_price_public_notices'),$request->input('genre_public_notices'),$request->input('rate_public_notices'),$request->input('color_public_notices'), 'newspaper');
            }
           
            
            if($request->has('base_price_services')){
                $this->addNewspaperPrice($lastinsert_ID, 'price_services', $request->input('base_price_services'),$request->input('add_on_price_services'),$request->input('total_price_services'),$request->input('genre_services'),$request->input('rate_services'),$request->input('color_services'), 'newspaper');
            }
           
    
            if($request->has('base_price_automobile')){
                $this->addNewspaperPrice($lastinsert_ID, 'price_automobile', $request->input('base_price_automobile'),$request->input('add_on_price_automobile'),$request->input('total_price_automobile'),$request->input('genre_automobile'),$request->input('rate_automobile'),$request->input('color_automobile'), 'newspaper');
            }

            if($request->has('base_price_shopping')){
                $this->addNewspaperPrice($lastinsert_ID, 'price_shopping', $request->input('base_price_shopping'),$request->input('add_on_price_shopping'),$request->input('total_price_shopping'),$request->input('genre_shopping'),$request->input('rate_shopping'),$request->input('color_shopping'), 'newspaper');
            }

            if($request->has('base_price_appointment')){
                $this->addNewspaperPrice($lastinsert_ID, 'price_appointment', $request->input('base_price_appointment'),$request->input('add_on_price_appointment'),$request->input('total_price_appointment'),$request->input('genre_appointment'),$request->input('rate_appointment'),$request->input('color_appointment'), 'newspaper');
            }

            if($request->has('base_price_computers')){
                $this->addNewspaperPrice($lastinsert_ID, 'price_computers', $request->input('base_price_computers'),$request->input('add_on_price_computers'),$request->input('total_price_computers'),$request->input('genre_computers'),$request->input('rate_computers'),$request->input('color_computers'), 'newspaper');
            }
            
            if($request->has('base_price_personal')){
                $this->addNewspaperPrice($lastinsert_ID, 'price_personal', $request->input('base_price_personal'),$request->input('add_on_price_personal'),$request->input('total_price_personal'),$request->input('genre_personal'),$request->input('rate_personal'),$request->input('color_personal'), 'newspaper');
            }

            if($request->has('base_price_travel')){
                $this->addNewspaperPrice($lastinsert_ID, 'price_travel', $request->input('base_price_travel'),$request->input('add_on_price_travel'),$request->input('total_price_travel'),$request->input('genre_travel'),$request->input('rate_travel'),$request->input('color_travel'), 'newspaper');
            }

            if($request->has('base_price_package')){
                $this->addNewspaperPrice($lastinsert_ID, 'price_package', $request->input('base_price_package'),$request->input('add_on_price_package'),$request->input('total_price_package'),$request->input('genre_package'),$request->input('rate_package'),$request->input('color_package'), 'newspaper');
            }
            
           
        }
   	   
     
        //return to newspaper product list
       return redirect()->route('dashboard.getNewspaperList')->with('message', 'Successfully Added!');
    }

    //insert price data to newspaper price table
    public function addNewspaperPrice($id, $key, $basePrice, $addonPrice, $totalPrice, $genre, $pricingOption, $color, $type)
    {
        $insert = new Newspapersprice();
        
        $insert->newspaper_id = $id;
        $insert->price_key = $key;
        $insert->base_price = $basePrice;
        $insert->addon_price = $addonPrice;
        $insert->total_price = $totalPrice;
        $insert->genre = $genre;
        $insert->pricing_type = $pricingOption;
        $insert->color = $color;
        $insert->option_type = $type;
        //$insert->ad_code = $adCode;
        $insert->save();

    }

    //insert price data to magazine price table
    public function addMagazinePrice($id, $key, $basePrice, $number, $type)
    {
        $insert = new Magazineprice();
        
        $insert->magazine_id = $id;
        $insert->price_key = $key;
        $insert->price_value = $basePrice;
        $insert->number_value = $number;
        //$insert->duration_value = $duration;
        $insert->option_type = $type;
        //$insert->ad_code = $adCode;
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
    public function getUpdateeNewspaperad($print_type, $ID)
    { 
        $newspaperData = Newspapers::where('id', $ID)->first();
        
        if($print_type === 'newspaper'){
            $priceData = Newspapersprice::where('newspaper_id', $ID)->get();
        }else{
            $priceData = Magazineprice::where('magazine_id', $ID)->get();
        }
       
        $fieldData = array();
                
        foreach($priceData as $pricenewspaper){
            if($pricenewspaper->price_key){
                $fieldData[] = ucwords(str_replace('_', ' ', substr($pricenewspaper->price_key, 6)));
            }
        }
        $fieldDatas = serialize($fieldData);
        
        return view('backend.mediatypes.newspapers.newspaper-editform', [
                                            'printmediaAd' => $newspaperData,
                                            'printMedia_type' => $this->printMedia_type,
                                            'pricemeta' => $priceData,
                                            'printType' => $print_type,
                                            'fieldData' => $fieldDatas,
                                            'magezineOption' => $this->magezineOption,
                                            'megazineGenre' =>  $this->megazineGenre,
                                            'newspaper_options' => $this->newspaper_options,
                                            'classified_options' => $this->newspaperGenre,
                                            'toiOptions' => $this->toi
                                        ]);
    }
    //check and uncheck options remove
    public function getuncheckNewspaperadOptions(Request $request, $table)
    {
        $displayoptions =json_decode($request['displayoptions']);
       
        if($request['printmedia_type'] === 'newspaper'){
            Newspapers::where('id', $request['id'])->update(['general_options' => serialize($displayoptions)]);
            $newspapersprice = Newspapersprice::where([
                                ['newspaper_id', '=', $request['id']],
                                ['price_key', '=', $request['price_key']]
                            ])->first();
            $newspapersprice->delete();
            return response(['msg' => 'price deleted'], 200);
        }
        if($request['printmedia_type'] === 'megazine'){
            Newspapers::where('id', $request['id'])->update(['magazine_options' => serialize($displayoptions)]);
            $magazinesprice = Magazineprice::where([
                                ['magazine_id', '=', $request['id']],
                                ['price_key', '=', $request['price_key']]
                            ])->first();
            $magazinesprice->delete();
            return response(['msg' => 'price deleted'], 200); 
        }

        return response(['msg' => 'Value not present in db!'], 500);
        
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
         $editnewspaper->printmedia_type = $editnewspaper->printmedia_type;
         $editnewspaper->printmedia_name = $editnewspaper->printmedia_name;
         $editnewspaper->genre = serialize($request->input('genre'));
         $editnewspaper->language = $request->input('language');
         $editnewspaper->magazine_options = serialize($request->input('magazinedisplay'));
         $editnewspaper->general_options = serialize($request->input('newspaperdisplay'));
         $editnewspaper->discount = $request->input('discount');
         $editnewspaper->circulations = $request->input('circulation');
         $editnewspaper->reference_mail = $request->input('reference_mail');

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
        if($editnewspaper->printmedia_type === 'magazine'){
            if($request->has('price_full_page')){
                $this->updateMagazinePrice($ID, 'price_full_page', $request->input('price_full_page'), $request->input('number_half_page'), 'megazine');
            }
            if($request->has('price_half_page')){
                $this->updateMagazinePrice($ID, 'price_half_page', $request->input('price_half_page'), $request->input('number_half_page'), 'megazine');
            }
            if($request->has('price_strip_vertical')){
                $this->updateMagazinePrice($ID, 'price_strip_vertical', $request->input('price_strip_vertical'), $request->input('number_strip_vertical'), 'megazine');
            }
            if($request->has('price_strip_horizontal')){
                $this->updateMagazinePrice($ID, 'price_strip_horizontal', $request->input('price_strip_horizontal'), $request->input('number_strip_horizontal'), 'megazine');
            }
            if($request->has('price_double_spread')){
                $this->updateMagazinePrice($ID, 'price_double_spread', $request->input('price_double_spread'),$request->input('number_double_spread'), 'megazine');
            }
            if($request->has('price_half_double_spread')){
                $this->updateMagazinePrice($ID, 'price_half_double_spread', $request->input('price_half_double_spread'), $request->input('number_half_double_spread'), 'megazine');
            }
            if($request->has('price_inside_cover')){
                $this->updateMagazinePrice($ID, 'price_inside_cover', $request->input('price_inside_cover'), $request->input('number_inside_cover'), 'megazine');
            }
            if($request->has('price_back_cover')){
                $this->updateMagazinePrice($ID, 'price_back_cover', $request->input('price_back_cover'),$request->input('number_back_cover'), 'megazine');
            }
           
            if($request->has('price_centre_spread')){
                $this->updateMagazinePrice($ID, 'price_centre_spread', $request->input('price_centre_spread'),$request->input('number_centre_spread'), 'megazine');
            }
            if($request->has('price_one_column')){
                $this->updateMagazinePrice($ID, 'price_one_column', $request->input('price_one_column'),$request->input('number_one_column'), 'megazine');
            }
            if($request->has('price_two_columns')){
                $this->updateMagazinePrice($ID, 'price_two_columns', $request->input('price_two_columns'),$request->input('number_two_columns'), 'megazine');
            }
            if($request->has('price_quarter_page')){
                $this->updateMagazinePrice($ID, 'price_quarter_page', $request->input('price_quarter_page'),$request->input('number_quarter_page'), 'megazine');
            }
            if($request->has('price_last_page')){
                $this->updateMagazinePrice($ID, 'price_last_page', $request->input('price_last_page'),$request->input('number_last_page'), 'megazine');
            }
            if($request->has('price_centre_spread')){
                $this->updateMagazinePrice($ID, 'price_centre_spread', $request->input('price_centre_spread'),$request->input('number_centre_spread'), 'megazine');
            }
            if($request->has('price_electronics_mart')){
                $this->updateMagazinePrice($ID, 'price_electronics_mart', $request->input('price_electronics_mart'),$request->input('number_electronics_mart'), 'megazine');
            }
        }else{

            if($request->has('base_price_page1')){
                $this->updateNewspaperPrice($ID, 'price_page1', $request->input('base_price_page1'),$request->input('add_on_price_page1'),$request->input('total_price_page1'),$request->input('genre_page1'),$request->input('rate_page1'),$request->input('color_page1'), 'newspaper');
            }
            
            if($request->has('base_price_page3')){
                $this->updateNewspaperPrice($ID, 'price_page3', $request->input('base_price_page3'),$request->input('add_on_price_page3'),$request->input('total_price_page3'),$request->input('genre_page3'),$request->input('rate_page3'),$request->input('color_page3'), 'newspaper');
            }


            if($request->has('base_price_last_page')){
                $this->updateNewspaperPrice($ID, 'price_last_page', $request->input('base_price_last_page'),$request->input('add_on_price_last_page'),$request->input('total_price_last_page'),$request->input('genre_last_page'),$request->input('rate_last_page'),$request->input('color_last_page'), 'newspaper');
            }
            

            if($request->has('base_price_any_page')){
                $this->updateNewspaperPrice($ID, 'price_any_page', $request->input('base_price_any_page'),$request->input('add_on_price_any_page'),$request->input('total_price_any_page'),$request->input('genre_any_page'),$request->input('rate_any_page'),$request->input('color_any_page'), 'newspaper');
            }
            
            if($request->has('base_price_full_page')){
                $this->updateNewspaperPrice($ID, 'price_full_page', $request->input('base_price_full_page'),$request->input('add_on_price_full_page'),$request->input('total_price_full_page'),$request->input('genre_full_page'),$request->input('rate_full_page'),$request->input('color_full_page'), 'newspaper');
            }

            if($request->has('base_price_half_page')){
                $this->updateNewspaperPrice($ID, 'price_half_page', $request->input('base_price_half_page'),$request->input('add_on_price_half_page'),$request->input('total_price_half_page'),$request->input('genre_half_page'),$request->input('rate_half_page'),$request->input('color_half_page'), 'newspaper');
            }

            if($request->has('base_price_quarter_page')){
                $this->updateNewspaperPrice($ID, 'price_quarter_page', $request->input('base_price_quarter_page'),$request->input('add_on_price_quarter_page'),$request->input('total_price_quarter_page'),$request->input('genre_quarter_page'),$request->input('rate_quarter_page'),$request->input('color_quarter_page'), 'newspaper');
            }

            if($request->has('base_price_mini_a4')){
                $this->updateNewspaperPrice($ID, 'price_mini_a4', $request->input('base_price_mini_a4'),$request->input('add_on_price_mini_a4'),$request->input('total_price_mini_a4'),$request->input('genre_mini_a4'),$request->input('rate_mini_a4'),$request->input('color_mini_a4'), 'newspaper');
            }

            if($request->has('base_price_full_page_centre_spread')){
                $this->updateNewspaperPrice($ID, 'price_full_page_centre_spread', $request->input('base_price_full_page_centre_spread'),$request->input('add_on_price_full_page_centre_spread'),$request->input('total_price_full_page_centre_spread'),$request->input('genre_full_page_centre_spread'),$request->input('rate_full_page_centre_spread'),$request->input('color_full_page_centre_spread'), 'newspaper');
            }

            if($request->has('base_price_mini_a4_centre_spread')){
                $this->updateNewspaperPrice($ID, 'price_mini_a4_centre_spread', $request->input('base_price_mini_a4_centre_spread'),$request->input('add_on_price_mini_a4_centre_spread'),$request->input('total_price_mini_a4_centre_spread'),$request->input('genre_mini_a4_centre_spread'),$request->input('rate_mini_a4_centre_spread'),$request->input('color_mini_a4_centre_spread'), 'newspaper');
            }

            if($request->has('base_price_horizontal_strip')){
                $this->updateNewspaperPrice($ID, 'price_horizontal_strip', $request->input('base_price_horizontal_strip'),$request->input('add_on_price_horizontal_strip'),$request->input('total_price_horizontal_strip'),$request->input('genre_horizontal_strip'),$request->input('rate_horizontal_strip'),$request->input('color_horizontal_strip'), 'newspaper');
            }

            if($request->has('base_price_vertical_strip')){
                $this->updateNewspaperPrice($ID, 'price_vertical_strip', $request->input('base_price_vertical_strip'),$request->input('add_on_price_vertical_strip'),$request->input('total_price_vertical_strip'),$request->input('genre_vertical_strip'),$request->input('rate_vertical_strip'),$request->input('color_vertical_strip'), 'newspaper');
            }

            if($request->has('base_price_page_3_horizontal_solus')){
                $this->updateNewspaperPrice($ID, 'price_page_3_horizontal_solus', $request->input('base_price_page_3_horizontal_solus'),$request->input('add_on_price_page_3_horizontal_solus'),$request->input('total_price_page_3_horizontal_solus'),$request->input('genre_page_3_horizontal_solus'),$request->input('rate_page_3_horizontal_solus'),$request->input('color_page_3_horizontal_solus'), 'newspaper');
            }

            if($request->has('base_price_inside_front_cover')){
                $this->updateNewspaperPrice($ID, 'price_inside_front_cover', $request->input('base_price_inside_front_cover'),$request->input('add_on_price_inside_front_cover'),$request->input('total_price_inside_front_cover'),$request->input('genre_inside_front_cover'),$request->input('rate_inside_front_cover'),$request->input('color_inside_front_cover'), 'newspaper');
            }

            if($request->has('base_price_inside_back_cover')){
                $this->updateNewspaperPrice($ID, 'price_inside_back_cover', $request->input('base_price_inside_back_cover'),$request->input('add_on_price_inside_back_cover'),$request->input('total_price_inside_back_cover'),$request->input('genre_inside_back_cover'),$request->input('rate_inside_back_cover'),$request->input('color_inside_back_cover'), 'newspaper');
            }

            if($request->has('base_price_back_page')){
                $this->updateNewspaperPrice($ID, 'price_back_page', $request->input('base_price_back_page'),$request->input('add_on_price_back_page'),$request->input('total_price_back_page'),$request->input('genre_back_page'),$request->input('rate_back_page'),$request->input('color_back_page'), 'newspaper');
            }

            if($request->has('base_price_front_false_cover')){
                $this->updateNewspaperPrice($ID, 'price_front_false_cover', $request->input('base_price_front_false_cover'),$request->input('add_on_price_front_false_cover'),$request->input('total_price_front_false_cover'),$request->input('genre_front_false_cover'),$request->input('rate_front_false_cover'),$request->input('color_front_false_cover'), 'newspaper');
            }

            if($request->has('base_price_front_and_back_false_cover')){
                $this->updateNewspaperPrice($ID, 'price_front_and_back_false_cover', $request->input('base_price_front_and_back_false_cover'),$request->input('add_on_price_front_and_back_false_cover'),$request->input('total_price_front_and_back_false_cover'),$request->input('genre_front_and_back_false_cover'),$request->input('rate_front_and_back_false_cover'),$request->input('color_front_and_back_false_cover'), 'newspaper');
            }

            if($request->has('base_price_front_gate_fold')){
                $this->updateNewspaperPrice($ID, 'price_front_gate_fold', $request->input('base_price_front_gate_fold'),$request->input('add_on_price_front_gate_fold'),$request->input('total_price_front_gate_fold'),$request->input('genre_front_gate_fold'),$request->input('rate_front_gate_fold'),$request->input('color_front_gate_fold'), 'newspaper');
            }

            if($request->has('base_price_reverse_gate_fold')){
                $this->updateNewspaperPrice($ID, 'price_reverse_gate_fold', $request->input('base_price_reverse_gate_fold'),$request->input('add_on_price_reverse_gate_fold'),$request->input('total_price_reverse_gate_fold'),$request->input('genre_reverse_gate_fold'),$request->input('rate_reverse_gate_fold'),$request->input('color_reverse_gate_fold'), 'newspaper');
            }

            if($request->has('base_price_front_and_back_tab')){
                $this->updateNewspaperPrice($ID, 'price_front_and_back_tab', $request->input('base_price_front_and_back_tab'),$request->input('add_on_price_front_and_back_tab'),$request->input('total_price_front_and_back_tab'),$request->input('genre_front_and_back_tab'),$request->input('rate_front_and_back_tab'),$request->input('color_front_and_back_tab'), 'newspaper');
            }

            if($request->has('base_price_front_tab')){
                $this->updateNewspaperPrice($ID, 'price_front_tab', $request->input('base_price_front_tab'),$request->input('add_on_price_front_tab'),$request->input('total_price_front_tab'),$request->input('genre_front_tab'),$request->input('rate_front_tab'),$request->input('color_front_tab'), 'newspaper');
            }

            if($request->has('base_price_front_tab')){
                $this->updateNewspaperPrice($ID, 'price_front_tab', $request->input('base_price_front_tab'),$request->input('add_on_price_front_tab'),$request->input('total_price_front_tab'),$request->input('genre_front_tab'),$request->input('rate_front_tab'),$request->input('color_front_tab'), 'newspaper');
            }

            if($request->has('base_price_jacket_front_page')){
                $this->updateNewspaperPrice($ID, 'price_jacket_front_page', $request->input('base_price_jacket_front_page'),$request->input('add_on_price_jacket_front_page'),$request->input('total_price_jacket_front_page'),$request->input('genre_jacket_front_page'),$request->input('rate_jacket_front_page'),$request->input('color_jacket_front_page'), 'newspaper');
            }

            if($request->has('base_price_jacket_front_inside')){
                $this->updateNewspaperPrice($ID, 'price_jacket_front_inside', $request->input('base_price_jacket_front_inside'),$request->input('add_on_price_jacket_front_inside'),$request->input('total_price_jacket_front_inside'),$request->input('genre_jacket_front_inside'),$request->input('rate_jacket_front_inside'),$request->input('color_jacket_front_inside'), 'newspaper');
            }

            if($request->has('base_price_pointer_ad')){
                $this->updateNewspaperPrice($ID, 'price_pointer_ad', $request->input('base_price_pointer_ad'),$request->input('add_on_price_pointer_ad'),$request->input('total_price_pointer_ad'),$request->input('genre_pointer_ad'),$request->input('rate_pointer_ad'),$request->input('color_pointer_ad'), 'newspaper');
            }
            //TOI AND NAV Bharat options

            if($request->has('base_price_matrimonial')){
                $this->updateNewspaperPrice($ID, 'price_matrimonial', $request->input('base_price_matrimonial'),$request->input('add_on_price_matrimonial'),$request->input('total_price_matrimonial'),$request->input('genre_matrimonial'),$request->input('rate_matrimonial'),$request->input('color_matrimonial'), 'newspaper');
            }
           
            
            if($request->has('base_price_business')){
                $this->updateNewspaperPrice($ID, 'price_business', $request->input('base_price_business'),$request->input('add_on_price_business'),$request->input('total_price_business'),$request->input('genre_business'),$request->input('rate_business'),$request->input('color_business'), 'newspaper');
            }
           

            if($request->has('base_price_property')){
                $this->updateNewspaperPrice($ID, 'price_property', $request->input('base_price_property'),$request->input('add_on_price_property'),$request->input('total_price_property'),$request->input('genre_property'),$request->input('rate_property'),$request->input('color_property'), 'newspaper');
            }
            
    
            if($request->has('base_price_education')){
                $this->updateNewspaperPrice($ID, 'price_education', $request->input('base_price_education'),$request->input('add_on_price_education'),$request->input('total_price_education'),$request->input('genre_education'),$request->input('rate_education'),$request->input('color_education'), 'newspaper');
            }
           
            
            if($request->has('base_price_public_notices')){
                $this->updateNewspaperPrice($ID, 'price_public_notices', $request->input('base_price_public_notices'),$request->input('add_on_price_public_notices'),$request->input('total_price_public_notices'),$request->input('genre_public_notices'),$request->input('rate_public_notices'),$request->input('color_public_notices'), 'newspaper');
            }
           
            
            if($request->has('base_price_services')){
                $this->updateNewspaperPrice($ID, 'price_services', $request->input('base_price_services'),$request->input('add_on_price_services'),$request->input('total_price_services'),$request->input('genre_services'),$request->input('rate_services'),$request->input('color_services'), 'newspaper');
            }
           
    
            if($request->has('base_price_automobile')){
                $this->updateNewspaperPrice($ID, 'price_automobile', $request->input('base_price_automobile'),$request->input('add_on_price_automobile'),$request->input('total_price_automobile'),$request->input('genre_automobile'),$request->input('rate_automobile'),$request->input('color_automobile'), 'newspaper');
            }

            if($request->has('base_price_shopping')){
                $this->updateNewspaperPrice($ID, 'price_shopping', $request->input('base_price_shopping'),$request->input('add_on_price_shopping'),$request->input('total_price_shopping'),$request->input('genre_shopping'),$request->input('rate_shopping'),$request->input('color_shopping'), 'newspaper');
            }

            if($request->has('base_price_appointment')){
                $this->updateNewspaperPrice($ID, 'price_appointment', $request->input('base_price_appointment'),$request->input('add_on_price_appointment'),$request->input('total_price_appointment'),$request->input('genre_appointment'),$request->input('rate_appointment'),$request->input('color_appointment'), 'newspaper');
            }

            if($request->has('base_price_computers')){
                $this->updateNewspaperPrice($ID, 'price_computers', $request->input('base_price_computers'),$request->input('add_on_price_computers'),$request->input('total_price_computers'),$request->input('genre_computers'),$request->input('rate_computers'),$request->input('color_computers'), 'newspaper');
            }
            
            if($request->has('base_price_personal')){
                $this->updateNewspaperPrice($ID, 'price_personal', $request->input('base_price_personal'),$request->input('add_on_price_personal'),$request->input('total_price_personal'),$request->input('genre_personal'),$request->input('rate_personal'),$request->input('color_personal'), 'newspaper');
            }

            if($request->has('base_price_travel')){
                $this->updateNewspaperPrice($ID, 'price_travel', $request->input('base_price_travel'),$request->input('add_on_price_travel'),$request->input('total_price_travel'),$request->input('genre_travel'),$request->input('rate_travel'),$request->input('color_travel'), 'newspaper');
            }

            if($request->has('base_price_package')){
                $this->updateNewspaperPrice($ID, 'price_package', $request->input('base_price_package'),$request->input('add_on_price_package'),$request->input('total_price_package'),$request->input('genre_package'),$request->input('rate_package'),$request->input('color_package'), 'newspaper');
            }
            
           
        }

        //return to newspaper product list
       return redirect()->route('dashboard.getNewspaperList')->with('message', 'Successfully Edited!');
    }
    
    //update price data for newspaper
    public function updateNewspaperPrice($id, $key, $basePrice, $addonPrice, $totalPrice, $genre, $pricingOption, $color, $type){
        $count = Newspapersprice::where([
                                    ['newspaper_id', '=', $id],
                                    ['price_key', '=', $key],
                                ])->count();
        if($count < 1){
            $this->addNewspaperPrice($id, $key, $basePrice, $addonPrice, $totalPrice, $genre, $pricingOption, $color, $type);
        }else{
            $update = Newspapersprice::where([
                                    ['newspaper_id', '=', $id],
                                    ['price_key', '=', $key],
                                ])->update(['base_price' => $basePrice, 'addon_price' => $addonPrice, 'total_price' => $totalPrice, 'genre' => $genre, 'pricing_type' => $pricingOption, 'color' => $color, 'option_type' => $type]);
        }
        
   }
   //update magazine price data
    public function updateMagazinePrice($id, $key, $basePrice, $number, $type){
        $count = Magazineprice::where([
                                    ['magazine_id', '=', $id],
                                    ['price_key', '=', $key],
                                ])->count();
        if($count < 1){
            $this->addMagazinePrice($id, $key, $basePrice, $number, $type);
        }else{
            $update = Magazineprice::where([
                                    ['magazine_id', '=', $id],
                                    ['price_key', '=', $key],
                                ])->update(['price_value' => $basePrice, 'number_value' => $number]);
        }
        
   }
    //cart functions
   // add or remove item to cart
   public function getAddToCart(Request $request, $id, $variation)
   {
        $newspaper_ad = Newspapers::where('id', $id)->first()->toArray();

        $printmedia = $newspaper_ad['printmedia_type'];

        if($printmedia === 'magazine'){
            $Magazineprice = new Magazineprice();
            $priceData = $Magazineprice->getMagazinePriceCart($id, $variation);
        }else{
            $Newspapersprice = new Newspapersprice();
            $priceData = $Newspapersprice->getNewspaperPriceCart($id, $variation);
        }
              
        $newspaper_Ad = array_merge($newspaper_ad, $priceData);
        
        $oldNewspaper = Session::has('cart') ? Session::get('cart') : null;
                
        $cart = new Cart($oldNewspaper);

        $cart->addorRemovePrintmedia($newspaper_Ad, $newspaper_ad['id'], $printmedia, $flag=true); //pass full newspaper details, id and model name like "newspapers"
       
        $request->session()->put('cart', $cart);
        
        //Session::forget('cart');

        return redirect()->back()->with(['status' => 'added']);
    }

 
}
