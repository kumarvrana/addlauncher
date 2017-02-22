@extends('backend.layouts.backend-master')

@section('title')
   Edit Auto | Ad Launcher
@endsection

@section('content')
    <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
          <h1 class="page-header">Auto Edit Form</h1>
   
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
  <form class="form" action="{{route('dashboard.editautosad', ['ID' => $auto->id])}}" method="post" enctype="multipart/form-data">
        <div class="step">
            <div class="step-header">General Options</div>
            <div class="form-group">
                    <label for="title">Ad Name:</label>
                    <input type="text" id="title" name="title" class="form-control" placeholder="Name of the product" value="{{$auto->title}}" required>
                </div>
                <div class="form-group">
                    <label for="price">Ad Price:</label>
                    <input type="text" id="price" name="price" class="form-control" value="{{$auto->price}}" placeholder="Put Base price here eg: 1213" required>
                </div>
                <div class="form-group">
                    <label for="location">Location:</label>
                    <input type="text" id="location" name="location" placeholder="example: saket metro/ IGI Airport" value="{{$auto->location}}" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="city">City:</label>
                    <input type="text" id="city" name="city" placeholder="example: Mumbai" value="{{$auto->city}}" class="form-control" required>
                </div>

                <div class="form-group">
                    <label for="ad-state">State:</label>
                    <input type="text" id="state" name="state" placeholder="example: Maharashtra" value="{{$auto->state}}" class="form-control" required>
                </div>
                             
                <div class="form-group">
                    <label for="rank">City Rank:</label>
                    <input type="text" id="rank" name="rank" placeholder="example: (432) rank according to location" value="{{$auto->rank}}" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="landmark">Landmark:</label>
                    <input type="text" id="landmark" name="landmark" placeholder="example: near children park or opposite to city post office" value="{{$auto->landmark}}" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="description">Description:</label>
                    <textarea id="description" name="description" class="form-control">{{$auto->description}}</textarea>
                </div>
                
                
                @PHP
                    $ad_status = array( 1 => 'Available', 2 => 'Sold Out', 3 => 'Coming Soon');
                @ENDPHP
                <div class="form-group">
                    <label for="status">Ad Status:</label>
                    <select class="form-control" name="status" id="status" required="required">
                        <option value="">--Select--</option>
                        @foreach( $ad_status as $key => $value )
                        <option value="{{$key}}" @PHP if($auto->status == $key){
                            echo "Selected";
                        } @ENDPHP>{{$value}}</option>
                        @endforeach
                    
                    </select>
                </div>

        </div>
        <div class="step">
            <div class="step-header">Auto Display Options</div>
            <input type="hidden" name="modelname" id="modelname" value="Auto">
               @PHP
                   $auto_options = array('front' => 'Front', 'back' => 'Back', 'hood' => 'Hood', 'interior' => 'Interior');
                     $autodisplayData = unserialize($auto->display_options);

                @ENDPHP
                <div class="panel panel-primary">
                    <div class="panel-heading "><h3 class="panel-title">Auto Options</h3></div><div class="panel-body">



                    <div class="form-group">
                        <label for="bsdautodisplayisplay">Auto Ad Display Options: </label>
                          
                    @foreach($auto_options as $key => $value)
                        <label class='checkbox-inline'><input data-label='Autos Ad Display Options' onclick="addDomToPriceOptions('{{$value}}')" name='autodisplay[]' type='checkbox'  @PHP if(in_array($key, $autodisplayData)){echo "checked"; } @ENDPHP value="{{$key}}">{{$value}}</label>
                    @endforeach
                                       
                    </div>


                    <div class="form-group">

                    @PHP
                    $pamphlets_options = array('large_pamphlets' => 'Large Pamphlets', 'medium_pamphlets' => 'Medium Pamphlets', 'small_pamphlets' => 'Small Pamphlets');
                     $frontpamphlets = unserialize($auto->front_pamphlets_reactanguler_options);

                    @ENDPHP
                        <label for="autofrontprdisplay">Auto Front Pamphlets/Reactanguler Options: </label>

                         @foreach($pamphlets_options as $key => $value)
                        <label class='checkbox-inline'><input data-label='Auto Ad Display Options' onclick="addDomToPriceOptions('{{$value}}')" name='autofrontprdisplay[]' type='checkbox' @PHP if(in_array($key, $frontpamphlets)){echo "checked"; } @ENDPHP value={{$key}}>{{$value}}</label>
                    @endforeach

                    </div>

                    <div class="form-group">

                    @PHP
                    $front_sticker_options = array('large_front_sticker' => 'Large Front Sticker', 'medium_front_sticker' => 'Medium Front Sticker', 'small_front_sticker' => 'Small Front Sticker');
                     $stickeroption = unserialize($auto->front_stickers_options);

                    @ENDPHP
                        <label for="autostickerdisplay">Auto Front Stickers Options:</label>

                         @foreach($front_sticker_options as $key => $value)
                        <label class='checkbox-inline'><input data-label='Auto Front Stickers Options' onclick="addDomToPriceOptions('{{$value}}')" name='autostickerdisplay[]' type='checkbox' @PHP if(in_array($key, $stickeroption)){echo "checked"; } @ENDPHP value={{$key}}>{{$value}}</label>
                    @endforeach

                    </div>

                     <div class="form-group">

                    @PHP
                    $auto_hood_options = array('full_auto_hood' => 'Full Auto Hood', 'left_auto_hood' => 'Left Auto Hood', 'right_auto_hood' => 'Right Auto Hood');
                     $hoodoption = unserialize($auto->hood_options);

                    @ENDPHP
                        <label for="autohooddisplay">Auto Hood Options:</label>

                         @foreach($auto_hood_options as $key => $value)
                        <label class='checkbox-inline'><input data-label='Auto Hood Options' onclick="addDomToPriceOptions('{{$value}}')" name='autohooddisplay[]' type='checkbox' @PHP if(in_array($key, $hoodoption)){echo "checked"; } @ENDPHP value={{$key}}>{{$value}}</label>
                    @endforeach

                    </div>

                      <div class="form-group">

                    @PHP
                    $auto_interior_options = array('roof_interior' => 'Roof Interior', 'driver_seat_interior' => 'Driver Seat Interior');
                     $interior_options = unserialize($auto->interior_options);

                    @ENDPHP
                        <label for="autointeriordisplay">Auto Interior Options:</label>

                         @foreach($auto_interior_options as $key => $value)
                        <label class='checkbox-inline'><input data-label='Auto Interior Options' onclick="addDomToPriceOptions('{{$value}}')" name='autointeriordisplay[]' type='checkbox' @PHP if(in_array($key, $interior_options)){echo "checked"; } @ENDPHP value={{$key}}>{{$value}}</label>
                    @endforeach

                    </div>




                    <div class="form-group"><label for="bslighting">Do you want lighting options on Auto Panels?: </label><label class="checkbox-inline"><input class="checkEvent" data-label="Bus Shelter lighting options" onclick="addDomToPriceOptionsWithLight('No')" name="bslighting" type="radio" value="0">No</label><label class="checkbox-inline"><input class="checkEvent" data-label="Bus Shelter lighting options" onclick="addDomToPriceOptionsWithLight('Yes')" name="autolighting" type="radio" value="1">Yes</label></div>



                    <div class="form-group">
                        <label for="autosnumber">Numbers Of Autos Display this Ad? : </label>
                        <input class="form-control" type="text" name="autosnumber" value="{{$auto->autonumber}}" required>
                    </div>
                    <div class="form-group">
                        <label for="autosnumber">Discount (%): </label>
                        <input class="form-control" type="text" name="autodiscount" placeholder="put an integer value for discount like 5 or 10">
                    </div>
                    </div>
                </div>

                <div class="step-header">Pricing Options</div>
                    <div id="light-content" class="alert alert-info">
                                You have check the Light Options in ads. So, Please fill the Price including light charges in different the Ad display Size!
                        </div>
                    <div id="pricing-options-step">
                        <input type="hidden" id="priceData" value="{{json_encode(unserialize($fieldData))}}">
                        <input type="hidden" id="uncheckID" value="{{$auto->id}}">
                        <input type="hidden" id="tablename" value="autos">
                         @foreach($autopricemeta as $autoprice)
                         @PHP $p_key = str_replace("_", " ", $autoprice->price_key);
                             $label =  ucfirst(substr($p_key, 6));
                         @ENDPHP
                        <div id="p{{$autoprice->price_key}}" class="form-group">
                            <label for="{{$autoprice->price_key}}">Price for {{$label}} Auto Ad:</label>
                            <input class="form-control" type="text" name="{{$autoprice->price_key}}" value="{{$autoprice->price_value}}" required>
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
                    <textarea id="reference" name="reference" class="form-control">{{$auto->references}}</textarea>
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
    var uncheckDeleteURL = "{{route('dashboard.deleteUncheckPrice')}}";
</script>
<script src={{URL::to('js/multistep-form.js')}}></script>
@endsection