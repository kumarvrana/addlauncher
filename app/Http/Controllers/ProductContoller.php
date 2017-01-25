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
           'rank' => 'required',
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
                        $this->AddProductMeta($product->id, 'displayoptions', $request->input('displayoptions'));
                    }
                    if($request->has('otherdisplayoptions')){
                        $this->AddProductMeta($product->id, 'otherdisplayoptions', $request->input('otherdisplayoptions'));
                    }
                    if($request->has('classifiedoptions')){
                        $this->AddProductMeta($product->id, 'classifiedoptions', $request->input('classifiedoptions'));
                    }
                    if($request->has('priceoptions')){
                        $this->AddProductMeta($product->id, 'priceoptions', $request->input('priceoptions'));
                    }
                    if($request->has('inserts')){
                        $this->AddProductMeta($product->id, 'inserts', $request->input('inserts'));
                    }
                  
                break;
                case 'Bus Stops':
                    if($request->has('bsdisplay')){
                        $this->AddProductMeta($product->id, 'bsdisplay', serialize($request->input('bsdisplay')));
                    }
                    if($request->has('bslighting')){
                        $this->AddProductMeta($product->id, 'bslighting', $request->input('bslighting'));
                    }
                    if($request->has('bsnumber')){
                        $this->AddProductMeta($product->id, 'bsnumber', $request->input('bsnumber'));
                    }
                break;
                case 'Buses':
                break;
                case 'Cars':
                break;
                case 'Shopping malls':
                break;
                case 'Auto':
                break;

            }

        /*** End ***/

        return redirect()->route('dashboard.postproduct')->with('message', 'Successfully Added!');

        
    }

    public function AddProductMeta( $id, $meta_key, $meta_value){

        $insert = new Productmeta();
        $insert->product_id = $id;
        $insert->meta_key = $meta_key;
        $insert->meta_value = $meta_value;

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
                        $this->updateProductMeta($product->id, 'displayoptions', $request->input('displayoptions'));
                    }
                    if($request->has('otherdisplayoptions')){
                        $this->updateProductMeta($editproduct->id, 'otherdisplayoptions', $request->input('otherdisplayoptions'));
                    }
                    if($request->has('classifiedoptions')){
                        $this->updateProductMeta($editproduct->id, 'classifiedoptions', $request->input('classifiedoptions'));
                    }
                    if($request->has('priceoptions')){
                        $this->updateProductMeta($editproduct->id, 'priceoptions', $request->input('priceoptions'));
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
                break;
                case 'Cars':
                break;
                case 'Shopping malls':
                break;
                case 'Auto':
                break;

            }

        /*** End ***/

        return redirect()->route('dashboard.getproductlist')->with('message', 'Successfully Updated!');

        
    }

    public function updateProductMeta( $id, $meta_key, $meta_value){

        $update = Productmeta::where([
                                    ['product_id', '=', $id],
                                    ['meta_key', '=', $meta_key],
                                ])->update(['meta_value' => $meta_value]);
   }



    public function getProducts(){
        $products = Product::all();
        return view( 'shop.index', [ 'products' => $products]);
    }

    public function getProductsByCat($catName){
        $cat = Mainaddtype::where('slug', $catName)->first();
        $cat_id = $cat->id;
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
        $pamphlets = array('Large', 'Medium', 'Small');
        $sticker = array('Large', 'Medium', 'Small');
        $hood_size = array('Full', 'Left', 'Right');
        $interior_panels = array('Roof', 'Driver Seat');
        $lighting_options = array('No','Yes');

        $car_internal_branding = array('Front Seat', 'Back Covers', 'Pamphlets', 'Stickers');
        $car_ext_branding = array('Side', 'Bonnet', 'Tailgate');
        $full_car =  array('No','Yes');
        $lighting_car = array('Glow', 'No Glow');

        $bs_options = array('Full', 'Roof Front', 'Seat Backs', 'Side Boards');
        $bs_light = array('No','Yes');

        $bus_options = array('Full', 'Both Side', 'Left Side', 'Right Side', 'Back Side', 'Back Glass', 'Internal Ceiling', 'Bus Grab Handles', 'Inside Billboards');

         /**Automobiles Options**/
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
                    $html .= '<label class="checkbox-inline"><input name="displayoptions[]" type="checkbox" value="'.$key.'">'.$value.'</label>';
                }           
                $html .= '</div><div class="form-group"><label for="otherregulardisplay">Other Display Options: </label><input type="hidden" id="otherregulardisplaykey" name="otherregulardisplaykey" value="otherregulardisplay" class="form-control">';
                foreach($other_display_options as $key => $value){
                    $html .= '<label class="checkbox-inline"><input name="otherdisplayoptions[]" type="checkbox" value="'.$key.'">'.$value.'</label>';
                }
                $html .= '</div><div class="form-group"><label for="classifiedoptions">Classified Options: </label><input type="hidden" id="classifiedoptionskey" name="classifiedoptionskey" value="classifiedoptions" class="form-control">';
                foreach($classified_options as $key => $value){
                    $html .= '<label class="checkbox-inline"><input name="classifiedoptions[]" type="checkbox" value="'.$key.'">'.$value.'</label>';
                }
                $html .= '</div> <div class="form-group"><label for="priceoptions">Pricing Options: </label><input type="hidden" id="priceoptionskey" name="priceoptionskey" value="priceoptions" class="form-control">';           
                foreach($pricepage_time as $key => $value){
                    $html .= '<label class="checkbox-inline"><input name="priceoptions[]" type="checkbox" value="'.$key.'">'.$value.'</label>';
                }
                $html .= '</div><div class="form-group"><label for="inserts">If Inserts Checked Than Provide, number of Inserts:</label>';
                $html .= '<input class="form-control" type="hidden" id="insertskey" name="insertskey" value="inserts"><input type="text" id="inserts" name="inserts" class="form-control"></div></div>';

            break;
           case 'cars':
                    $html .= '<div class="panel-heading "><h3 class="panel-title">'.$catname.' Options</h3></div><div class="panel-body"><div class="form-group">';
                    $html .= '<label for="fullcardisplay">Do you want Full Ad Display On Car?: </label><input class="form-control" type="hidden" id="fullcardisplayskey" name="fullcardisplaykey" value="fullcardisplay">';         
                    foreach($full_car as $key => $value){
                        $html .= '<label class="checkbox-inline"><input name="fullcardisplay[]" type="radio" value="'.$key.'">'.$value.'</label>';
                    }
                    
                    $html .= '</div><div class="form-group"><label for="carextdisplay">Car External Branding: </label><input class="form-control" type="hidden" id="carextdisplaykey" name="carextdisplaykey" value="carextdisplay">';         
                    foreach($car_ext_branding as $key => $value){
                        $html .= '<label class="checkbox-inline"><input name="carextdisplay[]" type="checkbox" value="'.$key.'">'.$value.'</label>';
                    }
                    
                    $html .= '</div><div class="form-group"><label for="carintdisplay">Car Internal Branding:: </label><input class="form-control" type="hidden" id="carintdisplaykey" name="carintdisplaykey" value="carintdisplay">';         
                    foreach($car_internal_branding as $key => $value){
                        $html .= '<label class="checkbox-inline"><input name="carintdisplay[]" type="checkbox" value="'.$key.'">'.$value.'</label>';
                    }
                   
                    $html .= '</div><div class="form-group"><label for="carlighting">Do you want external ad Panels glow? </label><input class="form-control" type="hidden" id="carlightingkey" name="carlightingkey" value="carlighting">';         
                    foreach($lighting_car as $key => $value){
                        $html .= '<label class="checkbox-inline"><input name="carlighting[]" type="checkbox" value="'.$key.'">'.$value.'</label>';
                    }
                   
                    $html .= '</div><div class="form-group"><label for="carnumber">Numbers Of Cars Display this Ad? : </label><input class="form-control" type="hidden" id="carnumberkey" name="carnumberkey" value="carnumber"><input class="form-control" type="text" name="carnumber" required></div></div>';
                   
            break;
            case 'bus-stops':
                    $html .= '<div class="panel-heading "><h3 class="panel-title">'.$catname.' Options</h3></div><div class="panel-body"><div class="form-group">';
                    $html .= '<label for="bsdisplay">Bus Shelter Ad Display Options: </label><input class="form-control" type="hidden" id="bsdisplaykey" name="bsdisplaykey" value="bsdisplay">';         
                    foreach($bs_options as $key => $value){
                        $html .= '<label class="checkbox-inline"><input name="bsdisplay[]" type="checkbox" value="'.$key.'">'.$value.'</label>';
                    }
                    
                                     
                    $html .= '</div><div class="form-group"><label for="bslighting">Do you want lighting options on Bus Stops?: </label><input class="form-control" type="hidden" id="bslightingkey" name="bslightingkey" value="bslighting">';         
                    foreach($bs_light as $key => $value){
                        $html .= '<label class="checkbox-inline"><input name="bslighting" type="radio" value="'.$key.'">'.$value.'</label>';
                    }
                   
                    $html .= '</div><div class="form-group"><label for="bsnumber">Numbers Of Bus Shelters/Stops Display this Ad? : </label><input class="form-control" type="hidden" id="bsnumberkey" name="bsnumberkey" value="bsnumber"><input class="form-control" type="text" name="bsnumber" required></div></div>';

             break;
            case 'buses':
                    $html .= '<div class="panel-heading "><h3 class="panel-title">'.$catname.' Options</h3></div><div class="panel-body"><div class="form-group">';
                    $html .= '<label for="bsdbusdisplayisplay">Buses Ad Display Options: </label><input class="form-control" type="hidden" id="busdisplaykey" name="busdisplaykey" value="busdisplay">';         
                    foreach($bus_options as $key => $value){
                        $html .= '<label class="checkbox-inline"><input name="busdisplay[]" type="checkbox" value="'.$key.'">'.$value.'</label>';
                    }
                                       
                    $html .= '</div><div class="form-group"><label for="busesnumber">Numbers Of Buses Display this Ad? : </label><input class="form-control" type="hidden" id="busesnumberkey" name="busesnumberkey" value="busesnumber"><input class="form-control" type="text" name="busesnumber" required></div></div>';
             break;
            case 'auto':
                    $html .= '<div class="panel-heading "><h3 class="panel-title">'.$catname.' Options</h3></div><div class="panel-body">';
                    $html .= '<div class="form-group"><label for="autodisplay">Auto Display Options: </label><input class="form-control" type="hidden" id="autodisplaykey" name="autodisplaykey" value="autodisplay">';         
                    foreach($ad_cover_type as $key => $value){
                        $html .= '<label class="checkbox-inline"><input name="autodisplay[]" type="checkbox" value="'.$key.'">'.$value.'</label>';
                    }
                    $html .= '</div>';
                    $html .= '<div class="form-group"><label for="autofrontprdisplay">Auto Front Pamphlets/Reactanguler Options: </label><input class="form-control" type="hidden" id="autofrontprdisplaykey" name="autofrontprdisplaykey" value="autofrontprdisplay">';         
                    foreach($pamphlets as $key => $value){
                        $html .= '<label class="checkbox-inline"><input name="autofrontprdisplay[]" type="checkbox" value="'.$key.'">'.$value.'</label>';
                    }
                    $html .= '</div>';
                    /*$html .= '<div class="form-group"><label for="autofrontprdisplay">Auto Front Pamphlets/Reactanguler Options: </label>';         
                    foreach($pamphlets as $key => $value){
                        $html .= '<label class="checkbox-inline"><input name="autofrontprdisplay[]" type="checkbox" value="'.$key.'">'.$value.'</label>';
                    }
                    $html .= '</div>';*/
                    $html .= '<div class="form-group"><label for="autostickerdisplay">Auto Front Stickers Options: </label><input class="form-control" type="hidden" id="autostickerdisplaykey" name="autostickerdisplaykey" value="autostickerdisplay">';         
                    foreach($sticker as $key => $value){
                        $html .= '<label class="checkbox-inline"><input name="autostickerdisplay[]" type="checkbox" value="'.$key.'">'.$value.'</label>';
                    }
                    $html .= '</div>';
                    $html .= '<div class="form-group"><label for="autohooddisplay">Auto Hood Options: </label><input class="form-control" type="hidden" id="autohooddisplaykey" name="autohooddisplaykey" value="autohooddisplay">';         
                    foreach($hood_size as $key => $value){
                        $html .= '<label class="checkbox-inline"><input name="autohooddisplay[]" type="checkbox" value="'.$key.'">'.$value.'</label>';
                    }
                    $html .= '</div>';
                    $html .= '<div class="form-group"><label for="autointeriordisplay">Auto Interior Options: </label><input class="form-control" type="hidden" id="autointeriordisplaykey" name="autointeriordisplaykey" value="autointeriordisplay">';         
                    foreach($interior_panels as $key => $value){
                        $html .= '<label class="checkbox-inline"><input name="autointeriordisplay[]" type="checkbox" value="'.$key.'">'.$value.'</label>';
                    }
                    $html .= '</div>';
                    $html .= '<div class="form-group"><label for="autolightdisplay">Lighting Options For Auto Panels: </label><input class="form-control" type="hidden" id="autolightdisplaykey" name="autolightdisplaykey" value="autolightdisplay">';         
                    foreach($lighting_options as $key => $value){
                        $html .= '<label class="checkbox-inline"><input name="autolightdisplay[]" type="radio" value="'.$key.'">'.$value.'</label>';
                    }
                    $html .= '</div>';
                    $html .= '<div class="form-group"><label for="autonumber">Numbers Of Autos Display this Ad? : </label><input class="form-control" type="hidden" id="autonumberkey" name="autonumberkey" value="autonumber"><input class="form-control" type="text" name="autonumber" required></div>';
                    $html .= '</div>';
             break;
             case 'shopping-malls':
                    $html .= '<div class="panel-heading "><h3 class="panel-title">'.$catname.' Options</h3></div><div class="panel-body">';
                    $html .= '<div class="form-group"><label for="autodisplay">Auto Display Options: </label>';         
                    foreach($ad_cover_type as $key => $value){
                        $html .= '<label class="checkbox-inline"><input name="autodisplay[]" type="checkbox" value="'.$key.'">'.$value.'</label>';
                    }
                    $html .= '</div>';
                    $html .= '<div class="form-group"><label for="autofrontprdisplay">Auto Front Pamphlets/Reactanguler Options: </label>';         
                    foreach($pamphlets as $key => $value){
                        $html .= '<label class="checkbox-inline"><input name="autofrontprdisplay[]" type="checkbox" value="'.$key.'">'.$value.'</label>';
                    }
                    $html .= '</div>';
                    $html .= '<div class="form-group"><label for="autofrontprdisplay">Auto Front Pamphlets/Reactanguler Options: </label>';         
                    foreach($pamphlets as $key => $value){
                        $html .= '<label class="checkbox-inline"><input name="autofrontprdisplay[]" type="checkbox" value="'.$key.'">'.$value.'</label>';
                    }
                    $html .= '</div>';
                    $html .= '<div class="form-group"><label for="autostickerdisplay">Auto Front Stickers Options: </label>';         
                    foreach($sticker as $key => $value){
                        $html .= '<label class="checkbox-inline"><input name="autostickerdisplay[]" type="checkbox" value="'.$key.'">'.$value.'</label>';
                    }
                    $html .= '</div>';
                    $html .= '<div class="form-group"><label for="autohooddisplay">Auto Hood Options: </label>';         
                    foreach($hood_size as $key => $value){
                        $html .= '<label class="checkbox-inline"><input name="autohooddisplay[]" type="checkbox" value="'.$key.'">'.$value.'</label>';
                    }
                    $html .= '</div>';
                    $html .= '<div class="form-group"><label for="autointeriordisplay">Auto Interior Options: </label>';         
                    foreach($interior_panels as $key => $value){
                        $html .= '<label class="checkbox-inline"><input name="autointeriordisplay[]" type="checkbox" value="'.$key.'">'.$value.'</label>';
                    }
                    $html .= '</div>';
                    $html .= '<div class="form-group"><label for="autolightdisplay">Lighting Options For Auto Panels: </label>';         
                    foreach($lighting_options as $key => $value){
                        $html .= '<label class="checkbox-inline"><input name="autolightdisplay[]" type="radio" value="'.$key.'">'.$value.'</label>';
                    }
                    $html .= '</div>';
                    $html .= '<div class="form-group"><label for="autonumber">Numbers Of Autos Display this Ad? : </label><input class="form-control" type="text" name="autonumber" required></div>';
                    $html .= '</div>';
                break;

        }
        

        return response()->json(['response' => $html ], 200);        
                        
      }

      
}
