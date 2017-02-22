@extends('layouts.master')

@section('title')

    Auto | Add Launcher

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
                   $variations = unserialize($autoad->display_options);
				   
				   $variation = array();
                   $price = array();
				   $passVariation = array();
                  foreach($autoprice as $options){
					$passVariation[] = $options->price_key;
					$variation[] = ucwords(str_replace('_', ' ', substr($options->price_key, 6)));
					$price[] = $options->price_value;
				  }
                $i = 0;
                @ENDPHP
                <div class="col-md-9">
					<div id="app">
							<h1>test</h1>
						<example></example>
					</div>
					<div class="row">

		     			@foreach($variations as $loop)
			 		
						<div class="col-md-4">
						 	<div class="page-cat-opt">
						 		<div class="cat-opt-img">
						 			
						 		</div>
						 		<div class="row">
						 			<div class="col-md-12">
						 				<h2>{{$variation[$i]}}</h2>
						 			</div>
						 			<div class="col-md-6 cat-inner1">
						 				<div class="cat-opt-inner1">
						 					<h3>Card rate</h3>
						 					<del><h3><span class="fa fa-inr"></span> {{$price[$i]}}</h3></del>
						 				</div>
						 			</div>
						 			<div class="col-md-6">
						 				<div class="cat-opt-inner2">
						 					<h3>Best rate</h3>
						 					<h3><span class="fa fa-inr"></span> {{$price[$i]}}</h3>
						 				</div>
						 			</div>
						 			@PHP
									 	$options = $price[$i].'+'.$passVariation[$i];
										$session_key = 'autos'.'_'.$passVariation[$i].'_'.$autoad->id;
										$printsession = (array) Session::get('cart');
										
									@ENDPHP
							
						 			<div class="col-md-12">
						 				<div class="cat-opt-cart">
						 					<a href="{{route('auto.addtocart', ['id' => $autoad->id, 'variation' => $options])}}"><h3><span class="fa fa-star"></span>
											 @if(count($printsession) > 0)
											 	@if(array_key_exists($session_key, $printsession['items'])) 
												 Remove From Shortlist 
												@else
												  Add to Shortlist 
												@endif
												@else
													Add to Shortlist
											@endif
											</h3></a>
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