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
                        <option value="{{$key}}" @PHP if($cinema->status == $value){
                            echo "Selected";
                        } @ENDPHP>{{$value}}</option>
                        @endforeach
                    
                    </select>
                </div>

        </div>
		<div class="step">
            <div class="step-header">Cinemas Ad Options</div>
            <input type="hidden" name="modelname" id="modelname" value="Cinema">
               @PHP
                   $bsdisplayData = unserialize($cinema->display_options);
                   $ad_displayData = unserialize($cinema->additional_adsoption);
               @ENDPHP
                <div class="panel panel-primary">
                    <div class="panel-heading "><h3 class="panel-title">Cinema Options</h3></div>
                    <div class="panel-body">
                         <div class="form-group">
                            <label for="status">Cinema Category:</label>
                            <select class="form-control" name="cinemacategory" id="cinemacategory" required="required">
                                <option value="">--Select--</option>
                                @foreach( $cinema_category as $key => $value )
                                <option value="{{$key}}" @PHP if($cinema->cinemacategory == $key){
                                echo "Selected";
                            } @ENDPHP>{{$value}}</option>
                                @endforeach                        
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="cinemadisplay">Cinema Ads: </label>
                            
                        @foreach($cinema_options as $key => $value)
                            <label class='checkbox-inline'><input data-label='Cinemas Ad Display Options' onclick="addDomToPriceOptionsCinema('{{$value}}', 'display_options')" name='cinemadisplay[]' type='checkbox'  @PHP if($bsdisplayData){ if( in_array($key, $bsdisplayData)){echo "checked"; } } @ENDPHP value="{{$key}}">{{$value}}</label>
                        @endforeach
                                        
                        </div>
                        <div class="form-group">
                            <label for="status">Other Ad Options In Cinema Halls:</label>
                            @foreach( $additionlsAds as $key => $value )
                            <label class='checkbox-inline'>
                            <input data-label='additionalsAds' onclick="addDomToPriceOptionsCinema('{{$value}}', 'additional_adsoption')" name='additionalsAds[]' type='checkbox' @PHP if($ad_displayData){ if( in_array($key, $ad_displayData)){echo "checked"; } } @ENDPHP value={{$key}}>{{$value}}
                            </label>
                         @endforeach 
                        </div>
                        <div class="form-group">
                            <label for="audiseats">Numbers Of Seats in Audi? : </label>
                            <input class="form-control" type="text" name="audiseats" value="{{$cinema->audiseats}}" required>
                        </div>
                        <div class="form-group">
                            <label for="audinumber">Numbers Of Audi Display this Ad? : </label>
                            <input class="form-control" type="text" name="audinumber" value="{{$cinema->audinumber}}" required>
                        </div>
                        <div class="form-group">
                            <label for="cinemasnumber">Numbers Of Cinemas Display this Ad? : </label>
                            <input class="form-control" type="text" name="cinemasnumber" value="{{$cinema->cinemanumber}}" required>
                        </div>
                        <div class="form-group">
                            <label for="cinemadiscount">Discount (%): </label>
                            <input class="form-control" type="text" name="cinemadiscount" value="{{$cinema->discount}}" placeholder="put an integer value for discount like 5 or 10">
                        </div>
                    </div>
                     
                </div>
               
                
                <div class="step-header">Pricing Options</div>
                    <div id="light-content" class="alert alert-info">
                                You have check the Light Options in ads. So, Please fill the Price including light charges in different the Ad display Size!
                        </div>
                    <div id="pricing-options-step">
                        <input type="hidden" name="modelname" id="modelname" value="Cinema">
                        <input type="hidden" id="priceData" value="{{json_encode(unserialize($fieldData))}}">
                        <input type="hidden" id="display_options" value="{{json_encode(unserialize($generalOptions))}}">
                        <input type="hidden" id="additional_adsoption" value="{{json_encode(unserialize($additionalOptions))}}">
                        <input type="hidden" id="uncheckID" value="{{$cinema->id}}">
                        <input type="hidden" id="tablename" value="cinemas">

                        @foreach($cinema->cinemasprice as $cinemaprice)
                            <div id="p{{$cinemaprice->price_key}}" class="form-group">
                                    <label for="{{$cinemaprice->price_key}}">Price for {{ucfirst(substr(str_replace("_", " ", $cinemaprice->price_key), 6))}} Cinema Ad:</label>
                                    <input class="form-control" type="text" name="{{$cinemaprice->price_key}}" value="{{$cinemaprice->price_value}}" required>
                                </div>
                                <div id="p{{$cinemaprice->duration_key}}" class="form-group">
                                    <label for="{{$cinemaprice->duration_key}}">Ad duration/period for {{ucfirst(substr(str_replace("_", " ", $cinemaprice->duration_key), 9))}} Cinema Ad:</label>
                                    <input class="form-control" type="text" name="{{$cinemaprice->duration_key}}" value="{{$cinemaprice->duration_value}}" required>
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
                <input type="email" id="reference_mail" name="reference_mail" value="{{$cinema->reference_mail}}" class="form-control" required>
            </div>
            <div class="form-group">
                    <label for="reference">Other Reference:</label>
                    <textarea id="reference" name="reference" class="form-control">{{$cinema->references}}</textarea>
                </div>
        </div>
        {{csrf_field()}}
		
		<button type="button" class="action back btn btn-info">Back</button>
		<button type="button" class="action next btn btn-info">Next</button>
		<button type="submit" class="action submit btn btn-success">Edit Cinema</button>	
  	</form>
   
   </div>
@endsection

@section('scripts')
<script>
    var uncheckDeleteURL = "{{route('dashboard.deleteUncheckPriceCinema')}}";
</script>
<script src={{URL::to('js/multistep-form.js')}}></script>
@endsection