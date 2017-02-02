<?php

namespace App\Http\Controllers;

use App\Product;
use App\Mainaddtype;
use App\Cart;
use App\Order;
use Illuminate\Http\Request;
use App\Http\Requests;
use Session;
use Auth;
use Stripe\Charge;
use Stripe\Stripe;
use App\Productmeta;
use App\Productprice;
use Image;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;


class ProductContoller extends Controller
{
    
    public function getIndex(){
        $ad_cats = Mainaddtype::all();
        return view( 'shop.main-categories-page', ['mediacats' => $ad_cats]);
    }

    public function getAllProducts(){
        $products = Product::all();
        return view( 'backend.admin.productsList', ['products' => $products]);
    }

    public function getAddProduct(){
        $ad_cats = Mainaddtype::all();
        return view( 'backend.admin.add-product', ['categories' => $ad_cats]);
    }

    public function postProduct(Request $request){
        
        $this->validate( $request, [
           'title' => 'required',
           'price' => 'required|numeric',
           'imagepath' => 'required|image',
           'location' => 'required',
           'state' => 'required',
           'city' => 'required',
           'mediatype_id' => 'required|numeric',
           'rank' => 'required|numeric',
           'landmark' => 'required',
           'description' => 'required',
           'status' => 'required'
        ]);

       
        if($request->hasFile('imagepath')){
            $file = $request->file('imagepath');
            $filename = time() .'.'. $file->getClientOriginalExtension();
            $location = public_path("images\\" . $filename);
            Image::make($file)->resize(800, 400)->save($location);
        }

        $cat =  Mainaddtype::find($request->input('mediatype_id'));

        $cat_check = $cat->title;
        
        $product = New Product([
                    'imagepath' => $filename,
                    'title' => $request->input('title'),
                    'description' => $request->input('description'),
                    'price' => $request->input('price'),
                    'location' => $request->input('location'),
                    'state' => $request->input('state'),
                    'city' => $request->input('city'),
                    'mediatype_id' => $request->input('mediatype_id'),
                    'rank' => $request->input('rank'),
                    'landmark' => $request->input('landmark'),
                    'reference' => $request->input('reference'),
                    'status' => $request->input('status')
                    ]);
        $product->save();

        //dd($product->id);

        /*** adding Post Meta ***/
            switch($cat_check){
                case 'Newspapers':
                    if($request->has('circulation')){
                        $this->AddProductMeta($product->id, 'circulation', $request->input('circulation'));
                    }
                    if($request->has('language')){
                        $this->AddProductMeta($product->id, 'language', $request->input('language'));
                    }
                    if($request->has('displayoptions')){
                        $this->AddProductMeta($product->id, 'displayoptions', serialize($request->input('displayoptions')));
                        // pricing options
                        if($request->has('pricepage1')){
                             $this->addProductPrice($product->id, 'pricepage1', $request->input('pricepage1'));
                        }
                        if($request->has('pricepage3')){
                             $this->addProductPrice($product->id, 'pricepage3', $request->input('pricepage3'));
                        }
                        if($request->has('pricelastpage')){
                             $this->addProductPrice($product->id, 'pricelastpage', $request->input('pricelastpage'));
                        }
                        if($request->has('priceanypage')){
                             $this->addProductPrice($product->id, 'priceanypage', $request->input('priceanypage'));
                        }
                        
                     
                    }
                    if($request->has('otherdisplayoptions')){
                        
                        $productmeta_id = $this->AddProductMeta($product->id, 'otherdisplayoptions', serialize($request->input('otherdisplayoptions')));
                        //price options
                        if($request->has('pricejacketfront_page')){
                             $this->addProductPrice($product->id, 'pricejacketfront_page', $request->input('pricejacketfront_page'));
                        }
                        if($request->has('pricejacketfront_inside')){
                             $this->addProductPrice($product->id, 'pricejacketfront_inside', $request->input('pricejacketfront_inside'));
                        }
                        if($request->has('pricepointerad')){
                             $this->addProductPrice($product->id, 'pricepointerad', $request->input('pricepointerad'));
                        }
                        if($request->has('priceskybus')){
                             $this->addProductPrice($product->id, 'priceskybus', $request->input('priceskybus'));
                        }
                        if($request->has('priceearpanel')){
                             $this->addProductPrice($product->id, 'priceearpanel', $request->input('priceearpanel'));
                        }
                        if($request->has('pricehalfpage')){
                             $this->addProductPrice($product->id, 'pricehalfpage', $request->input('pricehalfpage'));
                        }
                        if($request->has('pricequarterpage')){
                             $this->addProductPrice($product->id, 'pricequarterpage', $request->input('pricequarterpage'));
                        }
                        if($request->has('pricepamphlets')){
                             $this->addProductPrice($product->id, 'pricepamphlets', $request->input('pricepamphlets'));
                        }
                        if($request->has('priceflyers')){
                             $this->addProductPrice($product->id, 'priceflyers', $request->input('priceflyers'));
                        }
                          

                    }
                    if($request->has('classifiedoptions')){
                        $productmeta_id = $this->AddProductMeta($product->id, 'classifiedoptions', serialize($request->input('classifiedoptions')));
                        //price options
                         if($request->has('pricematrimonial')){
                             $this->addProductPrice($product->id, 'pricematrimonial', $request->input('pricematrimonial'));
                        }
                         if($request->has('pricerecruitment')){
                             $this->addProductPrice($product->id, 'pricerecruitment', $request->input('pricerecruitment'));
                        }
                         if($request->has('pricebusiness')){
                             $this->addProductPrice($product->id, 'pricebusiness', $request->input('pricebusiness'));
                        }
                         if($request->has('priceproperty')){
                             $this->addProductPrice($product->id, 'priceproperty', $request->input('priceproperty'));
                        }
                         if($request->has('priceeducation')){
                             $this->addProductPrice($product->id, 'priceeducation', $request->input('priceeducation'));
                        }
                         if($request->has('priceastrology')){
                             $this->addProductPrice($product->id, 'priceastrology', $request->input('priceastrology'));
                        }
                         if($request->has('pricepublicnotices')){
                             $this->addProductPrice($product->id, 'pricepublicnotices', $request->input('pricepublicnotices'));
                        }
                         if($request->has('priceservices')){
                             $this->addProductPrice($product->id, 'priceservices', $request->input('priceservices'));
                        }
                         if($request->has('priceautomobile')){
                             $this->addProductPrice($product->id, 'priceautomobile', $request->input('priceautomobile'));
                        }
                         if($request->has('priceshopping')){
                             $this->addProductPrice($product->id, 'priceshopping', $request->input('priceshopping'));
                        }
                         
     

                    }
                    if($request->has('priceoptions')){
                        $productmeta_id = $this->AddProductMeta($product->id, 'priceoptions', serialize($request->input('priceoptions')));

                        //priceing options

                         if($request->has('pricepersq_cm')){
                             $this->addProductPrice($product->id, 'pricepersq_cm', $request->input('pricepersq_cm'));
                        }
                         if($request->has('priceperday')){
                             $this->addProductPrice($product->id, 'priceperday', $request->input('priceperday'));
                        }
                         if($request->has('priceperinerts')){
                             $this->addProductPrice($product->id, 'priceperinerts', $request->input('priceperinerts'));
                        }
                 
                    }
                    if($request->has('inserts')){
                        $this->AddProductMeta($product->id, 'inserts', $request->input('inserts'));
                    }
                  
                break;
                case 'Bus Stops':
                    if($request->has('bsdisplay')){
                        $productmeta_id = $this->AddProductMeta($product->id, 'bsdisplay', serialize($request->input('bsdisplay')));

                        //price options

                         if($request->has('pricefull')){
                             $this->addProductPrice($product->id, 'pricefull', $request->input('pricefull'));
                        }
                         if($request->has('pricerooffront')){
                             $this->addProductPrice($product->id, 'pricerooffront', $request->input('pricerooffront'));
                        }
                         if($request->has('priceseatbacks')){
                             $this->addProductPrice($product->id, 'priceseatbacks', $request->input('priceseatbacks'));
                        }

                         if($request->has('pricesideboards')){
                             $this->addProductPrice($product->id, 'pricesideboards', $request->input('pricesideboards'));
                        }

                    }
                    if($request->has('bslighting')){
                        $this->AddProductMeta($product->id, 'bslighting', $request->input('bslighting'));
                    }
                    if($request->has('bsnumber')){
                        $this->AddProductMeta($product->id, 'bsnumber', $request->input('bsnumber'));
                    }
                break;
                case 'Buses':
                    if($request->has('busdisplay')){
                        $productmeta_id = $this->AddProductMeta($product->id, 'busdisplay', serialize($request->input('busdisplay')));
                        
                        //priceing  options
                         if($request->has('pricefull')){
                             $this->addProductPrice($product->id, 'pricefull', $request->input('pricefull'));
                        }
                         if($request->has('priceleftside')){
                             $this->addProductPrice($product->id, 'priceleftside', $request->input('priceleftside'));
                        }
                         if($request->has('pricebothside')){
                             $this->addProductPrice($product->id, 'pricebothside', $request->input('pricebothside'));
                        }
                         if($request->has('pricerightside')){
                             $this->addProductPrice($product->id, 'pricerightside', $request->input('pricerightside'));
                        }
                         if($request->has('pricebackside')){
                             $this->addProductPrice($product->id, 'pricebackside', $request->input('pricebackside'));
                        }
                         if($request->has('pricebackglass')){
                             $this->addProductPrice($product->id, 'pricebackglass', $request->input('pricebackglass'));
                        }
                         if($request->has('priceinternalceiling')){
                             $this->addProductPrice($product->id, 'priceinternalceiling', $request->input('priceinternalceiling'));
                        }
                         if($request->has('pricebusgrab_handles')){
                             $this->addProductPrice($product->id, 'pricebusgrab_handles', $request->input('pricebusgrab_handles'));
                        }
                        if($request->has('priceinsidebillboards')){
                             $this->addProductPrice($product->id, 'priceinsidebillboards', $request->input('priceinsidebillboards'));
                        }
                       
                    }
                    if($request->has('busesnumber')){
                        $this->AddProductMeta($product->id, 'busesnumber', $request->input('bsdisplay'));
                    }
                    
                break;
                case 'Cars':
                    if($request->has('fullcardisplay')){
                        $productmeta_id = $this->AddProductMeta($product->id, 'fullcardisplay', serialize($request->input('fullcardisplay')));

                        //priceing options
                         if($request->has('pricefull')){
                             $this->addProductPrice($product->id, 'pricefull', $request->input('pricefull'));
                        }
                         if($request->has('pricefulloutside_only')){
                             $this->addProductPrice($product->id, 'pricefulloutside_only', $request->input('pricefulloutside_only'));
                        }

                    }
                    if($request->has('carextdisplay')){
                        $productmeta_id = $this->AddProductMeta($product->id, 'carextdisplay', serialize($request->input('carextdisplay')));
                        //price options
                        if($request->has('priceside')){
                             $this->addProductPrice($product->id, 'priceside', $request->input('priceside'));
                        }
                        if($request->has('pricebonnet')){
                             $this->addProductPrice($product->id, 'pricebonnet', $request->input('pricebonnet'));
                        }
                        if($request->has('pricetailgate')){
                             $this->addProductPrice($product->id, 'pricetailgate', $request->input('pricetailgate'));
                        }

                   
                    }
                    if($request->has('carintdisplay')){
                        $productmeta_id = $this->AddProductMeta($product->id, 'carintdisplay', serialize($request->input('carintdisplay')));

                        //price options
                         if($request->has('pricefrontseat')){
                             $this->addProductPrice($product->id, 'pricefrontseat', $request->input('pricefrontseat'));
                        }
                        if($request->has('pricebackcovers')){
                             $this->addProductPrice($product->id, 'pricebackcovers', $request->input('pricebackcovers'));
                        }
                        if($request->has('pricepamphlets')){
                             $this->addProductPrice($product->id, 'pricepamphlets', $request->input('pricepamphlets'));
                        }
                        if($request->has('pricestickers')){
                             $this->addProductPrice($product->id, 'pricestickers', $request->input('pricestickers'));
                        }
                          
                    }
                    if($request->has('carlighting')){
                        $this->AddProductMeta($product->id, 'carlighting', $request->input('carlighting'));
                    }
                    if($request->has('carnumber')){
                        $this->AddProductMeta($product->id, 'carnumber', $request->input('carnumber'));
                    }
                    
                break;
                case 'Shopping malls':
                    if($request->has('smlargead')){
                        $productmeta_id = $this->AddProductMeta($product->id, 'smlargead', serialize($request->input('smlargead')));

                        //price options
                         if($request->has('pricedropdown_banners')){
                             $this->addProductPrice($product->id, 'pricedropdown_banners', $request->input('pricedropdown_banners'));
                        }
                        if($request->has('pricefreestand_display')){
                             $this->addProductPrice($product->id, 'pricefreestand_display', $request->input('pricefreestand_display'));
                        }
                        if($request->has('pricewalls')){
                             $this->addProductPrice($product->id, 'pricewalls', $request->input('pricewalls'));
                        }
                        if($request->has('pricepoles/pillars')){
                             $this->addProductPrice($product->id, 'pricepoles/pillars', $request->input('pricepoles/pillars'));
                        }
                        if($request->has('pricesignage')){
                             $this->addProductPrice($product->id, 'pricesignage', $request->input('pricesignage'));
                        }    
     
                    }
                    if($request->has('smotheradoptions')){
                        $productmeta_id = $this->AddProductMeta($product->id, 'smotheradoptions', serialize($request->input('smotheradoptions')));

                        //price options
                         if($request->has('pricevideoad_display')){
                             $this->addProductPrice($product->id, 'pricevideoad_display', $request->input('pricevideoad_display'));
                        }
                        if($request->has('priceelevatorwrap')){
                             $this->addProductPrice($product->id, 'priceelevatorwrap', $request->input('priceelevatorwrap'));
                        }
                        if($request->has('priceelevatordoors')){
                             $this->addProductPrice($product->id, 'priceelevatordoors', $request->input('priceelevatordoors'));
                        }
                        if($request->has('pricefloor')){
                             $this->addProductPrice($product->id, 'pricefloor', $request->input('pricefloor'));
                        }
                        if($request->has('priceescalatorside_ads')){
                             $this->addProductPrice($product->id, 'priceescalatorside_ads', $request->input('priceescalatorside_ads'));
                        }    
                                           
                        
                    }
                    if($request->has('smduration')){
                       $productmeta_id = $this->AddProductMeta($product->id, 'smduration', serialize($request->input('smduration')));

                         //price options
                         if($request->has('priceprday')){
                             $this->addProductPrice($product->id, 'priceprday', $request->input('priceprday'));
                        }
                        if($request->has('priceprmonth')){
                             $this->addProductPrice($product->id, 'priceprmonth', $request->input('priceprmonth'));
                        }
              
                    }
                    if($request->has('signagelit')){
                        $this->AddProductMeta($product->id, 'signagelit', serialize($request->input('signagelit')));
                    }
                    if($request->has('durationnumber')){
                        $this->AddProductMeta($product->id, 'durationnumber', $request->input('durationnumber'));
                    }
                   
                        
                break;
                case 'Auto':
                    if($request->has('autodisplay')){
                        $productmeta_id = $this->AddProductMeta($product->id, 'autodisplay', serialize($request->input('autodisplay')));

                        //price options
                         if($request->has('pricefront')){
                             $this->addProductPrice($product->id, 'pricefront', $request->input('pricefront'));
                        }
                        if($request->has('priceback')){
                             $this->addProductPrice($product->id, 'priceback', $request->input('priceback'));
                        }
                        if($request->has('pricehood')){
                             $this->addProductPrice($product->id, 'pricehood', $request->input('pricehood'));
                        }
                        if($request->has('priceinterior')){
                             $this->addProductPrice($product->id, 'priceinterior', $request->input('priceinterior'));
                        }
                       
                    }
                    if($request->has('autofrontprdisplay')){
                        $productmeta_id = $this->AddProductMeta($product->id, 'autofrontprdisplay', serialize($request->input('autofrontprdisplay')));

                         //price options
                         if($request->has('pricelargepamphlets')){
                             $this->addProductPrice($product->id, 'pricelargepamphlets', $request->input('pricelargepamphlets'));
                        }
                        if($request->has('pricemedium_pamphlets')){
                             $this->addProductPrice($product->id, 'pricemedium_pamphlets', $request->input('pricemedium_pamphlets'));
                        }
                        if($request->has('pricesmall_pamphlets')){
                             $this->addProductPrice($product->id, 'pricesmall_pamphlets', $request->input('pricesmall_pamphlets'));
                        }
                        
                    }
                    if($request->has('autostickerdisplay')){
                        $productmeta_id = $this->AddProductMeta($product->id, 'autostickerdisplay', serialize($request->input('autostickerdisplay')));
                         //price options
                        if($request->has('pricelargesticker')){
                             $this->addProductPrice($product->id, 'pricelargesticker', $request->input('pricelargesticker'));
                        }
                        if($request->has('pricemediumsticker')){
                             $this->addProductPrice($product->id, 'pricemediumsticker', $request->input('pricemediumsticker'));
                        }
                        if($request->has('pricesmallsticker')){
                             $this->addProductPrice($product->id, 'pricesmallsticker', $request->input('pricesmallsticker'));
                        }
                     
                    }
                   
                    if($request->has('autohooddisplay')){
                        $productmeta_id = $this->AddProductMeta($product->id, 'autohooddisplay', serialize($request->input('autohooddisplay')));
                         //price options
                        if($request->has('pricefull')){
                             $this->addProductPrice($product->id, 'pricefull', $request->input('pricefull'));
                        }
                        if($request->has('priceleft')){
                             $this->addProductPrice($product->id, 'priceleft', $request->input('priceleft'));
                        }
                        if($request->has('priceright')){
                             $this->addProductPrice($product->id, 'priceright', $request->input('priceright'));
                        }
      
                    }
                    if($request->has('autointeriordisplay')){
                        $productmeta_id = $this->AddProductMeta($product->id, 'autointeriordisplay', serialize($request->input('autointeriordisplay')));
                         //price options
                        if($request->has('priceroof')){
                             $this->addProductPrice($product->id, 'priceroof', $request->input('priceroof'));
                        }
                        if($request->has('pricedriverseat')){
                             $this->addProductPrice($product->id, 'pricedriverseat', $request->input('pricedriverseat'));
                        }
     
                    }
                     if($request->has('autolightdisplay')){
                        $this->AddProductMeta($product->id, 'autolightdisplay', serialize($request->input('autolightdisplay')));
                    }
                    if($request->has('autonumber')){
                        $this->AddProductMeta($product->id, 'autonumber', $request->input('autonumber'));
                    }
                    
                break;

            }

        /*** End ***/

        return redirect()->route('dashboard.postproductform')->with('message', 'Successfully Added!');

        
    }

