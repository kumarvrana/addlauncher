@extends('backend.layouts.backend-master')

@section('title')
   Edit Metro | Ad Launcher
@endsection

@section('content')
    <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
          <h1 class="page-header">Products Form</h1>
   
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
  <form class="form" action="{{route('dashboard.editmetrosad',['ID' => $metro->id])}}" method="post" enctype="multipart/form-data">
        <div class="step">
            <div class="step-header">General Options</div>
            <div class="form-group">
                    <label for="title">Ad Name:</label>
                    <input type="text" id="title" name="title" class="form-control" placeholder="Name of the product" value="{{$metro->title}}" required>
                </div>
                <div class="form-group">
                    <label for="price">Ad Price:</label>
                    <input type="text" id="price" name="price" class="form-control" value="{{$metro->price}}" placeholder="Put Base price here eg: 1213" required>
                </div>
                <div class="form-group">
                    <label for="location">Location:</label>
                    <input type="text" id="location" name="location" placeholder="example: saket metro/ IGI Metro" value="{{$metro->location}}" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="city">City:</label>
                    <input type="text" id="city" name="city" placeholder="example: Mumbai" value="{{$metro->city}}" class="form-control" required>
                </div>

                <div class="form-group">
                    <label for="ad-state">State:</label>
                    <input type="text" id="state" name="state" placeholder="example: Maharashtra" value="{{$metro->state}}" class="form-control" required>
                </div>
                             
                <div class="form-group">
                    <label for="rank">City Rank:</label>
                    <input type="text" id="rank" name="rank" placeholder="example: (432) rank according to location" value="{{$metro->rank}}" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="landmark">Landmark:</label>
                    <input type="text" id="landmark" name="landmark" placeholder="example: near children park or opposite to city post office" value="{{$metro->landmark}}" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="description">Description:</label>
                    <textarea id="description" name="description" value="{{$metro->description}}" class="form-control"></textarea>
                </div>
                
                
                @PHP
                    $ad_status = array( 1 => 'Available', 2 => 'Sold Out', 3 => 'Coming Soon');
                @ENDPHP
                <div class="form-group">
                    <label for="status">Ad Status:</label>
                    <select class="form-control" name="status" id="status" required="required">
                        <option value="">--Select--</option>
                        @foreach( $ad_status as $key => $value )
                        <option value="{{$key}}" @PHP if($metro->status == $key){
                            echo "Selected";
                        } @ENDPHP>{{$value}}</option>
                        @endforeach
                    
                    </select>
                </div>

        </div>
        <div class="step">
            <div class="step-header">Metro Ad Display Options</div>
                <input type="hidden" name="modelname" id="modelname" value="Metro">
                @PHP
                   $bsdisplayData = unserialize($metro->display_options);
               @ENDPHP
                
                <div class="panel panel-primary">

                    <div class="panel-heading "><h3 class="panel-title">Metro Options</h3></div><div class="panel-body">
                    <div class="form-group">
                         <label for="metro_line">Metro line:</label>
                            <select class="form-control" name="metro_line" id="metro_line" required="required">
                                <option value="">--Select--</option>
                                @foreach( $metro_line as $key => $value )
                               <option value="{{$key}}" @PHP if($metro->metro_line == $key){
                            echo "Selected";
                        } @ENDPHP>{{$value}}</option>
                                @endforeach
                            </select>    
                    </div>
                    <div class="form-group">
                         <label for="media">Media:</label>
                            <select class="form-control" name="media" id="media" required="required">
                                <option value="">--Select--</option>
                                @foreach( $media as $key => $value )
                                <option value="{{$key}}" @PHP if($metro->media == $key){
                            echo "Selected";
                        } @ENDPHP>{{$value}}</option>
                                @endforeach
                            </select>    
                    </div>
                    <div class="form-group">
                        <label for="metrodisplay">Metro Ad Types: </label>
                             
                    @foreach($metro_options as $key => $value)
                        <label class='checkbox-inline'><input data-label='Metro Ad Display Options' onclick="addDomToPriceOptionsMetro('{{$value}}')" name='metrodisplay[]' type='checkbox' @PHP if($bsdisplayData){ if( in_array($key, $bsdisplayData)){echo "checked"; } } @ENDPHP value="{{$key}}">{{$value}}</label>
                    @endforeach
                                       
                    </div> 
                    <div class="form-group"><label for="light_option">Do you want lighting options on Metro Panels?: </label><label class="checkbox-inline"><input class="checkEvent" data-label="Bus Shelter lighting options" onclick="addDomToPriceOptionsWithLight('No')" name="light_option" type="radio" value="0">No</label><label class="checkbox-inline"><input class="checkEvent" data-label="Bus Shelter lighting options" onclick="addDomToPriceOptionsWithLight('Yes')" name="light_option" type="radio" value="1">Yes</label></div>
                    
                    <div class="form-group">
                        <label for="metrodiscount">Discount (%): </label>
                        <input class="form-control" type="text" name="metrodiscount" placeholder="put an integer value for discount like 5 or 10">
                    </div>
                    </div>
                </div>

                <div class="step-header">Pricing Options</div>
                    <div id="light-content" class="alert alert-info">
                                You have check the Light Options in ads. So, Please fill the Price including light charges in different the Ad display Size!
                        </div>
                    <div id="pricing-options-step">
                        <input type="hidden" name="modelname" id="modelname" value="Metro">
                        <input type="hidden" id="priceData" value="{{json_encode(unserialize($fieldData))}}">
                        <input type="hidden" id="uncheckID" value="{{$metro->id}}">
                        <input type="hidden" id="tablename" value="metros">

                        @foreach($metropricemeta as $metroprice)
                            @PHP 
                                 $mainKey = substr($metroprice->price_key, 6);
                            @ENDPHP
                             <div id="punit_{{$mainKey}}" class="form-group">
                                <label for="unit_{{$mainKey}}">Unit of {{ucfirst(substr(str_replace("_", " ", $metroprice->price_key), 6))}} Metro Ad:</label>
                                <input class="form-control" type="text" name="unit_{{$mainKey}}" value="{{$metroprice->unit}}" required>
                            </div>
                            <div id="pnumber_of_face_{{$mainKey}}" class="form-group">
                                <label for="number_of_face_{{$mainKey}}">Number of {{ucfirst(substr(str_replace("_", " ", $metroprice->price_key), 6))}} Face:</label>
                                <input class="form-control" type="text" name="number_of_face_{{$mainKey}}" value="{{$metroprice->number_face}}" required>
                            </div>
                            <div id="pdimension_{{$mainKey}}" class="form-group">
                                <label for="dimension_{{$mainKey}}">Dimension of {{ucfirst(substr(str_replace("_", " ", $metroprice->price_key), 6))}} Metro Ad:</label>
                                <input class="form-control" type="text" name="dimension_{{$mainKey}}" value="{{$metroprice->dimension}}" required>
                            </div>
                            <div id="pprice_{{$mainKey}}" class="form-group">
                                <label for="price_{{$mainKey}}">Base Price of {{ucfirst(substr(str_replace("_", " ", $metroprice->price_key), 6))}} Metro Ad:</label>
                                <input class="form-control" type="text" name="price_{{$mainKey}}" value="{{$metroprice->base_price}}" required>
                            </div>
                            <div id="pprinting_price_{{$mainKey}}" class="form-group">
                                <label for="printing_price_{{$mainKey}}">Printing Charge of {{ucfirst(substr(str_replace("_", " ", $metroprice->price_key), 6))}} Metro Ad:</label>
                                <input class="form-control" type="text" name="printing_price_{{$mainKey}}" value="{{$metroprice->printing_charge}}" required>
                            </div>
                            <div id="ptotal_price_{{$mainKey}}" class="form-group">
                                <label for="total_price_{{$mainKey}}">Total Price of {{ucfirst(substr(str_replace("_", " ", $metroprice->price_key), 6))}} Metro Ad:</label>
                                <input class="form-control" type="text" name="total_price_{{$mainKey}}" value="{{$metroprice->totalprice}}" required>
                            </div>

                            
                        @endforeach
                       
                    </div>

            </div>
        
        <div class="step">
            <div class="step-header">Image and References Options</div>
            <div class="form-group">
                <label for="image">Ad Image:</label>
                <input type="file" id="image" name="image" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="reference_mail">Reference mail:</label>
                <input type="email" id="reference_mail" name="reference_mail" value="{{$metro->reference_mail}}" class="form-control" required>
            </div>
            <div class="form-group">
                    <label for="reference">Other Reference:</label>
                    <textarea id="reference" name="reference" class="form-control">{{$metro->references}}</textarea>
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
<script>
    var uncheckDeleteURL = "{{route('dashboard.deleteUncheckPriceMetro')}}";
</script>
<script src={{URL::to('js/multistep-form.js')}}></script>
@endsection