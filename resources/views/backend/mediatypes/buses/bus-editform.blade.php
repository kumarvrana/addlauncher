@extends('backend.layouts.backend-master')

@section('title')
   Edit Bus | Ad Launcher
@endsection

@section('content')
    <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
          <h1 class="page-header">Bus Edit Form</h1>
   
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
  <form class="form" action="{{route('dashboard.Postbusesad', ['ID' => $bus->id])}}" method="post" enctype="multipart/form-data">
		<div class="step">
            <div class="step-header">General Options</div>
            <div class="form-group">
                    <label for="title">Ad Name:</label>
                    <input type="text" id="title" name="title" class="form-control" placeholder="Name of the product" value="{{$bus->title}}" required>
                </div>
                <div class="form-group">
                    <label for="price">Ad Price:</label>
                    <input type="text" id="price" name="price" class="form-control" value="{{$bus->price}}" placeholder="Put Base price here eg: 1213" required>
                </div>
                <div class="form-group">
                    <label for="location">Location:</label>
                    <input type="text" id="location" name="location" placeholder="example: saket metro/ IGI Bus" value="{{$bus->location}}" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="city">City:</label>
                    <input type="text" id="city" name="city" placeholder="example: Mumbai" value="{{$bus->city}}" class="form-control" required>
                </div>

                <div class="form-group">
                    <label for="ad-state">State:</label>
                    <input type="text" id="state" name="state" placeholder="example: Maharashtra" value="{{$bus->state}}" class="form-control" required>
                </div>
                             
                <div class="form-group">
                    <label for="rank">City Rank:</label>
                    <input type="text" id="rank" name="rank" placeholder="example: (432) rank according to location" value="{{$bus->rank}}" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="landmark">Landmark:</label>
                    <input type="text" id="landmark" name="landmark" placeholder="example: near children park or opposite to city post office" value="{{$bus->landmark}}" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="description">Description:</label>
                    <textarea id="description" name="description" class="form-control">{{$bus->description}}</textarea>
                </div>
                
                
                @PHP
                    $ad_status = array( 1 => 'Available', 2 => 'Sold Out', 3 => 'Coming Soon');
                @ENDPHP
                <div class="form-group">
                    <label for="status">Ad Status:</label>
                    <select class="form-control" name="status" id="status" required="required">
                        <option value="">--Select--</option>
                        @foreach( $ad_status as $key => $value )
                        <option value="{{$key}}" @PHP if($bus->status == $value){
                            echo "Selected";
                        } @ENDPHP>{{$value}}</option>
                        @endforeach
                    
                    </select>
                </div>

        </div>
		<div class="step">
            <div class="step-header">Buses Ad Options</div>
            <input type="hidden" name="modelname" id="modelname" value="Bus">
               @PHP
                    $bus_options = array('full' => 'Full', 'both_side' => 'Both Side', 'left_side' => 'Left Side', 'right_side' => 'Right Side', 'back_side' => 'Back Side', 'back_glass' => 'Back Glass', 'internal_ceiling' => 'Internal Ceiling', 'bus_grab_handles' => 'Bus Grab Handles', 'inside_billboards' => 'Inside Billboards');
                     $bsdisplayData = unserialize($bus->display_options);
                @ENDPHP
                <div class="panel panel-primary">
                    <div class="panel-heading "><h3 class="panel-title">Bus Options</h3></div><div class="panel-body">
                    <div class="form-group">
                        <label for="bsdbusdisplayisplay">Buses Ad Display Options: </label>
                          
                    @foreach($bus_options as $key => $value)
                        <label class='checkbox-inline'><input data-label='Buses Ad Display Options' onclick="addDomToPriceOptions('{{$value}}')" name='busdisplay[]' type='checkbox'  @PHP if(in_array($key, $bsdisplayData)){echo "checked"; } @ENDPHP value="{{$key}}">{{$value}}</label>
                    @endforeach
                                       
                    </div>
                    <div class="form-group">
                        <label for="busesnumber">Numbers Of Buses Display this Ad? : </label>
                        <input class="form-control" type="text" name="busesnumber" value="{{$bus->busnumber}}" required>
                    </div>
                    <div class="form-group">
                        <label for="busesnumber">Discount (%): </label>
                        <input class="form-control" type="text" name="busdiscount" value="{{$bus->discount}}" placeholder="put an integer value for discount like 5 or 10">
                    </div>
                    </div>
                </div>

                <div class="step-header">Pricing Options</div>
                    <div id="light-content" class="alert alert-info">
                                You have check the Light Options in ads. So, Please fill the Price including light charges in different the Ad display Size!
                        </div>
                    <div id="pricing-options-step">
                         <input type="hidden" name="modelname" id="modelname" value="Bus">
                        <input type="hidden" id="priceData" value="{{json_encode(unserialize($fieldData))}}">
                        <input type="hidden" id="uncheckID" value="{{$bus->id}}">
                        <input type="hidden" id="tablename" value="buses">

                        @foreach($buspricemeta as $busprice)
                          <div id="p{{$busprice->price_key}}" class="form-group">
                                <label for="{{$busprice->price_key}}">Price for {{ucfirst(substr(str_replace("_", " ", $busprice->price_key), 6))}} Bus Ad:</label>
                                <input class="form-control" type="text" name="{{$busprice->price_key}}" value="{{$busprice->price_value}}" required>
                            </div>
                            <div id="p{{$busprice->number_key}}" class="form-group">
                                <label for="{{$busprice->number_key}}">Number of {{ucfirst(substr(str_replace("_", " ", $busprice->number_key), 7))}} Bus Ad:</label>
                                <input class="form-control" type="text" name="{{$busprice->number_key}}" value="{{$busprice->number_value}}" required>
                            </div>
                            <div id="p{{$busprice->duration_key}}" class="form-group">
                                <label for="{{$busprice->duration_key}}">Duration for {{ucfirst(substr(str_replace("_", " ", $busprice->duration_key), 9))}} Bus Ad:</label>
                                <input class="form-control" type="text" name="{{$busprice->duration_key}}" value="{{$busprice->duration_value}}" required>
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
                <input type="email" id="reference_mail" name="reference_mail" value="{{$bus->reference_mail}}" class="form-control" required>
            </div>
            <div class="form-group">
                    <label for="reference">Other Reference:</label>
                    <textarea id="reference" name="reference" class="form-control">{{$bus->references}}</textarea>
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
    var uncheckDeleteURL = "{{route('dashboard.deleteUncheckPriceBus')}}";
</script>
<script src={{URL::to('js/multistep-form.js')}}></script>
@endsection