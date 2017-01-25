@extends('backend.layouts.backend-master')

@section('title')
   Edit Product
@endsection

@section('content')
        <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
          <h1 class="page-header">Edit Product</h1>
            <div class="col-sm-9 col-sm-offset-1 col-md-6 col-md-offset-1">
             @if(count($errors) > 0 )
                <div class="alert alert-danger">
                    @foreach($errors->all() as $error)
                        <p>{{ $error }}</p>
                    @endforeach
                </div>
            @endif
            @if(Session::has('message'))
                <div class="alert alert-success">
                    <p>{{Session::get('message')}}</p>
                </div>
            @endif
         
            <form action="{{route('dashboard.updateProduct', ['editProductID' => $productdata->id])}}" method="post" enctype="multipart/form-data" id="edit-product-form">
                <div class="form-group">
                    <label for="title">Ad Name:</label>
                    <input type="text" id="title" name="title" class="form-control" value="{{$productdata->title}}" required>
                </div>
                <div class="form-group">
                    <label for="price">Ad Price:</label>
                    <input type="text" id="price" name="price" class="form-control" value="{{$productdata->price}}" required>
                </div>
                <div class="form-group">
                    <label for="location">Location:</label>
                    <input type="text" id="location" name="location" value="{{$productdata->location}}" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="ad-state">State:</label>
                    <input type="text" id="state" name="state" value="{{$productdata->state}}" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="city">City:</label>
                    <input type="text" id="city" name="city" value="{{$productdata->city}}" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="imagepath ">Ad Image:</label>
                    <input type="file" id="imagepath" name="imagepath" class="form-control">
                </div>
                
                <div class="form-group">
                    <label for="sel1">Select Media Type:</label>
                    <select class="form-control" name="mediatype_id" id="mediatype" required="required">
                        <option value="">--Select--</option>
                        @foreach( $categories as $category)
                        <option data-name="{{strtolower(str_replace(' ', '-', $category->title))}}" value="{{$category->id}}" @PHP if($productdata->mediatype_id == $category->id ){ echo "selected"; }@ENDPHP>{{$category->title}}</option>
                        @endforeach
                    
                    </select>
                </div>
                <div class="panel panel-primary results">
                @PHP
                    $re_key = array();
                    $re_value = array();
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
                    $catname1 = ucfirst($catname);
                    $catname1 = str_replace('-', ' ', $catname1);
                    $switch = strtolower(str_replace(' ', '-', $catname));
                $html = '';
                switch($switch){
                    case 'newspapers':
                        $html .= '<div class="panel-heading "><h3 class="panel-title">'.$catname1.' Options</h3></div><div class="panel-body"><div class="form-group">';
                            
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
                            $html .= '<div class="panel-heading "><h3 class="panel-title">'.$catname1.' Options</h3></div><div class="panel-body"><div class="form-group">';
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
                            $html .= '<div class="panel-heading "><h3 class="panel-title">'.$catname1.' Options</h3></div><div class="panel-body"><div class="form-group">';
                                foreach ($productmetadata as $title) {
                                       echo $re_key[] = $title->meta_key;
                                      echo $re_value[]  = $title->meta_value;
                                 }
                                $html .= '<label for="'.$re_key[0].'">Bus Shelter Ad Display Options: </label><input class="form-control" type="hidden" id="'.$re_key[0].'key" name="'.$re_key[0].'key" value="'.$re_key[0].'">'; 
                               
                                $rbsdisplay = unserialize($re_value[0]);       
                                foreach($bs_options as $key => $value){
                                    $html .= '<label class="checkbox-inline"><input name="'.$re_key[0].'[]" type="checkbox"';
                                    if(in_array($key, $rbsdisplay)){ $html .= " checked"; }
                                    $html .= ' value="'.$key.'">'.$value.'</label>';
                                }               
                                $html .= '</div><div class="form-group"><label for="'.$re_key[1].'">Do you want lighting options on Bus Stops?: </label><input class="form-control" type="hidden" id="'.$re_key[1].'key" name="'.$re_key[1].'key" value="'.$re_key[1].'">';         
                                foreach($bs_light as $key => $value){
                                    $html .= '<label class="checkbox-inline"><input name="bslighting"';
                                    if($key == $re_value[1]){$html .= " checked"; }
                                    $html .= ' type="radio" value="'.$key.'">'.$value.'</label>';
                                }
                            
                                $html .= '</div><div class="form-group"><label for="'.$re_key[2].'">Numbers Of Bus Shelters/Stops Display this Ad? : </label><input class="form-control" type="hidden" id="'.$re_key[2].'key" name="'.$re_key[2].'key" value="'.$re_key[2].'"><input class="form-control" type="text" name="bsnumber" value="'.$re_value[2].'" required></div></div>';
                               
                                                      

                    break;
                    case 'buses':
                       
                        if(!empty($productmetadata)){
                            foreach ($productmetadata as $title) {
                                $re_key[] = $title->meta_key;
                                $re_value[]  = $title->meta_value;
                            }
                            $html .= '<div class="panel-heading "><h3 class="panel-title">'.$catname1.' Options</h3></div><div class="panel-body"><div class="form-group">';
                            $html .= '<label for="'. $re_key[0].'">Buses Ad Display Options: </label><input class="form-control" type="hidden" id="'. $re_key[0].'key" name="'. $re_key[0].'key" value="'. $re_key[0].'">'; 
                            $rbsdbusdisplayisplay = unserialize($re_value[0]);        
                            foreach($bus_options as $key => $value){
                                $html .= '<label class="checkbox-inline"><input name="'. $re_key[0].'[]" type="checkbox"';
                                if(in_array($key, $rbsdbusdisplayisplay)){ $html .= " checked"; }
                                $html .= ' value="'.$key.'">'.$value.'</label>';
                            }
                                            
                            $html .= '</div><div class="form-group"><label for="'. $re_key[1].'">Numbers Of Buses Display this Ad? : </label><input class="form-control" type="hidden" id="'. $re_key[1].'key" name="'. $re_key[1].'key" value="'. $re_key[1].'"><input class="form-control" type="text" name="'. $re_key[1].'"  value="'. $re_value[1].'" required></div></div>';
                        }
                    break;
                    case 'auto':
                            $html .= '<div class="panel-heading "><h3 class="panel-title">'.$catname1.' Options</h3></div><div class="panel-body">';
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
                            $html .= '<div class="panel-heading "><h3 class="panel-title">'.$catname1.' Options</h3></div><div class="panel-body">';
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
                 echo $html;
                @ENDPHP
                    
                </div>
                <div class="form-group">
                    <label for="rank">City Rank:</label>
                    <input type="text" id="rank" name="rank" value="{{$productdata->rank}}" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="landmark">Landmark:</label>
                    <input type="text" id="landmark" name="landmark" value="{{$productdata->landmark}}" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="description">Description:</label>
                    <textarea id="description" name="description" class="form-control">{{$productdata->description}}</textarea>
                </div>
                
                <div class="form-group">
                    <label for="reference">Other Reference:</label>
                    <textarea id="reference" name="reference" class="form-control">{{$productdata->reference}}</textarea>
                </div>
                @PHP
                    $ad_status = array( 1 => 'Available', 2 => 'Sold Out', 3 => 'Coming Soon');
                @ENDPHP
                <div class="form-group">
                    <label for="status">Ad Status:</label>
                    <select class="form-control" name="status" id="status" required="required">
                        <option value="">--Select--</option>
                        @foreach( $ad_status as $key => $value )
                        <option value="{{$key}}" @PHP if($productdata->status == $key){
                            echo "Selected";
                        } @ENDPHP>{{$value}}</option>
                        @endforeach
                    
                    </select>
                </div>
               
                {{csrf_field()}}
               <button type="submit" class="btn btn-primary">Update Product</button>
                
            </form>
            </div>
            
        </div>
      
        
@endsection

@section('scripts')

<script>
    
</script>

@endsection