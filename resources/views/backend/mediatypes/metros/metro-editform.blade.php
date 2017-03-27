@extends('backend.layouts.backend-master')

@section('title')
   Edit Metro | Ad Launcher
@endsection

@section('content')
    <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
          <h1 class="page-header">Metro Edit Form</h1>
   
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
  <form class="form" action="{{route('dashboard.Postmetrosad', ['ID' => $metro->id])}}" method="post" enctype="multipart/form-data">
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
                    <input type="text" id="location" name="location" placeholder="example: saket metro/ IGI Airport" value="{{$metro->location}}" class="form-control" required>
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
                    <textarea id="description" name="description" class="form-control">{{$metro->description}}</textarea>
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
            <div class="step-header">Metros Ad Options</div>
               @PHP
                    $metro_options = array('full' => 'Full', 'roof_front' => 'Roof Front', 'seat_backs' => 'Seat Backs', 'side_boards' => 'Side Boards');
                     $metrodisplayData = unserialize($metro->display_options);

                @ENDPHP
                <div class="panel panel-primary">
                    <div class="panel-heading "><h3 class="panel-title">Metro Options</h3></div><div class="panel-body">
                    <div class="form-group">
                        <label for="metrodisplay">Metros Ad Display Options: </label>
                          
                    @foreach($metro_options as $key => $value)
                        <label class='checkbox-inline'><input data-label='Metros Ad Display Options' onclick="addDomToPriceOptions('{{$value}}')" name='metrodisplay[]' type='checkbox'  @PHP if(in_array($key, $metrodisplayData)){echo "checked"; } @ENDPHP value="{{$key}}">{{$value}}</label>
                    @endforeach
                                       
                    </div>
                    <div class="form-group"><label for="bslighting">Do you want lighting options on Metro Panels?: </label><label class="checkbox-inline"><input class="checkEvent" data-label="Bus Shelter lighting options" onclick="addDomToPriceOptionsWithLight('No')" name="metrolighting" type="radio" @PHP if($metro->light_option == 0) echo "checked"; @ENDPHP value="0">No</label><label class="checkbox-inline"><input class="checkEvent" data-label="Bus Shelter lighting options" onclick="addDomToPriceOptionsWithLight('Yes')" name="metrolighting" type="radio" @PHP if($metro->light_option == 1) echo "checked"; @ENDPHP value="1">Yes</label></div>
                    
                    <div class="form-group">
                        <label for="metrodiscount">Discount (%): </label>
                        <input class="form-control" type="text" value="{{$metro->discount}}" name="metrodiscount" placeholder="put an integer value for discount like 5 or 10">
                    </div>
                    <div class="form-group">
                        <label for="metrosnumber">Numbers Of Metros Display this Ad? : </label>
                        <input class="form-control" type="text" name="metrosnumber" value="{{$metro->metronumber}}" required></div>
                    </div>
                </div>

                <div class="step-header">Pricing Options</div>
                    <div id="light-content" class="alert alert-info">
                                You have check the Light Options in ads. So, Please fill the Price including light charges in different the Ad display Size!
                        </div>
                    <div id="pricing-options-step">
                        <input type="hidden" id="priceData" value="{{json_encode(unserialize($fieldData))}}">
                        <input type="hidden" id="uncheckID" value="{{$metro->id}}">
                        <input type="hidden" id="tablename" value="metros">
                        @foreach($metropricemeta as $metroprice)
                         @PHP 
                             $p_key = str_replace("_", " ", $metroprice->price_key);
                             $field_name = explode(' ', $p_key);
                             
                             switch($field_name[0]){
                                case 'price';
                                    $label_field =  ucfirst(substr($p_key, 6));
                                    $label = "Price for $label_field Metro Ad:";
                                break;
                                case 'number';
                                    $label_field =  ucfirst(substr($p_key, 7));
                                    $label = "Number of $label_field Metro Ad:";
                                break;
                                case 'duration';
                                    $label_field =  ucfirst(substr($p_key, 9));
                                    $label = "Duration for $label_field Metro Ad:";
                                break;
                             }

                         @ENDPHP
                        <div id="p{{$metroprice->price_key}}" class="form-group">
                            <label for="{{$metroprice->price_key}}">{{$label}}</label>
                            <input class="form-control" type="text" name="{{$metroprice->price_key}}" value="{{$metroprice->price_value}}" required>
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
    var uncheckDeleteURL = "{{route('dashboard.deleteUncheckPrice', ['table' => 'Metro'])}}";
</script>
<script src={{URL::to('js/multistep-form.js')}}></script>
@endsection