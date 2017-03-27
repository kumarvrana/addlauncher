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
					foreach($auto_display as $options){
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
				
					
		<div class="row">
		@if($variations)
						<div class="display-title">
					  <h2>Display Options</h2>
				   	</div>
			     		@foreach($variations as $loop)
			     			<style type="text/css">
			     			.{{strtolower(str_replace(' ','_', $name[$i]))}}{
							background-image: url('../../images/display/auto/{{strtolower(str_replace(' ','_', $name[$i]))}}.png');
								} </style>
			     			<div class="col-md-3 col-sm-3 "> 
				     			<div class="pro-item"> 
					     			<div class=" cat-opt-img {{strtolower(str_replace(' ','_', $name[$i]))}}"> </div>
								    <p class="font-1">{{$name[$i]}}</p>
								    <p class="font-3">{{$number[$i]}} Airport for {{$duration[$i]}} months</p>
								    <p class="font-2"><del class="lighter">Rs {{$new_price[$i]}}</del>Rs {{$new_price[$i]}}</p>
								      @PHP
									$options = $new_price[$i].'+'.$passVariationname[$i];
									$session_key = 'autos'.'_'.$passVariationname[$i].'_'.$autoad->id;
									$printsession = (array) Session::get('cart');
													
									@ENDPHP
								    <div class="clearfix"> 
								    	<a class="glass" href="{{route('auto.addtocart', ['id' => $autoad->id, 'variation' => $options])}}"><span class="fa fa-star"></span>
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
					@endif
		            </div><!-- row before style ends here -->


        			
					
					<div class="row">
				@PHP
					$variations1 = unserialize($autoad->front_pamphlets_reactanguler_options);
					$variation = array();
					$price = array();
					$passVariation = array();
					foreach($auto_frontprdisplay as $options){
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
				@if($variations1)
				<div class="display-title">
					  <h2>Auto Front Pamphlets/Reactanguler Options:</h2>
				   	</div>
		     	@foreach($variations1 as $loop)
			 		
				<style type="text/css">
			     				.{{strtolower(str_replace(' ','_', $name[$i]))}}{
									background-image: url('../../images/display/auto/{{strtolower(str_replace(' ','_', $name[$i]))}}.png');
								} 
							</style>
			     			<div class="col-md-3 col-sm-3 "> 
				     			<div class="pro-item"> 
					     			<div class=" cat-opt-img {{strtolower(str_replace(' ','_', $name[$i]))}}"> </div>
								    <p class="font-1">{{$name[$i]}}</p>
								    <p class="font-3">{{$number[$i]}} Auto for {{$duration[$i]}} months</p>
								    <p class="font-2"><del class="lighter">Rs {{$new_price[$i]}}</del>Rs {{$new_price[$i]}}</p>
								      @PHP
									$options = $new_price[$i].'+'.$passVariationname[$i];
									$session_key = 'autos'.'_'.$passVariationname[$i].'_'.$autoad->id;
									$printsession = (array) Session::get('cart');
													
									@ENDPHP
								    <div class="clearfix"> 
								    	<a class="glass" href="{{route('auto.addtocart', ['id' => $autoad->id, 'variation' => $options])}}"><span class="fa fa-star"></span>
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
					@endif
		            </div>
        		
        		
					
					<div class="row">
				@PHP
					$variations2 = unserialize($autoad->front_stickers_options);
					$variation = array();
					$price = array();
					$passVariation = array();
					foreach($auto_stickerdisplay as $options){
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
				@if($variations2)
				<div class="display-title">
					  <h2>Auto Front Stickers Options:</h2>
				</div>
		     	@foreach($variations2 as $loop)
			 		
				<style type="text/css">
			     				.{{strtolower(str_replace(' ','_', $name[$i]))}}{
									background-image: url('../../images/display/auto/{{strtolower(str_replace(' ','_', $name[$i]))}}.png');
								} 
							</style>
			     			<div class="col-md-3 col-sm-3 "> 
				     			<div class="pro-item"> 
					     			<div class=" cat-opt-img {{strtolower(str_replace(' ','_', $name[$i]))}}"> </div>
								    <p class="font-1">{{$name[$i]}}</p>
								    <p class="font-3">{{$number[$i]}} Airport for {{$duration[$i]}} months</p>
								    <p class="font-2"><del class="lighter">Rs {{$new_price[$i]}}</del>Rs {{$new_price[$i]}}</p>
								      @PHP
									$options = $new_price[$i].'+'.$passVariationname[$i];
									$session_key = 'autos'.'_'.$passVariationname[$i].'_'.$autoad->id;
									$printsession = (array) Session::get('cart');
													
									@ENDPHP
								    <div class="clearfix"> 
								    	<a class="glass" href="{{route('auto.addtocart', ['id' => $autoad->id, 'variation' => $options])}}"><span class="fa fa-star"></span>
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
					 @endif
		            </div>
        			
					<div class="row">
				@PHP
					$variations3 = unserialize($autoad->hood_options);
					$variation = array();
					$price = array();
					$passVariation = array();
					foreach($auto_hooddisplay as $options){
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
				@if($variations3)
				<div class="display-title">
					  <h2>Auto Hood Options:</h2>
					</div>
					
		     	@foreach($variations3 as $loop)
			 		
				<style type="text/css">
			     				.{{strtolower(str_replace(' ','_', $name[$i]))}}{
									background-image: url('../../images/display/auto/{{strtolower(str_replace(' ','_', $name[$i]))}}.png');
								} 
							</style>
			     			<div class="col-md-3 col-sm-3 "> 
				     			<div class="pro-item"> 
					     			<div class=" cat-opt-img {{strtolower(str_replace(' ','_', $name[$i]))}}"> </div>
								    <p class="font-1">{{$name[$i]}}</p>
								    <p class="font-3">{{$number[$i]}} Airport for {{$duration[$i]}} months</p>
								    <p class="font-2"><del class="lighter">Rs {{$new_price[$i]}}</del>Rs {{$new_price[$i]}}</p>
								      @PHP
									$options = $new_price[$i].'+'.$passVariationname[$i];
									$session_key = 'autos'.'_'.$passVariationname[$i].'_'.$autoad->id;
									$printsession = (array) Session::get('cart');
													
									@ENDPHP
								    <div class="clearfix"> 
								    	<a class="glass" href="{{route('auto.addtocart', ['id' => $autoad->id, 'variation' => $options])}}"><span class="fa fa-star"></span>
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
					 @endif
		            </div>

		            
		            
					<div class="row">
				@PHP
					$variations4 = unserialize($autoad->interior_options);
					$variation = array();
					$price = array();
					$passVariation = array();
					foreach($auto_interiordisplay as $options){
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
				@if($variations4)
				<div class="display-title">
					  <h2>Auto Interior Options:</h2>
					</div>
		     	@foreach($variations4 as $loop)
			 		
				<style type="text/css">
			     				.{{strtolower(str_replace(' ','_', $name[$i]))}}{
									background-image: url('../../images/display/auto/{{strtolower(str_replace(' ','_', $name[$i]))}}.png');
								} 
							</style>
			     			<div class="col-md-3 col-sm-3 "> 
				     			<div class="pro-item"> 
					     			<div class=" cat-opt-img {{strtolower(str_replace(' ','_', $name[$i]))}}"> </div>
								    <p class="font-1">{{$name[$i]}}</p>
								    <p class="font-3">{{$number[$i]}} Airport for {{$duration[$i]}} months</p>
								    <p class="font-2"><del class="lighter">Rs {{$new_price[$i]}}</del>Rs {{$new_price[$i]}}</p>
								      @PHP
									$options = $new_price[$i].'+'.$passVariationname[$i];
									$session_key = 'autos'.'_'.$passVariationname[$i].'_'.$autoad->id;
									$printsession = (array) Session::get('cart');
													
									@ENDPHP
								    <div class="clearfix"> 
								    	<a class="glass" href="{{route('auto.addtocart', ['id' => $autoad->id, 'variation' => $options])}}"><span class="fa fa-star"></span>
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
					 @endif
		            </div>


        		</div>
    		</div>
    	</div><!-- container fluid 1 ends here -->
           
	
       

@endsection