    public function AddProductMeta( $id, $meta_key, $meta_value){

        $insert = new Productmeta();
        $insert->product_id = $id;
        $insert->meta_key = $meta_key;
        $insert->meta_value = $meta_value;

        $insert->save();

        return $insert->id;
    }

    public function addProductPrice( $id, $meta_key, $meta_value){

        $insert = new Productprice();
        $insert->product_id = $id;
        $insert->price_key = $meta_key;
        $insert->price_value = $meta_value;

        $insert->save();
    }

    public function getDeleteProduct($productID){
        $delele_product = Product::where('id', $productID)->first();
        $delele_product->delete();
        $delete_productmeta = Productmeta::where('product_id', $productID);
        $delete_productmeta->delete();
        return redirect()->route('dashboard.getproductlist')->with(['message' => "Successfully Deleted From the List!"]);
    }
    

    public function getEditProduct($productID){
         $edit_product = Product::find($productID);
         $cat_id = $edit_product->mediatype_id;
         $cat = Mainaddtype::find($cat_id);
         $cat_name = $cat->title;
         $edit_productmeta = Productmeta::where('product_id', $productID)->get();
         $ad_cats = Mainaddtype::all();
         return view('backend.admin.editProduct', ['categories' => $ad_cats, 'catname' => $cat_name, 'productdata' => $edit_product, 'productmetadata' => $edit_productmeta]);
    }


