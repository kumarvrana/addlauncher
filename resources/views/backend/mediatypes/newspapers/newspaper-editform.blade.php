@extends('backend.layouts.backend-master')

@section('title')
   Edit Newspaper | Ad Launcher
@endsection

@section('content')
    <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
          <h1 class="page-header">Newspaper Edit Form</h1>
   
        <div class="progress">
  <div class="progress-bar progress-bar-striped active" role="progressbar" aria-valuemin="0" aria-valuemax="100">
</div>
    </div>
    <hr>
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
            <?php //dd(unserialize($newspaper->genre)); ?>
  <form class="form" action="{{route('dashboard.Postnewspapersad', ['ID' => $newspaper->id])}}" method="post" enctype="multipart/form-data">
		<div class="step">
            <div class="step-header">General Options</div>
            <div class="form-group">
                    <label for="title">Ad Name:</label>
                    <input type="text" id="title" name="title" class="form-control" placeholder="Name of the product" value="{{$newspaper->title}}" required>
                </div>
                <div class="form-group">
                    <label for="price">Ad Price:</label>
                    <input type="text" id="price" name="price" class="form-control" value="{{$newspaper->price}}" placeholder="Put Base price here eg: 1213" required>
                </div>
                <div class="form-group">
                    <label for="location">Location:</label>
                    <input type="text" id="location" name="location" placeholder="example: saket metro/ IGI Airport" value="{{$newspaper->location}}" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="city">City:</label>
                    <input type="text" id="city" name="city" placeholder="example: Mumbai" value="{{$newspaper->city}}" class="form-control" required>
                </div>

                <div class="form-group">
                    <label for="ad-state">State:</label>
                    <input type="text" id="state" name="state" placeholder="example: Maharashtra" value="{{$newspaper->state}}" class="form-control" required>
                </div>
                             
                <div class="form-group">
                    <label for="rank">City Rank:</label>
                    <input type="text" id="rank" name="rank" placeholder="example: (432) rank according to location" value="{{$newspaper->rank}}" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="landmark">Landmark:</label>
                    <input type="text" id="landmark" name="landmark" placeholder="example: near children park or opposite to city post office" value="{{$newspaper->landmark}}" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="description">Description:</label>
                    <textarea id="description" name="description" class="form-control">{{$newspaper->description}}</textarea>
                </div>
                
                
                @PHP
                    $ad_status = array( 1 => 'Available', 2 => 'Sold Out', 3 => 'Coming Soon');
                @ENDPHP
                <div class="form-group">
                    <label for="status">Ad Status:</label>
                    <select class="form-control" name="status" id="status" required="required">
                        <option value="">--Select--</option>
                        @foreach( $ad_status as $key => $value )
                        <option value="{{$key}}" @PHP if($newspaper->status == $key){
                            echo "Selected";
                        } @ENDPHP>{{$value}}</option>
                        @endforeach
                    
                    </select>
                </div>

        </div>
		<div class="step">
            <div class="step-header">Newspaper/Magazine General Options</div>
            <input type="hidden" name="modelname" id="modelname" value="Newspaper">
              
                <div class="panel panel-primary">
                    <div class="panel-heading "><h3 class="panel-title">Newspaper/Magazine General Options</h3></div>
                <div class="panel-body">
                    <div class="form-group">
                        <label for="printmedia_type">Print Media Ad Type (Delhi):</label>
                        <select class="form-control" name="printmedia_type" id="printmedia_type" required="required">
                            <option value="">--Select--</option>
                            @foreach( $printMedia_type as $key => $value )
                            <option value="{{$key}}" <?php if($newspaper->printmedia_type == $key){
                            echo "Selected";
                        } ?>>{{$value}}</option>
                            @endforeach
                        </select>    
                    </div> 
                    <div class="form-group newspaper">
                        <label for="newspaperlist">News Paper List (Delhi):</label>
                        <select class="form-control" name="printmedia_name" id="newspaperlist" required="required">
                            <option value="">--Select--</option>
                            @foreach( $newspapers_list as $newspapers )
                            <option value="{{$newspapers->name}}">{{$newspapers->name}}</option>
                            @endforeach
                        </select>            
                    </div>
                    <div class="form-group magazine">
                        <label for="magazinelist">Magazines List (Delhi):</label>
                        <select class="form-control" name="printmedia_name" id="magazinelist" required="required">
                            <option value="">--Select--</option>
                            @foreach( $magazine_list as $magazine )
                            <option value="{{$magazine->name}}"
                            <?php if($newspaper->printmedia_name == $magazine->name){
                                echo "Selected";
                            } ?>>{{$magazine->name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group magazine">
                        <label for="genre">Magazine Genres: </label>
                         @foreach($megazineGenre as $value)
                        <label class='checkbox-inline'><input <?php if(unserialize($newspaper->genre)){if(in_array($value, unserialize($newspaper->genre))){echo "checked";}} ?> data-label='Magazine Ad Genre Options' name='genre[]' type='checkbox' value={{$value}}>{{$value}}</label>
                        @endforeach
                   </div> 
                    <div class="form-group">
                        <label for="circulation">Circulation: </label>
                        <input class="form-control" type="text" value="{{$newspaper->circulations}}" name="circulation" placeholder="Enter Circulation">
                    </div>
                    <div class="form-group">
                        <label for="language">Languages:</label>
                        <select class="form-control" name="language" id="language" required="">
                            <option value="">--Language--</option>
                            @foreach( $languages as $language )
                                <option value="{{$language->name}}"
                                <?php if($newspaper->language == $language->name){
                                echo "Selected";
                            } ?>>{{$language->name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group magazine">
                        <label for="magazinedisplay">Magazine Display Options: </label>
                         @foreach($magezineOption as $key => $value)
                        <label class='checkbox-inline'><input <?php if(unserialize($newspaper->magazine_options)){if(in_array($key, unserialize($newspaper->magazine_options))){echo "checked";}} ?> data-label='Magazine Ad Display Options' onclick="addDomToPriceOptionsMegazine('{{$value}}',  'megazine')" name='magazinedisplay[]' type='checkbox' value={{$key}}>{{$value}}</label>
                        @endforeach
                   </div> 

                @PHP
                   $newspaper_options = array('page1' => 'Page1', 'page3' => 'Page3','last_page' => 'Last Page','any_page' => 'Any Page');
                     $newspaperdisplayData = unserialize($newspaper->general_options);
                     
                @ENDPHP
                    <div class="form-group newspaper">
                        <label for="newspaperdisplay">Display Options: </label>
                          
                    @foreach($newspaper_options as $key => $value)
                        <label class='checkbox-inline'><input onclick="addDomToPriceOptions('{{$value}}', 'general_options')" name='newspaperdisplay[]' type='checkbox'  @PHP if($newspaperdisplayData){if(in_array($key, $newspaperdisplayData)){echo "checked"; }} @ENDPHP value="{{$key}}">{{$value}}</label>
                    @endforeach

                @PHP 
                    $other_options = array('jacket_front_page' => 'Jacket Front Page', 'jacket_front_insider' => 'Jacket Front Inside','pointer_ad' => 'Pointer Ad','sky_bus' => 'Sky Bus','ear_panel' => 'Ear Panel','half_page' => 'Half Page','quarter_page' => 'Quarter Page','pamphlets' => 'Pamphlets','flyers' => 'Flyers');
                    $newspaperotherData = unserialize($newspaper->other_options);
                    
                @ENDPHP

                    <div class="form-group newspaper">
                        <label for="otherdisplay">Other Display Options: </label>
                             
                    @foreach($other_options as $key => $value)
                        <label class='checkbox-inline'><input onclick="addDomToPriceOptions('{{$value}}', 'other_options')" name='otherdisplay[]' type='checkbox'  @PHP if($newspaperotherData){if(in_array($key, $newspaperotherData)){echo "checked"; }} @ENDPHP  value={{$key}}>{{$value}}</label>
                    @endforeach
                                       
                    </div>   

                    @PHP           
                    $classified_options = array('matrimonial' => 'Matrimonial', 'recruitment' => 'Recruitment','business' => 'Business','property' => 'Property','education' => 'Education','astrology' => 'Astrology','public_notices' => 'Public Notices','services' => 'Services','automobile' => 'Automobile','shopping' => 'Shopping');
                    $newspaperclassifiedData = unserialize($newspaper->classified_options);
                @ENDPHP

                    <div class="form-group newspaper">
                        <label for="classifieddisplay">Classified Display Options: </label>
                             
                    @foreach($classified_options as $key => $value)
                        <label class='checkbox-inline'><input data-label='classified_options' onclick="addDomToPriceOptions('{{$value}}', 'classified_options')" name='classifieddisplay[]' type='checkbox'  @PHP if($newspaperclassifiedData){if(in_array($key, $newspaperclassifiedData)){echo "checked"; }} @ENDPHP value={{$key}}>{{$value}}</label>
                    @endforeach
                                       
                    </div>  

                      @PHP           
                    $pricing_options = array('per_sq_cm' => 'per sq cm', 'per_day' => 'per Day','per_inserts' => 'per Inserts');
                    $newspaperpricingData = unserialize($newspaper->pricing_options);
                @ENDPHP

                    <div class="form-group newspaper">
                        <label for="pricingdisplay">Pricing Options: </label>
                             
                    @foreach($pricing_options as $key => $value)
                        <label class='checkbox-inline'><input data-label='pricing_options' onclick="addDomToPriceOptions('{{$value}}', 'pricing_options')" name='pricingdisplay[]' type='checkbox'  @PHP if($newspaperpricingData){if(in_array($key, $newspaperpricingData)){echo "checked"; }} @ENDPHP value={{$key}}>{{$value}}</label>
                    @endforeach
                                       
                    </div>      
                                       
                    </div>
                    <div class="form-group">
                        <label for="discount">Discount (%): </label>
                        <input class="form-control" type="text" value="{{$newspaper->discount}}" name="discount" placeholder="put an integer value for discount like 5 or 10">
                    </div>
                    </div>

                </div>

                <div class="step-header">Pricing Options</div>
                  
                    <div id="pricing-options-step">
                        <input type="hidden" id="priceData" value="{{json_encode(unserialize($fieldData))}}">
                        <input type="hidden" id="general_options" value="{{json_encode(unserialize($newspaper->general_options))}}">
                        <input type="hidden" id="other_options" value="{{json_encode(unserialize($newspaper->other_options))}}">
                        <input type="hidden" id="classified_options" value="{{json_encode(unserialize($newspaper->classified_options))}}">
                        <input type="hidden" id="pricing_options" value="{{json_encode(unserialize($newspaper->pricing_options))}}">
                        <input type="hidden" id="uncheckID" value="{{$newspaper->id}}">
                        <input type="hidden" id="tablename" value="newspapers">
                       
                        @foreach($newspaperpricemeta as $newspaperprice)
                            <div id="p{{$newspaperprice->price_key}}" class="form-group">
                                <label for="{{$newspaperprice->price_key}}">Price for {{ucwords(substr(str_replace('_', ' ', $newspaperprice->price_key), 6))}} Megazine Ad Per unit:</label>
                                <input class="form-control" type="text" name="{{$newspaperprice->price_key}}" value="{{$newspaperprice->price_value}}" required>
                            </div>
                            <div id="p{{$newspaperprice->number_key}}" class="form-group">
                                <label for="{{$newspaperprice->number_key}}">Number of Times Megazine print {{ucwords(substr(str_replace('_', ' ', $newspaperprice->price_key), 6))}} Ad(in 1 month):</label>
                                <input class="form-control" type="text" name="{{$newspaperprice->number_key}}" value="{{$newspaperprice->number_value}}" required>
                            </div>
                        @endforeach
                    </div>

            </div>
		
        <div class="step">
            <div class="step-header">Image and References Options</div>
            <div class="form-group">
                <label for="image">Ad Image:</label>
                <input type="file" id="image" name="image" class="form-control">
            </div>
            <div class="form-group">
                <label for="reference_mail">Reference Mail:</label>
                <input type="email" id="reference_mail" name="reference_mail" value="{{$newspaper->reference_mail}}" class="form-control" required>
            </div>
            <div class="form-group">
                    <label for="reference">Other Reference:</label>
                    <textarea id="reference" name="reference" class="form-control">{{$newspaper->references}}</textarea>
                </div>
        </div>
        {{csrf_field()}}
		
		<button type="button" class="action back btn btn-info">Back</button>
		<button type="button" class="action next btn btn-info">Next</button>
		<button type="submit" class="action submit btn btn-success">Edit Product</button>	
  	</form>
   
   </div>
@endsection

@section('scripts')
<script>
    var uncheckDeleteURL = "{{route('dashboard.deleteUncheckPrice', ['table' => 'Newspaper'])}}";
</script>
<script src={{URL::to('js/multistep-form.js')}}></script>
@endsection