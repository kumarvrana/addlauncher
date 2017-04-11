@extends('layouts.master')

@section('title')

    @PHP echo ucwords(str_replace('_', ' ', $carOption )) @ENDPHP| @PHP echo ucwords(str_replace('_', ' ', $cartype)) @ENDPHP| Car/Taxi | Add Launcher

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

<section class="sec-banner">
     <div class="jumbotron jumbo-1 text-center">
         <h1><span>{{ucwords(str_replace('_', ' ', $cartype))}} {{ucwords(str_replace('_', ' ', $carOption))}}</span> OPTIONS</h1>
     </div>
</section>       
<section class="main-sec">
        <div class="container-fluid"> <!-- container fluid 1 starts here -->
            <div class="row">
                <div class="col-md-2">
				@include('partials.sidebar')
                    
                </div>
               
                <div class="col-md-8">
				<div class="row">
				
					
			     		@if($products)
							@foreach($products as $product)
			     			<div class="col-md-3 col-sm-3 "> 
				     			<div class="pro-item"> 
					     			<div class=" cat-opt-img "><img src="{{asset('images/cars/'.$product[11])}}"> </div>
								    <p class="font-1">{{$product[3]}}</p>
									<p class="font-2">{{$product[5]}} | {{$product[6]}} <br> {{$product[7]}}</p>
								    
								    <p class="font-2"><del class="lighter">Rs {{$product[19]}} </del>Rs {{$product[19]}}</p>
								    @PHP
										$options = $product[19].'+'.$product[18];
										$session_key = 'cars'.'_'.$product[18].'_'.$product[0];
										$printsession = (array) Session::get('cart');
														
									@ENDPHP
								    <div class="clearfix"> 
								    	<a class="glass" href="{{route('car.addtocart', ['id' => $product[0], 'variation' => $options])}}"><span class="fa fa-star"></span>
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
						</div><!-- row ends here -->

        		</div><!-- col-md-8 ends here -->

        		  <div class="col-md-2">
            @include('partials.sidebar-cart')
                
            </div>
    		</div>
    	</div><!-- container fluid 1 ends here -->
           
	
       

@endsection