    public function updateProduct(Request $request, $editProductID){
        $this->validate( $request, [
           'title' => 'required',
           'price' => 'required|numeric',
           //'imagepath' => 'required|image',
           'location' => 'required',
           'state' => 'required',
           'city' => 'required',
           'mediatype_id' => 'required|numeric',
           'rank' => 'required',
           'landmark' => 'required',
           'description' => 'required',
           'status' => 'required'
        ]);
        $editproduct = Product::find($editProductID);

         
        $editproduct->title = $request->input('title');
        $editproduct->description = $request->input('description');
        $editproduct->price = $request->input('price');
        $editproduct->location = $request->input('location');
        $editproduct->state = $request->input('state');
        $editproduct->city = $request->input('city');
        $editproduct->mediatype_id = $request->input('mediatype_id');
        $editproduct->rank = $request->input('rank');
        $editproduct->landmark = $request->input('landmark');
        $editproduct->reference = $request->input('reference');
        $editproduct->status = $request->input('status');
       
        if($request->hasFile('imagepath')){
            $file = $request->file('imagepath');
            $filename = time() .'.'. $file->getClientOriginalExtension();
            $location = public_path("images\\" . $filename);
            Image::make($file)->resize(800, 400)->save($location);
            $oldimage = $editproduct->imagepath;
            $editproduct->imagepath = $filename;
        }

        $editproduct->update();

        $cat =  Mainaddtype::find($request->input('mediatype_id'));

        $cat_check = $cat->title;
                       
        /*** adding Post Meta ***/
            switch($cat_check){
                case 'Newspapers':
                    if($request->has('circulation')){
                        $this->updateProductMeta($editproduct->id, 'circulation', $request->input('circulation'));
                    }
                    if($request->has('language')){
                        $this->updateProductMeta($editproduct->id, 'language', $request->input('language'));
                    }
                    if($request->has('displayoptions')){
                        $this->updateProductMeta($editproduct->id, 'displayoptions', serialize($request->input('displayoptions')));
                    }
                    if($request->has('otherdisplayoptions')){
                        $this->updateProductMeta($editproduct->id, 'otherdisplayoptions', serialize($request->input('otherdisplayoptions')));
                    }
                    if($request->has('classifiedoptions')){
                        $this->updateProductMeta($editproduct->id, 'classifiedoptions', serialize($request->input('classifiedoptions')));
                    }
                    if($request->has('priceoptions')){
                        $this->updateProductMeta($editproduct->id, 'priceoptions', serialize($request->input('priceoptions')));
                    }
                    if($request->has('inserts')){
                        $this->updateProductMeta($editproduct->id, 'inserts', $request->input('inserts'));
                    }
                  
                break;
                case 'Bus Stops':
                    if($request->has('bsdisplay')){
                        $this->updateProductMeta($editproduct->id, 'bsdisplay', serialize($request->input('bsdisplay')));
                    }
                    if($request->has('bslighting')){
                        $this->updateProductMeta($editproduct->id, 'bslighting', $request->input('bslighting'));
                    }
                    if($request->has('bsnumber')){
                        $this->updateProductMeta($editproduct->id, 'bsnumber', $request->input('bsnumber'));
                    }
                break;
                case 'Buses':
                     if($request->has('busdisplay')){
                        $this->updateProductMeta($editproduct->id, 'busdisplay', serialize($request->input('busdisplay')));
                    }
                    if($request->has('busesnumber')){
                        $this->updateProductMeta($editproduct->id, 'busesnumber', $request->input('bsdisplay'));
                    }
                break;
                case 'Cars':
                     if($request->has('fullcardisplay')){
                        $this->updateProductMeta($editproduct->id, 'fullcardisplay', serialize($request->input('fullcardisplay')));
                    }
                    if($request->has('carextdisplay')){
                        $this->updateProductMeta($editproduct->id, 'carextdisplay', serialize($request->input('carextdisplay')));
                    }
                    if($request->has('carintdisplay')){
                        $this->updateProductMeta($editproduct->id, 'carintdisplay', serialize($request->input('carintdisplay')));
                    }
                    if($request->has('carlighting')){
                        $this->updateProductMeta($editproduct->id, 'carlighting', serialize($request->input('carlighting')));
                    }
                    if($request->has('carnumber')){
                        $this->updateProductMeta($editproduct->id, 'carnumber', $request->input('carnumber'));
                    }
                break;
                case 'Shopping malls':
                    if($request->has('smlargead')){
                        $this->updateProductMeta($editproduct->id, 'smlargead', serialize($request->input('smlargead')));
                    }
                    if($request->has('smotheradoptions')){
                        $this->updateProductMeta($editproduct->id, 'smotheradoptions', serialize($request->input('smotheradoptions')));
                    }
                    if($request->has('smduration')){
                        $this->updateProductMeta($editproduct->id, 'smduration', serialize($request->input('smduration')));
                    }
                    if($request->has('signagelit')){
                        $this->updateProductMeta($editproduct->id, 'signagelit', serialize($request->input('signagelit')));
                    }
                    if($request->has('durationnumber')){
                        $this->updateProductMeta($editproduct->id, 'durationnumber', $request->input('durationnumber'));
                    }
                break;
                case 'Auto':
                    if($request->has('autodisplay')){
                        $this->updateProductMeta($editproduct->id, 'autodisplay', serialize($request->input('autodisplay')));
                    }
                    if($request->has('autofrontprdisplay')){
                        $this->updateProductMeta($editproduct->id, 'autofrontprdisplay', serialize($request->input('autofrontprdisplay')));
                    }
                    if($request->has('autostickerdisplay')){
                        $this->updateProductMeta($editproduct->id, 'autostickerdisplay', serialize($request->input('autostickerdisplay')));
                    }
                   
                    if($request->has('autohooddisplay')){
                        $this->updateProductMeta($editproduct->id, 'autohooddisplay', serialize($request->input('autohooddisplay')));
                    }
                    if($request->has('autointeriordisplay')){
                        $this->updateProductMeta($editproduct->id, 'autointeriordisplay', serialize($request->input('autointeriordisplay')));
                    }
                     if($request->has('autolightdisplay')){
                        $this->updateProductMeta($editproduct->id, 'autolightdisplay', serialize($request->input('autolightdisplay')));
                    }
                    if($request->has('autonumber')){
                        $this->updateProductMeta($editproduct->id, 'autonumber', $request->input('autonumber'));
                    }
                break;

            }

        /*** End ***/

        return redirect()->route('dashboard.getproductlist')->with('message', 'Successfully Updated!');

        
    }

