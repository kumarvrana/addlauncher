@extends('backend.layouts.backend-master')

@section('title')
   Add Newspaper | Ad Launcher
@endsection

@section('content')
    <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
          <h1 class="page-header">Print Media Add Form</h1>
   
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
  <form class="form" action="{{route('dashboard.postNewspaperForm')}}" method="post" enctype="multipart/form-data">
        <div class="step">
        
            <div class="step-header">General Options</div>
            <div class="form-group">
                    <label for="title">Ad Name:</label>
                    <input type="text" id="title" name="title" class="form-control" placeholder="Name of the product" value="{{old('title')}}" required>
                </div>
                <div class="form-group">
                    <label for="price">Ad Price:</label>
                    <input type="text" id="price" name="price" class="form-control" value="{{old('price')}}" placeholder="Put Base price here eg: 1213" required>
                </div>
                <div class="form-group">
                    <label for="location">Location:</label>
                    <input type="text" id="location" name="location" placeholder="example: saket metro/ IGI Airport" value="{{old('location')}}" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="city">City:</label>
                    <input type="text" id="city" name="city" placeholder="example: Mumbai" value="{{old('city')}}" class="form-control" required>
                </div>

                <div class="form-group">
                    <label for="ad-state">State:</label>
                    <input type="text" id="state" name="state" placeholder="example: Maharashtra" value="{{old('state')}}" class="form-control" required>
                </div>
                             
                <div class="form-group">
                    <label for="rank">City Rank:</label>
                    <input type="text" id="rank" name="rank" placeholder="example: (432) rank according to location" value="{{old('rank')}}" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="landmark">Landmark:</label>
                    <input type="text" id="landmark" name="landmark" placeholder="example: near children park or opposite to city post office" value="{{old('landmark')}}" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="description">Description:</label>
                    <textarea id="description" name="description" class="form-control">{{old('description')}}</textarea>
                </div>
                
                
                @PHP
                    $ad_status = array( 1 => 'Available', 2 => 'Sold Out', 3 => 'Coming Soon');
                @ENDPHP
                <div class="form-group">
                    <label for="status">Ad Status:</label>
                    <select class="form-control" name="status" id="status" required="required">
                        <option value="">--Select--</option>
                        @foreach( $ad_status as $key => $value )
                        <option value="{{$key}}">{{$value}}</option>
                        @endforeach
                    
                    </select>
                </div>

        </div>
        <div class="step">

               @PHP 
                    $printMedia_type = array('newspaper' => 'Newspaper', 'magazine' => 'Magazine');
                   

                    $newspaper_options = array('page1' => 'Page1', 'page3' => 'Page3','last_page' => 'Last Page','any_page' => 'Any Page',);
                    
                    $indianExpress_display_options = array('full_page' => 'Full Page', 'half_page' => 'Half Page', 'mini_a4' => 'Mini A4', 'full_page_centre_spread' => 'Full Page Centre Spread', 'mini_a4_centre_spread' => 'Mini A4 Centre Spread', 'horizontal_strip' => 'Horizontal Strip', 'vertical_strip' => 'Vertical Strip');

                    $indianExpress_premium_position_options = array('page_3_horizontal_solus' => 'Page 3 Horizontal Solus', 'inside_front_cover' => 'Inside Front Cover', 'inside_back_cover' => 'Inside_Back_Cover', 'back_page' => 'Back Page');

                    $indianExpress_innovations_options = array('front_false_cover' => 'Front False Cover', 'front_and_back_false_cover' => 'Front And Back False Cover', 'front_gate_fold' => 'Front Gate Fold', 'reverse_gate_fold' => 'Reverse Gate Fold', 'front_and_back_tab' => 'Front And Back Tab', 'front_tab' => 'Front Tab');

                    $indianExpress_businessAven_options = array('full_page' => 'Full Page', 'half_page' => 'Half Page', 'quarter_page' => 'Quarter Page');
                @ENDPHP
                
            <div class="step-header">Newspaper/Magazine General Options</div>
                <input type="hidden" name="modelname" id="modelname" value="Newspaper">

                                 
               
                <div class="panel panel-primary">
                    <div class="panel-heading "><h3 class="panel-title">Newspaper/Magazine General Options</h3></div><div class="panel-body">
                     <div class="form-group">
                         <label for="printmedia_type">Print Media Ad Type (Delhi):</label>
                            <select class="form-control" name="printmedia_type" id="printmedia_type" required="required">
                                <option value="">--Select--</option>
                                @foreach( $printMedia_type as $key => $value )
                                <option value="{{$key}}">{{$value}}</option>
                                @endforeach
                            
                            </select>
                                
                    </div> 
                    <div class="form-group">
                         <label for="newspaperlist">News Paper List (Delhi):</label>
                            <select class="form-control" name="newspaperlist" id="newspaperlist" required="required">
                                <option value="">--Select--</option>
                                @foreach( $newspapers_list as $newspaper )
                                <option value="{{$newspaper->name}}">{{$newspaper->name}}</option>
                                @endforeach
                            
                            </select>
                                
                    </div>
                     <div class="form-group">
                         <label for="magazinelist">Magazines List (Delhi):</label>
                            <select class="form-control" name="magazinelist" id="magazinelist" required="required">
                                <option value="">--Select--</option>
                                @foreach( $magazine_list as $magazine )
                                <option value="{{$magazine->name}}">{{$magazine->name}}</option>
                                @endforeach
                            
                            </select>
                                
                    </div> 
                    
                    <div class="form-group">
                        <label for="circulation">Circulation: </label>
                        <input class="form-control" type="text" name="circulation" placeholder="Enter Circulation">
                    </div>

                    <div class="form-group">
                            <label for="language">Languages:</label>
                            <select class="form-control" name="language" id="language" required="">
                                <option value="">--Language--</option>
                                @foreach( $languages as $language )
                                    <option value="{{$language->name}}">{{$language->name}}</option>
                                @endforeach
                            </select>
                    </div>

                
                    
                    <div class="form-group">
                        <label for="newspaperdisplay">Newspaper Display Options: </label>
                             
                    @foreach($newspaper_options as $key => $value)
                        <label class='checkbox-inline'><input data-label='Newspaper Ad Display Options' onclick="addDomToPriceOptions('{{$value}}')" name='newspaperdisplay[]' type='checkbox' value={{$key}}>{{$value}}</label>
                    @endforeach
                                       
                    </div> 
                      
                @PHP 
                    $other_options = array('jacket_front_page' => 'Jacket Front Page', 'jacket_front_insider' => 'Jacket Front Inside','pointer_ad' => 'Pointer Ad','sky_bus' => 'Sky Bus','ear_panel' => 'Ear Panel','half_page' => 'Half Page','quarter_page' => 'Quarter Page','pamphlets' => 'Pamphlets','flyers' => 'Flyers');
                @ENDPHP

                    <div class="form-group">
                        <label for="otherdisplay">Other Display Options: </label>
                             
                    @foreach($other_options as $key => $value)
                        <label class='checkbox-inline'><input data-label='Other Display Options' onclick="addDomToPriceOptions('{{$value}}')" name='otherdisplay[]' type='checkbox' value={{$key}}>{{$value}}</label>
                    @endforeach
                                       
                    </div>   

                    @PHP           
                    $classified_options = array('matrimonial' => 'Matrimonial', 'recruitment' => 'Recruitment','business' => 'Business','property' => 'Property','education' => 'Education','astrology' => 'Astrology','public_notices' => 'Public Notices','services' => 'Services','automobile' => 'Automobile','shopping' => 'Shopping');
                @ENDPHP

                    <div class="form-group">
                        <label for="classifieddisplay">Classified Display Options: </label>
                             
                    @foreach($classified_options as $key => $value)
                        <label class='checkbox-inline'><input data-label='Classified Display Options' onclick="addDomToPriceOptions('{{$value}}')" name='classifieddisplay[]' type='checkbox' value={{$key}}>{{$value}}</label>
                    @endforeach
                                       
                    </div>  

                      @PHP           
                    $pricing_options = array('per_sq_cm' => 'per sq cm', 'per_day' => 'per Day','per_inserts' => 'per Inserts');
                @ENDPHP

                    <div class="form-group">
                        <label for="pricingdisplay">Pricing Options: </label>
                             
                    @foreach($pricing_options as $key => $value)
                        <label class='checkbox-inline'><input data-label='pricing Display Options' onclick="addDomToPriceOptions('{{$value}}')" name='pricingdisplay[]' type='checkbox' value={{$key}}>{{$value}}</label>
                    @endforeach
                                       
                    </div>        

             


                    
                    <div class="form-group">
                        <label for="number">Numbers Of Newspaper Display this Ad? : </label>
                        <input class="form-control" type="text" name="number" required>
                    </div>

                    
                    
                    <div class="form-group">
                        <label for="discount">Discount (%): </label>
                        <input class="form-control" type="text" name="discount" placeholder="put an integer value for discount like 5 or 10">
                    </div>
                    </div>
                </div>

                <div class="step-header">Pricing Options</div>
                    <div id="light-content" class="alert alert-info">
                                You have check the Light Options in ads. So, Please fill the Price including light charges in different the Ad display Size!
                        </div>
                    <div id="pricing-options-step">
                        
                    </div>

            </div>
        
        <div class="step">
            <div class="step-header">Image and References Options</div>
            <div class="form-group">
                <label for="image">Ad Image:</label>
                <input type="file" id="image" name="image" class="form-control" required>
            </div>
            <div class="form-group">
                    <label for="reference">Other Reference:</label>
                    <textarea id="reference" name="reference" class="form-control">{{old('reference')}}</textarea>
                </div>
        </div>
        {{csrf_field()}}
        
        <button type="button" class="action back btn btn-info">Back</button>
        <button type="button" class="action next btn btn-info">Next</button>
        <button type="submit" class="action submit btn btn-success">Add Product</button>    
    </form>
   
   </div>
@endsection

@section('scripts')
<script src={{URL::to('js/multistep-form.js')}}></script>
@endsection