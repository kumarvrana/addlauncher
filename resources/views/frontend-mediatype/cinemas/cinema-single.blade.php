@extends('layouts.master')

@section('title')

    Cinema | Add Launcher

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
                   $variations = unserialize($cinemaad->display_options);
				   
				   $variation = array();
                   $price = array();
				   $passVariation = array();
                  foreach($cinemaprice as $options){
					$passVariation[] = $options->price_key;
					$variation[] = ucwords(str_replace('_', ' ', substr($options->price_key, 6)));
					$price[] = $options->price_value;
				  }
				  $name_key = array_chunk($passVariation, 2);
				  $price_values = array_chunk($price, 2);
				  
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
					$duration[] = $options[1];
					
				 }
				  
                $i = 0;
                @ENDPHP
                <div class="col-md-9">
					<div class="display-title">
					  <h2>Display Options</h2>
				   	</div>
					<div class="row">

		     		@foreach($variations as $loop)
		     			<style type="text/css">
		     			.{{strtolower(str_replace(' ','_', $name[$i]))}}{
						background-image: url('../../images/display/cinema/{{strtolower(str_replace(' ','_', $name[$i]))}}.png');
							} </style>
		     			<div class="col-md-3 col-sm-3 "> 
			     			<div class="pro-item"> 
				     			<div class=" cat-opt-img {{strtolower(str_replace(' ','_', $name[$i]))}}"> </div>
							    <p class="font-1">{{$name[$i]}}</p>
							    <p class="font-3"> Duration {{$duration[$i]}} Sec</p>
							    <p class="font-2"><del class="lighter">Rs {{$new_price[$i]}}</del>Rs {{getDiscuntedValue( $new_price[$i], $cinemaad->discount )}}</p>
							      @PHP
								$options = $new_price[$i].'+'.$passVariationname[$i];
								$session_key = 'cinemas'.'_'.$passVariationname[$i].'_'.$cinemaad->id;
								$printsession = (array) Session::get('cart');
												
								@ENDPHP
							    <div class="clearfix"> 
							    	<a class="glass" href="{{route('cinema.addtocart', ['id' => $cinemaad->id, 'variation' => $options])}}"><span class="fa fa-star"></span>
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


        		</div><!-- col-md-9 ends here -->
    		</div>
    	</div><!-- container fluid 1 ends here -->
           
	
       

@endsection