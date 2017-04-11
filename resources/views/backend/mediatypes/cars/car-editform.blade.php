@extends('backend.layouts.backend-master')

@section('title')
   Edit Car | Ad Launcher
@endsection

@section('content')
    <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
          <h1 class="page-header">Car Edit Form</h1>
   
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
  <form class="form" action="{{route('dashboard.Postcarsad', ['ID' => $car->id])}}" method="post" enctype="multipart/form-data">
		<div class="step">
            <div class="step-header">General Options</div>
            <div class="form-group">
                    <label for="title">Ad Name:</label>
                    <input type="text" id="title" name="title" class="form-control" placeholder="Name of the product" value="{{$car->title}}" required>
                </div>
                <div class="form-group">
                    <label for="price">Ad Price:</label>
                    <input type="text" id="price" name="price" class="form-control" value="{{$car->price}}" placeholder="Put Base price here eg: 1213" required>
                </div>
                <div class="form-group">
                    <label for="location">Location:</label>
                    <input type="text" id="location" name="location" placeholder="example: saket metro/ IGI Car" value="{{$car->location}}" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="city">City:</label>
                    <input type="text" id="city" name="city" placeholder="example: Mumbai" value="{{$car->city}}" class="form-control" required>
                </div>

                <div class="form-group">
                    <label for="ad-state">State:</label>
                    <input type="text" id="state" name="state" placeholder="example: Maharashtra" value="{{$car->state}}" class="form-control" required>
                </div>
                             
                <div class="form-group">
                    <label for="rank">City Rank:</label>
                    <input type="text" id="rank" name="rank" placeholder="example: (432) rank according to location" value="{{$car->rank}}" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="landmark">Landmark:</label>
                    <input type="text" id="landmark" name="landmark" placeholder="example: near children park or opposite to city post office" value="{{$car->landmark}}" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="description">Description:</label>
                    <textarea id="description" name="description" class="form-control">{{$car->description}}</textarea>
                </div>
                
                
                @PHP
                    $ad_status = array( 1 => 'Available', 2 => 'Sold Out', 3 => 'Coming Soon');
                @ENDPHP
                <div class="form-group">
                    <label for="status">Ad Status:</label>
                    <select class="form-control" name="status" id="status" required="required">
                        <option value="">--Select--</option>
                        @foreach( $ad_status as $key => $value )
                        <option value="{{$key}}" @PHP if($car->status == $key){
                            echo "Selected";
                        } @ENDPHP>{{$value}}</option>
                        @endforeach
                    
                    </select>
                </div>

        </div>
		<div class="step">
            <div class="step-header">Cars Ad Options</div>
                @PHP
                     $carType = array('micro_and_mini' => 'Micro And Mini', 'sedan' => 'Sedan', 'suv' => 'Suv', 'large' => 'Large');
                     $car_options = array('bumper' => 'Bumper', 'rear_window_decals' => 'Rear Window Decals', 'doors' => 'Doors');
                     $cardisplayData = unserialize($car->display_options);
                @ENDPHP
                <div class="panel panel-primary">
                    <div class="panel-heading "><h3 class="panel-title">Car Options</h3></div>
                    <div class="panel-body">
                    <div class="form-group">
                            <label for="cartype">Choose Car Type:</label>
                            <select class="form-control" name="cartype" disabled id="status" required="required">
                                <option value="">--Select--</option>
                                @foreach( $carType as $key => $value )
                                <option value="{{$key}}" @PHP if($car->cartype == $key){
                            echo "Selected";
                        } @ENDPHP>{{$value}}</option>
                                @endforeach
                            
                            </select>
                        </div>
                    <div class="form-group">
                        <label for="cardisplay">Cars Ad Display Options: </label>
                          
                    @foreach($car_options as $key => $value)
                        <label class='checkbox-inline'><input data-label='Cars Ad Display Options' onclick="addDomToPriceOptions('{{$value}}')" name='cardisplay[]' type='checkbox'  @PHP if($cardisplayData){if(in_array($key, $cardisplayData)){echo "checked"; } }@ENDPHP value="{{$key}}">{{$value}}</label>
                    @endforeach
                                       
                    </div>

                      <!-- <div class="form-group"><label for="bslighting">Do you want lighting options on Car Panels?: </label><label class="checkbox-inline"><input class="checkEvent" data-label="Car Shelter lighting options" onclick="addDomToPriceOptionsWithLight('No')" name="carlighting" type="radio" @PHP if($car->light_option == 0) echo "checked"; @ENDPHP value="0">No</label><label class="checkbox-inline"><input class="checkEvent" data-label="Car Shelter lighting options" onclick="addDomToPriceOptionsWithLight('Yes')" name="carlighting" type="radio" @PHP if($car->light_option == 1) echo "checked"; @ENDPHP value="1">Yes</label></div> -->

                       <div class="form-group">
                        <label for="cardiscount">Discount (%): </label>
                        <input class="form-control" type="text"  name="cardiscount" placeholder="put an integer value for discount like 5 or 10" value="{{$car->discount}}">
                    </div>


                    <div class="form-group">
                        <label for="carsnumber">Numbers Of Cars Display this Ad? : </label>
                        <input class="form-control" type="text" name="carnumber" value="{{$car->numberofcars}}" required></div>
                    </div>

                  

                </div>

                <div class="step-header">Pricing Options</div>
                    <div id="light-content" class="alert alert-info">
                                You have check the Light Options in ads. So, Please fill the Price including light charges in different the Ad display Size!
                        </div>
                     <div id="pricing-options-step">
                         <input type="hidden" name="modelname" id="modelname" value="Car">
                        <input type="hidden" id="priceData" value="{{json_encode(unserialize($fieldData))}}">
                        <input type="hidden" id="uncheckID" value="{{$car->id}}">
                        <input type="hidden" id="tablename" value="cars">

                         @foreach($carpricemeta as $carprice)
                          <div id="p{{$carprice->price_key}}" class="form-group">
                                <label for="{{$carprice->price_key}}">Price for {{ucfirst(substr(str_replace("_", " ", $carprice->price_key), 6))}} Car Ad:</label>
                                <input class="form-control" type="text" name="{{$carprice->price_key}}" value="{{$carprice->price_value}}" required>
                            </div>
                            <div id="p{{$carprice->number_key}}" class="form-group">
                                <label for="{{$carprice->number_key}}">Number of {{ucfirst(substr(str_replace("_", " ", $carprice->number_key), 7))}} Car Ad:</label>
                                <input class="form-control" type="text" name="{{$carprice->number_key}}" value="{{$carprice->number_value}}" required>
                            </div>
                            <div id="p{{$carprice->duration_key}}" class="form-group">
                                <label for="{{$carprice->duration_key}}">Duration for {{ucfirst(substr(str_replace("_", " ", $carprice->duration_key), 9))}} Car Ad:</label>
                                <input class="form-control" type="text" name="{{$carprice->duration_key}}" value="{{$carprice->duration_value}}" required>
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
                    <textarea id="reference" name="reference" class="form-control">{{$car->references}}</textarea>
                </div>
        </div>
        {{csrf_field()}}
		
		<button type="button" class="action back btn btn-info">Back</button>
		<button type="button" class="action next btn btn-info">Next</button>
		<button type="submit" class="action submit btn btn-success">Add Car</button>	
  	</form>
   
   </div>
@endsection

@section('scripts')
<script>
    var uncheckDeleteURL = "{{route('dashboard.deleteUncheckPriceCar')}}";
</script>
<script src={{URL::to('js/multistep-form.js')}}></script>
@endsection