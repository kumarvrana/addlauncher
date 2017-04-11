@extends('layouts.master')

@section('title')

    Airport | Add Launcher

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
                
                <div class="col-md-9">
					<div class="display-title">
					  <h2>{{ucwords(str_replace('_', ' ', $airportOption))}} Options</h2>
				   	</div>
					<div class="row">
						@if($airports)
							@foreach($airports as $product)
								<div class="col-md-3 col-sm-3 "> 
									<div class="pro-item"> 
										<div class=" cat-opt-img "> <img src="{{asset('images/airports/'.$product[11])}}"> </div>
										<p class="font-1">{{$product[3]}}</p>
										<p class="font-2">{{$product[5]}} | {{$product[6]}} | {{$product[7]}}</p>
										<p class="font-3">{{$product[21]}} {{ucwords(str_replace('_', ' ', $airportOption))}} for {{$product[23]}} months</p>
										<p class="font-2"><del class="lighter">Rs {{$product[19]}} </del>Rs {{$product[19]}} </p>
										 @PHP
										$options = $product[19].'+'.$product[18];
										$session_key = 'airports'.'_'.$product[18].'_'.$product[0];
										$printsession = (array) Session::get('cart');
														
									@ENDPHP
										<div class="clearfix"> 
											<a class="glass" href="{{route('airport.addtocart', ['id' => $product[0], 'variation' => $options])}}"><span class="fa fa-star"></span>
											
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
							@endforeach
						@endif
							
		            </div><!-- row before style ends here -->


        		</div><!-- col-md-9 ends here -->
    		</div>
    	</div><!-- container fluid 1 ends here -->
           
	
       

@endsection