@extends('layouts.master')

@section('title')

    Newspaper | Add Launcher

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
                   $variations = unserialize($newspaperad->general_options);
				   $variation = array();
                   $price = array();
				   $passVariation = array();
					foreach($generaloptions as $options){
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
					  <h2>General Options</h2>
				   	</div>
				<div class="row">

			     		@foreach($variations as $loop)
			     			<style type="text/css">
			     			.{{strtolower(str_replace(' ','_', $name[$i]))}}{
							background-image: url('../../images/display/newspaper/{{strtolower(str_replace(' ','_', $name[$i]))}}.png');
								} </style>
			     			<div class="col-lg-3 col-md-4 col-sm-6 col-xs-12"> 
				     			<div class="pro-item"> 
					     			<div class=" cat-opt-img {{strtolower(str_replace(' ','_', $name[$i]))}}"> </div>
								    <p class="font-1">{{$name[$i]}}</p>
								    <p class="font-3">{{$number[$i]}} Newspaper for {{$duration[$i]}} months</p>
								    <p class="font-2"><del class="lighter">Rs {{$new_price[$i]}}</del>Rs {{$new_price[$i]}}</p>
								      @PHP
									$options = $new_price[$i].'+'.$passVariationname[$i];
									$session_key = 'newspapers'.'_'.$passVariationname[$i].'_'.$newspaperad->id;
									$printsession = (array) Session::get('cart');
													
									@ENDPHP
								    <div class="clearfix"> 
								    	<a class="glass" href="{{route('newspaper.addtocart', ['id' => $newspaperad->id, 'variation' => $options])}}"><span class="fa fa-star"></span>
									      	@if(count($printsession) > 0)
											@if(array_key_exists($session_key, $printsession['items'])) 
												Remove From Cart 
											@else
												Add to Cart 
											@endif
											@else
												Add to Cart
											@endif
								      </a> 
								    </div>
							    </div>
						    </div>
							@PHP $i++; @ENDPHP
						@endforeach
		            </div><!-- row before style ends here -->
        		
					<div class="display-title">
					  <h2>Other Options</h2>
				   	</div>
					<div class="row">
				@PHP
					$variations1 = unserialize($newspaperad->other_options);
					$variation = array();
					$price = array();
					$passVariation = array();
					foreach($otheroptions as $options){
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
		     	@foreach($variations1 as $loop)
			 	
			 	<style type="text/css">
			     				.{{strtolower(str_replace(' ','_', $name[$i]))}}{
									background-image: url('../../images/display/newspaper/{{strtolower(str_replace(' ','_', $name[$i]))}}.png');
								} 
				</style>
			     			<div class="col-lg-3 col-md-4 col-sm-6 col-xs-12"> 
				     			<div class="pro-item"> 
					     			<div class=" cat-opt-img {{strtolower(str_replace(' ','_', $name[$i]))}}"> </div>
								    <p class="font-1">{{$name[$i]}}</p>
								    <p class="font-3">{{$number[$i]}} Newspaper for {{$duration[$i]}} months</p>
								    <p class="font-2"><del class="lighter">Rs {{$new_price[$i]}}</del>Rs {{$new_price[$i]}}</p>
								      @PHP
									$options = $new_price[$i].'+'.$passVariationname[$i];
									$session_key = 'newspapers'.'_'.$passVariationname[$i].'_'.$newspaperad->id;
									$printsession = (array) Session::get('cart');
													
									@ENDPHP
								    <div class="clearfix"> 
								    	<a class="glass" href="{{route('newspaper.addtocart', ['id' => $newspaperad->id, 'variation' => $options])}}"><span class="fa fa-star"></span>
									      	@if(count($printsession) > 0)
											@if(array_key_exists($session_key, $printsession['items'])) 
												Remove From Cart 
											@else
												Add to Cart 
											@endif
											@else
												Add to Cart
											@endif
								      </a> 
								    </div>
							    </div>
						    </div>
					
					 @PHP
					 	$i++;
					 @ENDPHP
					 @endforeach
		            </div>
        		
					<div class="display-title">
					  <h2>Classified Options</h2>
				   	</div>
					<div class="row">
				@PHP
					$variations2 = unserialize($newspaperad->classified_options);
					$variation = array();
					$price = array();
					$passVariation = array();
					foreach($classified as $options){
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
		     	@foreach($variations2 as $loop)
			 		
				<style type="text/css">
			     				.{{strtolower(str_replace(' ','_', $name[$i]))}}{
									background-image: url('../../images/display/newspaper/{{strtolower(str_replace(' ','_', $name[$i]))}}.png');
								} 
				</style>
			     			<div class="col-lg-3 col-md-4 col-sm-6 col-xs-12"> 
				     			<div class="pro-item"> 
					     			<div class=" cat-opt-img {{strtolower(str_replace(' ','_', $name[$i]))}}"> </div>
								    <p class="font-1">{{$name[$i]}}</p>
								    <p class="font-3">{{$number[$i]}} Newspaper for {{$duration[$i]}} months</p>
								    <p class="font-2"><del class="lighter">Rs {{$new_price[$i]}}</del>Rs {{$new_price[$i]}}</p>
								      @PHP
									$options = $new_price[$i].'+'.$passVariationname[$i];
									$session_key = 'newspapers'.'_'.$passVariationname[$i].'_'.$newspaperad->id;
									$printsession = (array) Session::get('cart');
													
									@ENDPHP
								    <div class="clearfix"> 
								    	<a class="glass" href="{{route('newspaper.addtocart', ['id' => $newspaperad->id, 'variation' => $options])}}"><span class="fa fa-star"></span>
									      	@if(count($printsession) > 0)
											@if(array_key_exists($session_key, $printsession['items'])) 
												Remove From Cart 
											@else
												Add to Cart 
											@endif
											@else
												Add to Cart
											@endif
								      </a> 
								    </div>
							    </div>
						    </div>
					
					 @PHP
					 	$i++;
					 @ENDPHP
					 @endforeach
		            </div>
        		
					<div class="display-title">
					  <h2>Pricing Options</h2>
				   	</div>
					<div class="row">
				@PHP
					$variations3 = unserialize($newspaperad->pricing_options);
					$variation = array();
					$price = array();
					$passVariation = array();
					foreach($pricingoption as $options){
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
		     	@foreach($variations3 as $loop)
			 		
				<style type="text/css">
			     				.{{strtolower(str_replace(' ','_', $name[$i]))}}{
									background-image: url('../../images/display/newspaper/{{strtolower(str_replace(' ','_', $name[$i]))}}.png');
								} 
				</style>
			     			<div class="col-lg-3 col-md-4 col-sm-6 col-xs-12"> 
				     			<div class="pro-item"> 
					     			<div class=" cat-opt-img {{strtolower(str_replace(' ','_', $name[$i]))}}"> </div>
								    <p class="font-1">{{$name[$i]}}</p>
								    <p class="font-3">{{$number[$i]}} Newspaper for {{$duration[$i]}} months</p>
								    <p class="font-2"><del class="lighter">Rs {{$new_price[$i]}}</del>Rs {{$new_price[$i]}}</p>
								      @PHP
									$options = $new_price[$i].'+'.$passVariationname[$i];
									$session_key = 'newspapers'.'_'.$passVariationname[$i].'_'.$newspaperad->id;
									$printsession = (array) Session::get('cart');
													
									@ENDPHP
								    <div class="clearfix"> 
								    	<a class="glass" href="{{route('newspaper.addtocart', ['id' => $newspaperad->id, 'variation' => $options])}}"><span class="fa fa-star"></span>
									      	@if(count($printsession) > 0)
											@if(array_key_exists($session_key, $printsession['items'])) 
												Remove From Cart 
											@else
												Add to Cart 
											@endif
											@else
												Add to Cart
											@endif
								      </a> 
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