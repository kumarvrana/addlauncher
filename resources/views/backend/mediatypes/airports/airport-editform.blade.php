    @extends('backend.layouts.backend-master')

    @section('title')
    Edit Airport | Ad Launcher
    @endsection

    @section('content')
    <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
    <h1 class="page-header">Airport Edit Form</h1>

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

    <form class="form" action="{{route('dashboard.Postairportsad', ['ID' => $airport->id])}}" method="post" enctype="multipart/form-data">

    <div class="step">
        <div class="step-header">General Options</div>
        <div class="form-group">
            <label for="title">Ad Name:</label>
            <input type="text" id="title" name="title" class="form-control" placeholder="Name of the product" value="{{$airport->title}}" required>
        </div>
        <div class="form-group">
            <label for="price">Ad Price:</label>
            <input type="text" id="price" name="price" class="form-control" value="{{$airport->price}}" placeholder="Put Base price here eg: 1213" required>
        </div>
        <div class="form-group">
            <label for="location">Location:</label>
            <input type="text" id="location" name="location" placeholder="example: saket metro/ IGI Airport" value="{{$airport->location}}" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="city">City:</label>
            <input type="text" id="city" name="city" placeholder="example: Mumbai" value="{{$airport->city}}" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="ad-state">State:</label>
            <input type="text" id="state" name="state" placeholder="example: Maharashtra" value="{{$airport->state}}" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="rank">City Rank:</label>
            <input type="text" id="rank" name="rank" placeholder="example: (432) rank according to location" value="{{$airport->rank}}" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="landmark">Landmark:</label>
            <input type="text" id="landmark" name="landmark" placeholder="example: near children park or opposite to city post office" value="{{$airport->landmark}}" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="description">Description:</label>
            <textarea id="description" name="description" class="form-control">{{$airport->description}}</textarea>
        </div>


        @PHP
        $ad_status = array( 1 => 'Available', 2 => 'Sold Out', 3 => 'Coming Soon');
        @ENDPHP
        <div class="form-group">
            <label for="status">Ad Status:</label>
            <select class="form-control" name="status" id="status" required="required">
                <option value="">--Select--</option>
                @foreach( $ad_status as $key => $value )
                <option value="{{$key}}" @PHP if($airport->status == $value){
                    echo "Selected";
                } @ENDPHP>{{$value}}</option>
                @endforeach

            </select>
        </div>

    </div>


    <div class="step">
        <div class="step-header">Airport Ad Display Options</div>
        <input type="hidden" name="modelname" id="modelname" value="Airport">
        <div class="panel panel-primary">
            <div class="panel-heading "><h3 class="panel-title">Airport Options</h3>
            </div>
            <div class="panel-body">

                <p><a href="#" data-index="1" class="btn btn-primary copy" rel=".full-html">Add Main Option +</a></p>
                <?php $cot = 1; ?>
                @foreach($airport->airportsprice as $airportprice)
                @PHP
                $increment = ($cot !== 1) ? $cot : '';
                @ENDPHP
                <div class="full-html" id="room_fileds{{$increment}}">

                    <div class="form-group" >
                        <label>Select Location</label>
                        <select required data-index="{{$cot}}" id="location{{$increment}}" class="form-control" name="airport_location{{$increment}}" class="location">

                            <option value="">Select Location</option>
                            @foreach($airport_locations as $key => $value)

                            <option value="{{$key}}" @PHP if($airportprice->area == $key){
                                echo "Selected";
                            } @ENDPHP>{{$value}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Select Category</label>
                        <select required data-index="{{$cot}}" id="displayoptions{{$increment}}" name="airport_category{{$increment}}" class="form-control displayoption">
                            <option value="">Select Category</option>
                            @foreach($airport_options as $key => $value)
                            <option value="{{$key}}" @PHP if($airportprice->displayoption == $key){
                                echo "Selected";
                            } @ENDPHP>{{$value}}</option>
                            @endforeach

                        </select>
                    </div> 

                    <div class="form-group">
                        <label for="dimensions"> Dimensions: </label>
                        <input type="text" name="airport_dimensions{{$increment}}" placeholder="Dimensions" class="form-control"
                        value="{{$airportprice->dimensions}}" required>
                    </div>
                    <div class="form-group">
                        <label for="price"> Price: </label>
                        <input type="text" name="airport_price{{$increment}}" placeholder="Price" value="{{$airportprice->optionprice}}" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="units"> Units: </label>
                        <input type="text" name="airport_units{{$increment}}" placeholder="Units" value="{{$airportprice->units}}" class="form-control" required>
                    </div>
                <div class="    "><a class="btn btn-danger airport-romoveoption" data-id="{{$airportprice->id}}" onclick="deleteairportOption('{{$airportprice->id}}', '{{$increment}}')">Remove Sub-Field </a></div>
                
                <hr>
                </div>

                
                <?php $cot++; ?>
                @endforeach
                <!-- replicate field ends here-->
                <div class="form-group">
                    <label for="airportdiscount">Discount (%): </label>
                    <input class="form-control" type="text" name="airportdiscount" value="{{$airport->discount}}" placeholder="put an integer value for discount like 5 or 10">
                </div>
            </div>
        </div>

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
            <input type="file" id="image" name="image" class="form-control"/>
        </div>
        <div class="form-group">
            <label for="reference_mail">Reference mail:</label>
            <input type="email" id="reference_mail" name="reference_mail" value="{{$airport->reference_mail}}" class="form-control"/>
        </div>
        <div class="form-group">
            <label for="reference">Other Reference:</label>
            <textarea id="reference" name="reference" class="form-control">{{$airport->reference}}</textarea>
        </div>
    </div>
    {{csrf_field()}}

    <button type="button" class="action back btn btn-info">Back</button>
    <button type="button" class="action next btn btn-info">Next</button>
    <button type="submit" class="action submit btn btn-success">Add Airport</button>    
    </form>

    </div>
    @endsection

    @section('scripts')
    <script src={{URL::to('js/multistep-form.js')}}></script>
    <script>
    var airportFieldRemoveURL = "{{ route('dashboard.deleteUncheckPriceAirport')}}";
    </script>
    @endsection