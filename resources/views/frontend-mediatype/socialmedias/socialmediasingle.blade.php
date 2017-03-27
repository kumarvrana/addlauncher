@extends('layouts.master')

@section('title')

    Social Media | Add Launcher

@endsection

@section('content')
        @if(Session::has('success'))
        <div class="row">
            <div class="col-sm-6 col-md-4 col-md-offset-4 col-sm-offset-3">
                <div id="charge-message" class="alert alert-success">
                    {{Session::get('success')}}
                </div>
            </div>
        </div>
        @endif
        <div class="container-fluid"> <!-- container fluid 1 starts here -->
            <div class="row">
                <div class="col-md-3">
				@include('partials.sidebar')
                    
                </div>
                @PHP
                   $variations = unserialize($socialmediaad->display_options);
				   
				   $variation = array();
                   $price = array();
				   $passVariation = array();
                  foreach($socialmediaprice as $options){
					$passVariation[] = $options->price_key;
					$variation[] = ucwords(str_replace('_', ' ', substr($options->price_key, 6)));
					$price[] = $options->price_value;
				  }
				  $name_key = array_chunk($passVariation, 3);
				  $price_values = array_chunk($price, 3);
				  
				  $name = array();
				  $j = 0; 
				  foreach($name_key as $options){
					  	$passVariationname[$j] = $options[0];
						$name[$j] = ucwords(str_replace('_', ' ', substr($options[0], 6)));
					$j++;
				  }
				 
				 $new_price = array();
				 $number = array();
				 $duration = array();
				 foreach($price_values as $options){
					$new_price[] = $options[0];
					$number[] = $options[1];
					$duration[] = $options[2];
				 }
				  
                $i = 0;
                @ENDPHP
                <div class="col-md-9">
					<div class="display-title">
					  <h2>Display Options</h2>
				   	</div>
					<div class="row">

		     			@foreach($variations as $loop)
			 		
						<div class="col-xs-6 col-sm-4 col-md-4 col-lg-3">
			 	<div class="page-cat-opt">
			 		<div class="cat-opt-img img-bus-full"></div>
			 		<div class="row">
			 			<div class="col-md-12">
				 			<div class="corner">
				 				<h4>{{$name[$i]}}</h4>
				 				<h5>40 Bus for 3 months</h5>
				 			</div>
			 			</div>
			 		</div>
			 		<div class="cat-opt-inner1" >
			 			<div class="row">
				 			<div class="col-md-8">
				 				<h5>Card rate <small><span class="fa fa-circle pull-right" style="color: #fff"></span></small></h5>
				 			</div>
				 			
				 			<div class="col-md-4">
				 				<del><h5><span class="fa fa-inr"></span> {{$new_price[$i]}}</h5></del>
				 			</div>
			 			</div>			
			 		</div>
			 		<div class="cat-opt-inner2" >
			 			<div class="row">
				 			<div class="col-md-8">
				 				<h5>Best rate <small><span class="fa fa-circle pull-right" style="color: #40beee"></span></small></h5>
				 			</div>
				 			<div class="col-md-4">
				 				<h5 class="bestrate"><span class="fa fa-inr"></span> {{$new_price[$i]}}</h5>
				 			</div>
			 			</div>			
			 		</div>

			 		@PHP
						$options = $new_price[$i].'+'.$passVariationname[$i];
						$session_key = 'socialmedias'.'_'.$passVariationname[$i].'_'.$socialmediaad->id;
						$printsession = (array) Session::get('cart');
										
					@ENDPHP

			 		<div class="row">
			 			<div class="col-md-12">
			 				<div class="cat-opt-cart">
			 					<a href="{{route('socialmedia.addtocart', ['id' => $socialmediaad->id, 'variation' => $options])}}"><h5><span class="fa fa-star"></span> 
			 						@if(count($printsession) > 0)
											 	@if(array_key_exists($session_key, $printsession['items'])) 
												 Remove From Shortlist 
												@else
												  Add to Shortlist 
												@endif
												@else
													Add to Shortlist
											@endif
			 					</h5></a>
			 				</div>
			 			</div>	
			 		</div>
			 	</div>
			</div>
					
					 @PHP
					 	$i++;
					 @ENDPHP
					 @endforeach
		            </div>
        		</div>
    		</div>
    	</div><!-- container fluid 1 ends here -->
           
	
       

@endsection