    public function updateProductMeta( $id, $meta_key, $meta_value){
        $count = Productmeta::where([
                                    ['product_id', '=', $id],
                                    ['meta_key', '=', $meta_key],
                                ])->count();
        if($count < 1){
            $this->AddProductMeta( $id, $meta_key, $meta_value) ;
        }else{
            $update = Productmeta::where([
                                    ['product_id', '=', $id],
                                    ['meta_key', '=', $meta_key],
                                ])->update(['meta_value' => $meta_value]);
        }
        
   }



    public function getProducts(){
        $products = Product::all();
        return view( 'shop.index', [ 'products' => $products]);
    }

    public function getProductsByCat($catName){
         
        $cats = Mainaddtype::where('slug', $catName)->get();
        foreach($cats as $cat) $cat_id = $cat->id;
       
        
        $products = Product::where('mediatype_id', $cat_id)->get();
         
        return view( 'shop.index', [ 'products' => $products]);
    }

    public function getAddToCart(Request $request, $id){
        $product = Product::find($id);
        $oldCart = Session::has('cart') ? Session::get('cart') : null;

        $cart = new Cart($oldCart);

        $cart->add($product, $product->id);

        $request->session()->put('cart', $cart);
        //dd($request->session()->get('cart'));
        return redirect()->route('product.index');
    }

