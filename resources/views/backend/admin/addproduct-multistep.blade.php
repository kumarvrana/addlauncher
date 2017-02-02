@extends('backend.layouts.backend-master')

@section('title')
   Product Form
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
  <form class="form" action="{{route('dashboard.postproductform')}}" method="post" enctype="multipart/form-data">
		<div class="step">
            <div class="step-header">General Options</div>
            <div class="form-group">
                    <label for="title">Ad Name:</label>
                    <input type="text" id="title" name="title" class="form-control" value="{{old('title')}}" required>
                </div>
                <div class="form-group">
                    <label for="price">Ad Price:</label>
                    <input type="text" id="price" name="price" class="form-control" value="{{old('price')}}" placeholder="Put Base price here" required>
                </div>
                <div class="form-group">
                    <label for="location">Location:</label>
                    <input type="text" id="location" name="location" value="{{old('location')}}" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="ad-state">State:</label>
                    <input type="text" id="state" name="state" value="{{old('state')}}" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="city">City:</label>
                    <input type="text" id="city" name="city" value="{{old('city')}}" class="form-control" required>
                </div>
                
                                
                <div class="form-group">
                    <label for="rank">City Rank:</label>
                    <input type="text" id="rank" name="rank" value="{{old('rank')}}" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="landmark">Landmark:</label>
                    <input type="text" id="landmark" name="landmark" value="{{old('landmark')}}" class="form-control" required>
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
            <div class="step-header">Ad Media Type Options</div>
                <div class="form-group">
                    <label for="sel1">Select Media Type:</label>
                    <select class="form-control" name="mediatype_id" id="mediatype" required="required">
                        <option value="">--Select--</option>
                        @foreach( $categories as $category)
                        <option data-name="{{$category->slug}}" value="{{$category->id}}">{{$category->title}}</option>
                        @endforeach
                    
                    </select>
                </div>
                <div class="panel panel-primary results">
                    
                </div>

        </div>
		<div class="step">
            <div class="step-header">Pricing Options</div>
            <div id="pricing-options-step">
                <div id="light-content" class="form-group">
                </div>
            </div>
        
        </div>
        <div class="step">
            <div class="step-header">Image and References Options</div>
            <div class="form-group">
                <label for="imagepath ">Ad Image:</label>
                <input type="file" id="imagepath" name="imagepath" class="form-control" required>
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
<script>
    var CathtmlUrl = "{{route('dashboard.getproductvariationshtmlbycat')}}";
         

  $(document).ready(function(){
	var current = 1;
	
	widget      = $(".step");
	btnnext     = $(".next");
	btnback     = $(".back"); 
	btnsubmit   = $(".submit");

	// Init buttons and UI
	widget.not(':eq(0)').hide();
	hideButtons(current);
	setProgress(current);

	// Next button click action
	btnnext.click(function(){
		if(current < widget.length){
			// Check validation
			if($(".form").valid()){
				widget.show();
				widget.not(':eq('+(current++)+')').hide();
				setProgress(current);
			}
		}
		hideButtons(current);
	})

	// Back button click action
	btnback.click(function(){
		if(current > 1){
			current = current - 2;
			if(current < widget.length){
				widget.show();
				widget.not(':eq('+(current++)+')').hide();
				setProgress(current);
			}
		}
		hideButtons(current);
	})

	// Submit button click
	/*btnsubmit.click(function(){
		alert("Submit button clicked");
	});*/

    $('.form').validate({ // initialize plugin
		ignore:":not(:visible)",			
		rules: {
			name : "required"
		},
    });

});

// Change progress bar action
setProgress = function(currstep){
	var percent = parseFloat(100 / widget.length) * currstep;
	percent = percent.toFixed();
	$(".progress-bar").css("width",percent+"%").html(percent+"%");		
}

// Hide buttons according to the current step
hideButtons = function(current){
	var limit = parseInt(widget.length); 

	$(".action").hide();

	if(current < limit) btnnext.show();
	if(current > 1) btnback.show();
	if (current == limit) { 
		btnnext.hide(); 
		btnsubmit.show();
	}
}
</script>
@endsection