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
            <div class="step-header">Newspapers Ad Options</div>
            <input type="hidden" name="modelname" id="modelname" value="Newspaper">
              
                <div class="panel panel-primary">
                    <div class="panel-heading "><h3 class="panel-title">Newspaper Options</h3></div><div class="panel-body">
                         <div class="form-group">
                        <label for="circulation">Circulation: </label>
                        <input class="form-control" type="text" value="{{$newspaper->circulations}}" name="circulation" placeholder="Enter Circulation">
                    </div>

                    <div class="form-group">
                            <label for="language">Languages:</label><input type="hidden" id="languagekey" name="languagekey" value="language" class="form-control"><select class="form-control" name="language" id="language" required=""><option value="0">English</option><option value="1">Hindi</option><option value="2">Punjabi</option><option value="3">Sanskrit</option></select>
                    </div>

                @PHP
                   $newspaper_options = array('page1' => 'Page1', 'page3' => 'Page3','last_page' => 'Last Page','any_page' => 'Any Page');
                     $newspaperdisplayData = unserialize($newspaper->general_options);
                     
                @ENDPHP
                    <div class="form-group">
                        <label for="newspaperdisplay">Display Options: </label>
                          
                    @foreach($newspaper_options as $key => $value)
                        <label class='checkbox-inline'><input onclick="addDomToPriceOptions('{{$value}}', 'general_options')" name='newspaperdisplay[]' type='checkbox'  @PHP if($newspaperdisplayData){if(in_array($key, $newspaperdisplayData)){echo "checked"; }} @ENDPHP value="{{$key}}">{{$value}}</label>
                    @endforeach

                @PHP 
                    $other_options = array('jacket_front_page' => 'Jacket Front Page', 'jacket_front_insider' => 'Jacket Front Inside','pointer_ad' => 'Pointer Ad','sky_bus' => 'Sky Bus','ear_panel' => 'Ear Panel','half_page' => 'Half Page','quarter_page' => 'Quarter Page','pamphlets' => 'Pamphlets','flyers' => 'Flyers');
                    $newspaperotherData = unserialize($newspaper->other_options);
                    
                @ENDPHP

                    <div class="form-group">
                        <label for="otherdisplay">Other Display Options: </label>
                             
                    @foreach($other_options as $key => $value)
                        <label class='checkbox-inline'><input onclick="addDomToPriceOptions('{{$value}}', 'other_options')" name='otherdisplay[]' type='checkbox'  @PHP if($newspaperotherData){if(in_array($key, $newspaperotherData)){echo "checked"; }} @ENDPHP  value={{$key}}>{{$value}}</label>
                    @endforeach
                                       
                    </div>   

                    @PHP           
                    $classified_options = array('matrimonial' => 'Matrimonial', 'recruitment' => 'Recruitment','business' => 'Business','property' => 'Property','education' => 'Education','astrology' => 'Astrology','public_notices' => 'Public Notices','services' => 'Services','automobile' => 'Automobile','shopping' => 'Shopping');
                    $newspaperclassifiedData = unserialize($newspaper->classified_options);
                @ENDPHP

                    <div class="form-group">
                        <label for="classifieddisplay">Classified Display Options: </label>
                             
                    @foreach($classified_options as $key => $value)
                        <label class='checkbox-inline'><input data-label='classified_options' onclick="addDomToPriceOptions('{{$value}}', 'classified_options')" name='classifieddisplay[]' type='checkbox'  @PHP if($newspaperclassifiedData){if(in_array($key, $newspaperclassifiedData)){echo "checked"; }} @ENDPHP value={{$key}}>{{$value}}</label>
                    @endforeach
                                       
                    </div>  

                      @PHP           
                    $pricing_options = array('per_sq_cm' => 'per sq cm', 'per_day' => 'per Day','per_inserts' => 'per Inserts');
                    $newspaperpricingData = unserialize($newspaper->pricing_options);
                @ENDPHP

                    <div class="form-group">
                        <label for="pricingdisplay">Pricing Options: </label>
                             
                    @foreach($pricing_options as $key => $value)
                        <label class='checkbox-inline'><input data-label='pricing_options' onclick="addDomToPriceOptions('{{$value}}', 'pricing_options')" name='pricingdisplay[]' type='checkbox'  @PHP if($newspaperpricingData){if(in_array($key, $newspaperpricingData)){echo "checked"; }} @ENDPHP value={{$key}}>{{$value}}</label>
                    @endforeach
                                       
                    </div>      
                                       
                    </div>
                    <div class="form-group">
                        <label for="number">Numbers Of Newspapers Display this Ad? : </label>
                        <input class="form-control" type="text" name="number" value="{{$newspaper->numberofnewspapers}}" required>
                    </div>

                     <div class="form-group"><label for="bslighting">Do you want lighting options on Newspaper Panels?: </label><label class="checkbox-inline"><input class="checkEvent" data-label="Bus Shelter lighting options" onclick="addDomToPriceOptionsWithLight('No')" name="bslighting" type="radio" value="0">No</label><label class="checkbox-inline"><input class="checkEvent" data-label="Bus Shelter lighting options" onclick="addDomToPriceOptionsWithLight('Yes')" name="newspaperlighting" type="radio" value="1">Yes</label></div>

                     

                    <div class="form-group">
                        <label for="discount">Discount (%): </label>
                        <input class="form-control" type="text" value="{{$newspaper->discount}}" name="discount" placeholder="put an integer value for discount like 5 or 10">
                    </div>
                    </div>

                </div>

                <div class="step-header">Pricing Options</div>
                    <div id="light-content" class="alert alert-info">
                                You have check the Light Options in ads. So, Please fill the Price including light charges in different the Ad display Size!
                        </div>
                    <div id="pricing-options-step">
                        <input type="hidden" id="priceData" value="{{json_encode(unserialize($fieldData))}}">
                        <input type="hidden" id="general_options" value="{{json_encode(unserialize($newspaper->general_options))}}">
                        <input type="hidden" id="other_options" value="{{json_encode(unserialize($newspaper->other_options))}}">
                        <input type="hidden" id="classified_options" value="{{json_encode(unserialize($newspaper->classified_options))}}">
                        <input type="hidden" id="pricing_options" value="{{json_encode(unserialize($newspaper->pricing_options))}}">
                        <input type="hidden" id="uncheckID" value="{{$newspaper->id}}">
                        <input type="hidden" id="tablename" value="newspapers">
                       
                         @foreach($newspaperpricemeta as $newspaperprice)
                         @PHP
                             $prefix = explode('_', $newspaperprice->price_key);
                             $labelpre = ucfirst($prefix[0]);
                             
                             switch($labelpre){
                                 case 'Price':
                                    $p_key = str_replace("_", " ", $newspaperprice->price_key);
                                    $label =  ucfirst(substr($p_key, 6));
                                    $full_label = "Price for $label Newspaper Ad Per unit:";
                                 break;
                                 case 'Number':
                                    $p_key = str_replace("_", " ", $newspaperprice->price_key);
                                    $label =  ucfirst(substr($p_key, 7));
                                    $full_label = "Number of Newspaper for $label Ad:";
                                 break;
                                 case 'Duration':
                                    $p_key = str_replace("_", " ", $newspaperprice->price_key);
                                    $label =  ucfirst(substr($p_key, 9));
                                    $full_label = "Ad Duration of Newspaper for $label Ad (in Months):";
                                 break;

                             }
                         @ENDPHP
                        <div id="p{{$newspaperprice->price_key}}" class="form-group">
                            <label for="{{$newspaperprice->price_key}}">{{$full_label}}</label>
                            <input class="form-control" type="text" name="{{$newspaperprice->price_key}}" value="{{$newspaperprice->price_value}}" required>
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