    public function getReduceByOne($id){
        $oldCart = Session::has('cart') ? Session::get('cart') : null;
        $cart = new Cart($oldCart);
        $cart->reduceByOne($id);

        Session::put('cart', $cart);

        return redirect()->route('product.shoppingCart');
    }

    public function getCart(){
        if(!Session::has('cart')){
            return view('shop.shopping-cart');
        }else{
            $oldcart = Session::get('cart');
            $cart = new Cart($oldcart);
            return view('shop.shopping-cart', ['products' => $cart->items, 'totalPrice' => $cart->totalPrice ]);
        }
    }

    public function getCheckout(){
        if(!Session::has('cart')){
            return view('shop.shopping-cart');
        }
        $oldcart = Session::get('cart');
        $cart = new Cart($oldcart);
        $totalPrice = $cart->totalPrice;

        return view('shop.checkout', ['total' => $totalPrice]);
 
    }

    public function postCheckout(Request $request){
        if(!Session::has('cart')){
            return redirect()->route('product.shoppingCart');
        }

        $oldcart = Session::get('cart');
        $cart = new Cart($oldcart);

        Stripe::setApiKey('sk_test_WWbimeDRbYGvAPXN82kbumcR');

        try{

           $charge = Charge::create(array(
                "amount" => $cart->totalPrice * 100,
                "currency" => "usd",
                "source" => $request->input('stripeToken'), // obtained with Stripe.js
                "description" => "Test Charge"
            ));

            $order = new Order();
            $order->cart = serialize($cart);
            $order->name = $request->input('name');
            $order->address = $request->input('address');
            $order->payment_id = $charge->id;
            Auth::user()->orders()->save($order);

         }catch(Exception $e){
            return redirect()->route('checkout')->with('error', $e->getMessage());
        }

        Session::forget('cart');
        return redirect()->route('product.index')->with('success', 'Successfully Order!');

    }

