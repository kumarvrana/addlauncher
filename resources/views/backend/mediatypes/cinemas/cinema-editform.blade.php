@extends('backend.layouts.backend-master')

@section('title')
   Edit Cinema | Ad Launcher
@endsection

@section('content')
    <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
          <h1 class="page-header">Cinema Edit Form</h1>
   
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
  <form class="form" action="{{route('dashboard.editcinemasad', ['ID' => $cinema->id])}}" method="post" enctype="multipart/form-data">
		<div class="step">
            <div class="step-header">General Options</div>
            <div class="form-group">
                    <label for="title">Ad Name:</label>
                    <input type="text" id="title" name="title" class="form-control" placeholder="Name of the product" value="{{$cinema->title}}" required>
                </div>
                <div class="form-group">
                    <label for="price">Ad Price:</label>
                    <input type="text" id="price" name="price" class="form-control" value="{{$cinema->price}}" placeholder="Put Base price here eg: 1213" required>
                </div>
                <div class="form-group">
                    <label for="location">Location:</label>
                    <input type="text" id="location" name="location" placeholder="example: saket metro/ IGI Cinema" value="{{$cinema->location}}" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="city">City:</label>
                    <input type="text" id="city" name="city" placeholder="example: Mumbai" value="{{$cinema->city}}" class="form-control" required>
                </div>

                <div class="form-group">
                    <label for="ad-state">State:</label>
                    <input type="text" id="state" name="state" placeholder="example: Maharashtra" value="{{$cinema->state}}" class="form-control" required>
                </div>
                             
                <div class="form-group">
                    <label for="rank">City Rank:</label>
                    <input type="text" id="rank" name="rank" placeholder="example: (432) rank according to location" value="{{$cinema->rank}}" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="landmark">Landmark:</label>
                    <input type="text" id="landmark" name="landmark" placeholder="example: near children park or opposite to city post office" value="{{$cinema->landmark}}" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="description">Description:</label>
                    <textarea id="description" name="description" class="form-control">{{$cinema->description}}</textarea>
                </div>
                
                
                @PHP
                    $ad_status = array( 1 => 'Available', 2 => 'Sold Out', 3 => 'Coming Soon');
                @ENDPHP
                <div class="form-group">
                    <label for="status">Ad Status:</label>
                    <select class="form-control" name="status" id="status" required="required">
                        <option value="">--Select--</option>
                        @foreach( $ad_status as $key => $value )
                        <option value="{{$key}}" @PHP if($cinema->status == $key){
                            echo "Selected";
                        } @ENDPHP>{{$value}}</option>
                        @endforeach
                    
                    </select>
                </div>

        </div>
		<div class="step">
            <div class="step-header">Cinemas Ad Options</div>
               @PHP
                    $cinema_options = array('ten_sec_mute_slide' => '10 sec Mute Slide', 'ten_sec_audio_slide' => '10 sec Audio Slide', 'thirty_sec_video' => '30 Sec Video', 'sixty_sec_video' => '60 Sec Video');
                     $bsdisplayData = unserialize($cinema->display_options);
                @ENDPHP
                <div class="panel panel-primary">
                    <div class="panel-heading "><h3 class="panel-title">Cinema Options</h3></div><div class="panel-body">
                    <div class="form-group">
                        <label for="cinemadisplay">Cinemas Ad Display Options: </label>
                          
                    @foreach($cinema_options as $key => $value)
                        <label class='checkbox-inline'><input data-label='Cinemas Ad Display Options' onclick="addDomToPriceOptions('{{$value}}')" name='cinemadisplay[]' type='checkbox'  @PHP if(in_array($key, $bsdisplayData)){echo "checked"; } @ENDPHP value="{{$key}}">{{$value}}</label>
                    @endforeach
                                       
                    </div>
                    <div class="form-group">
                        <label for="cinemasnumber">Numbers Of Cinemas Display this Ad? : </label>
                        <input class="form-control" type="text" name="cinemasnumber" value="{{$cinema->cinemanumber}}" required></div>
                    </div>
                </div>

                <div class="step-header">Pricing Options</div>
                    <div id="light-content" class="alert alert-info">
                                You have check the Light Options in ads. So, Please fill the Price including light charges in different the Ad display Size!
                        </div>
                    <div id="pricing-options-step">
                        <input type="hidden" id="priceData" value="{{json_encode(unserialize($fieldData))}}">
                        <input type="hidden" id="uncheckID" value="{{$cinema->id}}">
                        <input type="hidden" id="tablename" value="cinemas">
                         @foreach($cinemapricemeta as $cinemaprice)
                         @PHP $p_key = str_replace("_", " ", $cinemaprice->price_key);
                             $label =  ucfirst(substr($p_key, 6));
                         @ENDPHP
                        <div id="p{{$cinemaprice->price_key}}" class="form-group">
                            <label for="{{$cinemaprice->price_key}}">Price for {{$label}} Cinema Ad:</label>
                            <input class="form-control" type="text" name="{{$cinemaprice->price_key}}" value="{{$cinemaprice->price_value}}" required>
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
                    <textarea id="reference" name="reference" class="form-control">{{$cinema->references}}</textarea>
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