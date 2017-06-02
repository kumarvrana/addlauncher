@extends('backend.layouts.backend-master')

@section('title')
   Edit Television | Ad Launcher
@endsection

@section('content')
    <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
          <h1 class="page-header">Television Edit Form</h1>
   
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
  <form class="form" action="{{route('dashboard.Posttelevisionsad', ['ID' => $television->id])}}" method="post" enctype="multipart/form-data">
		<div class="step">
            <div class="step-header">General Options</div>
            <div class="form-group">
                    <label for="title">Ad Name:</label>
                    <input type="text" id="title" name="title" class="form-control" placeholder="Name of the product" value="{{$television->title}}" required>
                </div>
                <div class="form-group">
                    <label for="price">Ad Price:</label>
                    <input type="text" id="price" name="price" class="form-control" value="{{$television->price}}" placeholder="Put Base price here eg: 1213" required>
                </div>
                <div class="form-group">
                    <label for="location">Location:</label>
                    <input type="text" id="location" name="location" placeholder="example: saket metro/ IGI Television" value="{{$television->location}}" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="city">City:</label>
                    <input type="text" id="city" name="city" placeholder="example: Mumbai" value="{{$television->city}}" class="form-control" required>
                </div>

                <div class="form-group">
                    <label for="ad-state">State:</label>
                    <input type="text" id="state" name="state" placeholder="example: Maharashtra" value="{{$television->state}}" class="form-control" required>
                </div>
                             
                <div class="form-group">
                    <label for="rank">City Rank:</label>
                    <input type="text" id="rank" name="rank" placeholder="example: (432) rank according to location" value="{{$television->rank}}" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="landmark">Landmark:</label>
                    <input type="text" id="landmark" name="landmark" placeholder="example: near children park or opposite to city post office" value="{{$television->landmark}}" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="description">Description:</label>
                    <textarea id="description" name="description" class="form-control">{{$television->description}}</textarea>
                </div>
                
                
                @PHP
                    $ad_status = array( 1 => 'Available', 2 => 'Sold Out', 3 => 'Coming Soon');
                @ENDPHP
                <div class="form-group">
                    <label for="status">Ad Status:</label>
                    <select class="form-control" name="status" id="status" required="required">
                        <option value="">--Select--</option>
                        @foreach( $ad_status as $key => $value )
                        <option value="{{$key}}" @PHP if($television->status == $key){
                            echo "Selected";
                        } @ENDPHP>{{$value}}</option>
                        @endforeach
                    
                    </select>
                </div>

        </div>
		<div class="step">

               
                
            <div class="step-header">Television Display Options</div>
                <input type="hidden" name="modelname" id="modelname" value="Television">
                @PHP
                        $ad_genre = array( 'Entertainment' => 'Entertainment', 'News' => 'News', 'Sports' => 'Sports' , 'Devotional' => 'Devotional', 'Kids' => 'Kids', 'Educational' => 'Educational', 'Food_and_drink' => 'Food and drink', 'Travel' => 'Travel');

                        $newsoptions = array('ticker' => 'Ticker', 'aston' => 'Aston', 'fct' => 'Fct' ,'time_check' => 'Time Check');

                        $newsdisplayData = unserialize($television->news_options);
                                     
                 @ENDPHP
                <div class="panel panel-primary">
                    <div class="panel-heading "><h3 class="panel-title">Television Options</h3></div><div class="panel-body">
                    <div class="form-group">
                         <label for="newstype">Genre:</label>
                            <select class="form-control" name="genre" id="genre" required="required">
                                <option value="">--Select--</option>
                                @foreach( $ad_genre as $key => $value )
                                <option value="{{$key}}" @PHP if($television->genre == $key){
                            echo "Selected";
                        } @ENDPHP>{{$value}}</option>
                                @endforeach
                            
                            </select>
                                
                    </div> 
                    <div class="form-group newsoptions">
                        <label for="newsdisplay">News Ad Display Options: </label>
                             
                    @foreach($newsoptions as $key => $value)
                        <label class='checkbox-inline'><input data-label='News Ad Display Options' onclick="addDomToPriceOptionsTelevision('{{$value}}', 'news_options')" name='newsdisplay[]' type='checkbox' @PHP if($newsdisplayData){ if(in_array($key, $newsdisplayData)){echo "checked"; } } @ENDPHP value={{$key}}>{{$value}}</label>
                    @endforeach
                                       
                    </div>
                

                   <div class="form-group">
                        <label for="busesnumber">Numbers Of Channel Display this Ad? : </label>
                        <input class="form-control" type="text" name="televisionnumber" value="{{$television->television_number}}" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="busesnumber">Discount (%): </label>
                        <input class="form-control" type="text" name="discount"  value="{{$television->discount}}">
                    </div>
                    </div>
                </div>

                <div class="step-header">Pricing Options</div>
                    
                     <div id="pricing-options-step">
                        <input type="hidden" id="priceData" value="{{json_encode(unserialize($fieldData))}}">
                        <input type="hidden" id="display_options" value="{{json_encode(unserialize($television->display_options))}}">
                        <input type="hidden" id="ticker_options" value="{{json_encode(unserialize($television->ticker_options))}}">
                        <input type="hidden" id="aston_options" value="{{json_encode(unserialize($television->aston_options))}}">
                        <input type="hidden" id="fct_options" value="{{json_encode(unserialize($television->fct_options))}}">
                        <input type="hidden" id="time_check_options" value="{{json_encode(unserialize($television->time_check_options))}}">
                        <input type="hidden" id="uncheckID" value="{{$television->id}}">
                        <input type="hidden" id="tablename" value="televisions">
                        
                        
                         @foreach($televisionpricemeta as $televisionprice)
                         
                            <div id="p{{$televisionprice->rate_key}}" class="form-group">
                                <label for="{{$televisionprice->rate_key}}">Rate for {{ucfirst(substr(str_replace("_", " ", $televisionprice->rate_key), 10))}} Ad  Per unit:</label>
                                <input class="form-control" type="text" name="{{$televisionprice->rate_key}}" value="{{$televisionprice->rate_value}}" required>
                            </div>
                            <div id="p{{$televisionprice->time_band_key}}" class="form-group">
                                <label for="{{$televisionprice->time_band_key}}">Time band of {{ucfirst(substr(str_replace("_", " ", $televisionprice->time_band_key), 5))}} Ad:</label>
                                <input class="form-control" type="text" name="{{$televisionprice->time_band_key}}" value="{{$televisionprice->time_band_value}}" required>
                            </div>
                            <div id="p{{$televisionprice->exposure_key}}" class="form-group">
                                <label for="{{$televisionprice->exposure_key}}">Exposure for {{ucfirst(substr(str_replace("_", " ", $televisionprice->exposure_key), 9))}} Ad:</label>
                                <input class="form-control" type="text" name="{{$televisionprice->exposure_key}}" value="{{$televisionprice->exposure_value}}" required>
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
                <input type="email" id="reference_mail" name="reference_mail" value="{{$television->reference_mail}}" class="form-control" required>
            </div>
            <div class="form-group">
                    <label for="reference">Other Reference:</label>
                    <textarea id="reference" name="reference" class="form-control">{{$television->references}}</textarea>
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
    var uncheckDeleteURL = "{{route('dashboard.deleteUncheckPriceTelevision')}}";
</script>
<script src={{URL::to('js/multistep-form.js')}}></script>
@endsection