    public function getHTMLContentByMediaType(Request $request){

        $languages = array('English', 'Hindi', 'Punjabi', 'Sanskrit');
        $regular_options = array('Page1', 'Page3', 'Last Page', 'Any Page');
        $other_display_options = array('Jacket Front Page', 'Jacket Front Inside', 'Pointer Ad', 'Sky Bus', 'Ear Panel', 'Half Page', 'Quarter Page', 'Pamphlets', 'Flyers');
        $classified_options = array('Matrimonial', 'Recruitment', 'Business', 'Property', 'Education', 'Astrology', 'Public Notices', 'Services', 'Automobile', 'Shopping');
        $pricepage_time = array('per sq cm', 'per Day', 'per Inerts' );
        /**Automobiles Options**/
        $ad_cover_type = array('Front', 'Back', 'Hood', 'Interior');
        $pamphlets = array('Large Pamphlets', 'Medium  Pamphlets', 'Small  Pamphlets');
        $sticker = array('Large Sticker', 'Medium Sticker', 'Small Sticker');
        $hood_size = array('Full', 'Left', 'Right');
        $interior_panels = array('Roof', 'Driver Seat');
        $lighting_options = array('No','Yes');

        $car_internal_branding = array('Front Seat', 'Back Covers', 'Pamphlets', 'Stickers');
        $car_ext_branding = array('Side', 'Bonnet', 'Tailgate');
        $full_car =  array('Full','Full Outside Only');
        $lighting_car = array('No','Yes');

        $bs_options = array('Full', 'Roof Front', 'Seat Backs', 'Side Boards');
        $bs_light = array('No','Yes');

        $bus_options = array('Full', 'Both Side', 'Left Side', 'Right Side', 'Back Side', 'Back Glass', 'Internal Ceiling', 'Bus Grab Handles', 'Inside Billboards');

         /**Automobiles Options**/
         /** shoping malls **/
            $smlargead_options = array('Drop Down Banners', 'Free Stand Display', 'Walls', 'Poles/Pillars', 'Signage');
            $smother_options = array('Video Ad Display', 'Elevator Wrap', 'Elevator Doors', 'Floor', 'Escalator Side Ads');
            $smduration = array('pr Day', 'pr Month');
            $signage_lit = array('No','Yes');
         /** end **/

        $catname = ucfirst($request['mediaCat']);
        $catname = str_replace('-', ' ', $catname);

        $html = '';
        switch($request['mediaCat']){
            case 'newspapers':
                $html .= '<div class="panel-heading "><h3 class="panel-title">'.$catname.' Options</h3></div><div class="panel-body"><div class="form-group">';
                    
                $html .= '<label for="circulation">Circulations:</label><input type="hidden" id="circulationkey" name="circulationkey" value="circulation" class="form-control"><input type="text" id="circulation" name="circulation" class="form-control" required></div>';              
                $html .= '<div class="form-group"><label for="language">Languages:</label><input type="hidden" id="languagekey" name="languagekey" value="language" class="form-control"><select class="form-control" name="language" id="language" required>';
                foreach($languages as $key => $value){
                    $html .= '<option value="'.$key.'">'.$value.'</option>';
                }
                $html .= '</select></div><div class="form-group"><label for="regulardisplay">Newspaper Display Options: </label><input type="hidden" id="regulardisplaykey" name="regulardisplaykey" value="regulardisplay" class="form-control">';         
                foreach($regular_options as $key => $value){
                    $html .= "<label class='checkbox-inline'><input class='checkEvent' onclick='addDomToPriceOptions(\"$value\")' name='displayoptions[]' type='checkbox' value='".$key."'>".$value."</label>";
                }           
                $html .= '</div><div class="form-group"><label for="otherregulardisplay">Other Display Options: </label><input type="hidden" id="otherregulardisplaykey" name="otherregulardisplaykey" value="otherregulardisplay" class="form-control">';
                foreach($other_display_options as $key => $value){
                    $html .= "<label class='checkbox-inline'><input class='checkEvent' onclick='addDomToPriceOptions(\"$value\")' name='otherdisplayoptions[]' type='checkbox' value='".$key."'>".$value."</label>";
                }
                $html .= '</div><div class="form-group"><label for="classifiedoptions">Classified Options: </label><input type="hidden" id="classifiedoptionskey" name="classifiedoptionskey" value="classifiedoptions" class="form-control">';
                foreach($classified_options as $key => $value){
                    $html .= "<label class='checkbox-inline'><input class='checkEvent'  data-label='Classified Options' onclick='addDomToPriceOptions(\"$value\")' name='classifiedoptions[]' type='checkbox' value='".$key."'>".$value."</label>";
                }
                $html .= '</div> <div class="form-group"><label for="priceoptions">Pricing Options: </label><input type="hidden" id="priceoptionskey" name="priceoptionskey" value="priceoptions" class="form-control">';           
                foreach($pricepage_time as $key => $value){
                    $html .= "<label class='checkbox-inline'><input class='checkEvent' data-label='Pricing Options' onclick='addDomToPriceOptions(\"$value\")' name='priceoptions[]' type='checkbox' value='".$key."'>".$value."</label>";
                }
                $html .= '</div><div class="form-group"><label for="inserts">If Inserts Checked Than Provide, number of Inserts:</label>';
                $html .= '<input class="form-control" type="hidden" id="insertskey" name="insertskey" value="inserts"><input type="text" id="inserts" name="inserts" class="form-control"></div></div>';

            break;
           case 'cars':
                    $html .= '<div class="panel-heading "><h3 class="panel-title">'.$catname.' Options</h3></div><div class="panel-body"><div class="form-group">';
                    $html .= '<label for="fullcardisplay">Do you want Full Ad Display On Car?: </label><input class="form-control" type="hidden" id="fullcardisplayskey" name="fullcardisplaykey" value="fullcardisplay">';         
                    foreach($full_car as $key => $value){
                        $html .= "<label class='checkbox-inline'><input class='checkEvent' data-label='Full Ad Display On Car' onclick='addDomToPriceOptions(\"$value\")' name='fullcardisplay[]' type='checkbox' value='".$key."'>".$value."</label>";
                    }
                    
                    $html .= '</div><div class="form-group"><label for="carextdisplay">Car External Branding: </label><input class="form-control" type="hidden" id="carextdisplaykey" name="carextdisplaykey" value="carextdisplay">';         
                    foreach($car_ext_branding as $key => $value){
                        $html .= "<label class='checkbox-inline'><input class='checkEvent' data-label='Car External Branding' onclick='addDomToPriceOptions(\"$value\")' name='carextdisplay[]' type='checkbox' value='".$key."'>".$value."</label>";
                    }
                    
                    $html .= '</div><div class="form-group"><label for="carintdisplay">Car Internal Branding: </label><input class="form-control" type="hidden" id="carintdisplaykey" name="carintdisplaykey" value="carintdisplay">';         
                    foreach($car_internal_branding as $key => $value){
                        $html .= "<label class='checkbox-inline'><input class='checkEvent' data-label='Car Internal Branding' onclick='addDomToPriceOptions(\"$value\")' name='carintdisplay[]' type='checkbox' value='".$key."'>".$value."</label>";
                    }
                   
                    $html .= '</div><div class="form-group"><label for="carlighting">Do you want external ad Panels glow? </label><input class="form-control" type="hidden" id="carlightingkey" name="carlightingkey" value="carlighting">';         
                    foreach($lighting_car as $key => $value){
                        $html .= "<label class='checkbox-inline'><input class='checkEvent' data-label='ad Panels glow' onclick='addDomToPriceOptionsWithLight(\"$value\")' name='carlighting' type='radio' value='".$key."'>".$value."</label>";
                    }
                   
                    $html .= '</div><div class="form-group"><label for="carnumber">Numbers Of Cars Display this Ad? : </label><input class="form-control" type="hidden" id="carnumberkey" name="carnumberkey" value="carnumber"><input class="form-control" type="text" name="carnumber" required></div></div>';
                   
            break;
            case 'bus-stops':
                    $html .= '<div class="panel-heading "><h3 class="panel-title">'.$catname.' Options</h3></div><div class="panel-body"><div class="form-group">';
                    $html .= '<label for="bsdisplay">Bus Shelter Ad Display Options: </label><input class="form-control" type="hidden" id="bsdisplaykey" name="bsdisplaykey" value="bsdisplay">';         
                    foreach($bs_options as $key => $value){
                        $html .= "<label class='checkbox-inline'><input class='checkEvent' data-label='Bus Shelter Ad Display' onclick='addDomToPriceOptions(\"$value\")' name='bsdisplay[]' type='checkbox'' value='".$key."'>".$value."</label>";
                    }
                    
                                     
                    $html .= '</div><div class="form-group"><label for="bslighting">Do you want lighting options on Bus Stops?: </label><input class="form-control" type="hidden" id="bslightingkey" name="bslightingkey" value="bslighting">';         
                    foreach($bs_light as $key => $value){
                        $html .= "<label class='checkbox-inline'><input class='checkEvent' data-label='Bus Shelter lighting options' onclick='addDomToPriceOptionsWithLight(\"$value\")' name='bslighting' type='radio' value='".$key."'>".$value."</label>";
                    }
                   
                    $html .= '</div><div class="form-group"><label for="bsnumber">Numbers Of Bus Shelters/Stops Display this Ad? : </label><input class="form-control" type="hidden" id="bsnumberkey" name="bsnumberkey" value="bsnumber"><input class="form-control" type="text" name="bsnumber" required></div></div>';

             break;
            case 'buses':
                    $html .= '<div class="panel-heading "><h3 class="panel-title">'.$catname.' Options</h3></div><div class="panel-body"><div class="form-group">';
                    $html .= '<label for="bsdbusdisplayisplay">Buses Ad Display Options: </label><input class="form-control" type="hidden" id="busdisplaykey" name="busdisplaykey" value="busdisplay">';         
                    foreach($bus_options as $key => $value){
                        $html .= "<label class='checkbox-inline'><input class='checkEvent' data-label='Buses Ad Display Options' onclick='addDomToPriceOptions(\"$value\")' name='busdisplay[]' type='checkbox' value='".$key."'>".$value."</label>";
                    }
                                       
                    $html .= '</div><div class="form-group"><label for="busesnumber">Numbers Of Buses Display this Ad? : </label><input class="form-control" type="hidden" id="busesnumberkey" name="busesnumberkey" value="busesnumber"><input class="form-control" type="text" name="busesnumber" required></div></div>';
             break;
            case 'auto':
                    $html .= '<div class="panel-heading "><h3 class="panel-title">'.$catname.' Options</h3></div><div class="panel-body">';
                    $html .= '<div class="form-group"><label for="autodisplay">Auto Display Options: </label><input class="form-control" type="hidden" id="autodisplaykey" name="autodisplaykey" value="autodisplay">';         
                    foreach($ad_cover_type as $key => $value){
                        $html .= "<label class='checkbox-inline'><input class='checkEvent' data-label='Auto Display Options' onclick='addDomToPriceOptions(\"$value\")' name='autodisplay[]' type='checkbox' value='".$key."'>".$value."</label>";
                    }
                    $html .= '</div>';
                    $html .= '<div class="form-group"><label for="autofrontprdisplay">Auto Front Pamphlets/Reactanguler Options: </label><input class="form-control" type="hidden" id="autofrontprdisplaykey" name="autofrontprdisplaykey" value="autofrontprdisplay">';         
                    foreach($pamphlets as $key => $value){
                        $html .= "<label class='checkbox-inline'><input class='checkEvent' data-label='Auto Front Pamphlets/Reactanguler Options' onclick='addDomToPriceOptions(\"$value\")' name='autofrontprdisplay[]' type='checkbox' value='".$key."'>".$value."</label>";
                    }
                    $html .= '</div>';
                    
                    $html .= '<div class="form-group"><label for="autostickerdisplay">Auto Front Stickers Options: </label><input class="form-control" type="hidden" id="autostickerdisplaykey" name="autostickerdisplaykey" value="autostickerdisplay">';         
                    foreach($sticker as $key => $value){
                        $html .= "<label class='checkbox-inline'><input class='checkEvent' data-label='Auto Front Stickers Options' onclick='addDomToPriceOptions(\"$value\")' name='autostickerdisplay[]' type='checkbox' value='".$key."'>".$value."</label>";
                    }
                    $html .= '</div>';
                    $html .= '<div class="form-group"><label for="autohooddisplay">Auto Hood Options: </label><input class="form-control" type="hidden" id="autohooddisplaykey" name="autohooddisplaykey" value="autohooddisplay">';         
                    foreach($hood_size as $key => $value){
                        $html .= "<label class='checkbox-inline'><input class='checkEvent' data-label='Auto Hood Options' onclick='addDomToPriceOptions(\"$value\")' name='autohooddisplay[]' type='checkbox' value='".$key."'>".$value."</label>";
                    }
                    $html .= '</div>';
                    $html .= '<div class="form-group"><label for="autointeriordisplay">Auto Interior Options: </label><input class="form-control" type="hidden" id="autointeriordisplaykey" name="autointeriordisplaykey" value="autointeriordisplay">';         
                    foreach($interior_panels as $key => $value){
                        $html .= "<label class='checkbox-inline'><input class='checkEvent' data-label='Auto Interior Options' onclick='addDomToPriceOptions(\"$value\")' name='autointeriordisplay[]' type='checkbox' value='".$key."'>".$value."</label>";
                    }
                    $html .= '</div>';
                    $html .= '<div class="form-group"><label for="autolightdisplay">Lighting Options For Auto Panels: </label><input class="form-control" type="hidden" id="autolightdisplaykey" name="autolightdisplaykey" value="autolightdisplay">';         
                    foreach($lighting_options as $key => $value){
                        $html .= "<label class='checkbox-inline'><input class='checkEvent' data-label='Lighting Options For Auto Panels' onclick='addDomToPriceOptionsWithLight(\"$value\")' name='autolightdisplay[]' type='radio' value='".$key."'>".$value."</label>";
                    }
                    $html .= '</div>';
                    $html .= '<div class="form-group"><label for="autonumber">Numbers Of Autos Display this Ad? : </label><input class="form-control" type="hidden" id="autonumberkey" name="autonumberkey" value="autonumber"><input class="form-control" type="text" name="autonumber" required></div>';
                    $html .= '</div>';
             break;
             case 'shopping-malls':
                    $html .= '<div class="panel-heading "><h3 class="panel-title">'.$catname.' Options</h3></div><div class="panel-body">';
                    $html .= '<div class="form-group"><label for="smlargead">Large ad Options: </label>';         
                    foreach($smlargead_options as $key => $value){
                        $html .= "<label class='checkbox-inline'><input class='checkEvent' data-label='Large ad Options' onclick='addDomToPriceOptions(\"$value\")' name='smlargead[]' type='checkbox' value='".$key."'>".$value."</label>";
                    }
                    $html .= '</div>';
                    $html .= '<div class="form-group"><label for="smotheradoptions">Other ad Options: </label>';         
                    foreach($smother_options as $key => $value){
                        $html .= "<label class='checkbox-inline'><input class='checkEvent' onclick='addDomToPriceOptions(\"$value\")' name='smotheradoptions[]' type='checkbox' value='".$key."'>".$value."</label>";
                    }
                    $html .= '</div>';
                   
                    $html .= '<div class="form-group"><label for="smduration">Time Duration Options: </label>';         
                    foreach($smduration as $key => $value){
                        $html .= "<label class='checkbox-inline'><input class='checkEvent' onclick='addDomToPriceOptions(\"$value\")' name='smduration[]' type='checkbox' value='".$key."'>".$value."</label>";
                    }
                    $html .= '</div>';
                    $html .= '<div class="form-group"><label for="signagelit">Signage Light Options: </label>';         
                    foreach($signage_lit as $key => $value){
                        $html .= "<label class='checkbox-inline'><input class='checkEvent' onclick='addDomToPriceOptionsWithLight(\"$value\")'   name='signagelit[]' type='radio' value='".$key."'>".$value."</label>";
                    }
                    $html .= '</div>';
                    
                    $html .= '<div class="form-group"><label for="durationnumber">Numbers Of Duration You want to show ad in Shopping malls? : </label><input class="form-control" type="text" name="durationnumber" required></div>';
                    $html .= '</div>';
                break;

        }
        

        return response()->json(['response' => $html ], 200);        
                        
      }
      // get product single page

      public function getProductSingle($id){
          $product = Product::find($id);
          $product_title = $product->title;
          $productmeta = Productmeta::where('product_id', $id)->get();
          return view('shop.product-single', ['product' => $product, 'productmeta' => $productmeta, 'title' => $product_title]);
      }
      
      public function getproductform(){
          $ad_cats = Mainaddtype::all();
          return view( 'backend.admin.addproduct-multistep', ['categories' => $ad_cats]);
          
      }
}
