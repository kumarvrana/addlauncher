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

<section class="sec-banner">
     <div class="jumbotron jumbo-1 text-center">
         <h1><span>{{ucwords(str_replace('_', ' ', $airportOption))}}</span> OPTIONS</h1>
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
						
						@if($airports)
							@foreach($airports as $airport)
								
								<div class="col-md-3 col-sm-3 "> 
									<div class="pro-item"> 
										<div class=" cat-opt-img "> <img src="{{asset('images/airports/'.$airport->airport->image)}}"> </div>
										<p class="font-1">{{$airport->airport->title}}</p>
										<p class="font-2">{{$airport->airport->location}} | {{$airport->airport->city}} 
										| {{$airport->airport->state}}</p>
										<hr>
										<div class="row">
											<div class="col-md-6">
												<p class="font-3">{{$airport->number_value}} {{ucwords(str_replace('_', ' ', $airportOption))}}<br> for <br> {{$airport->duration_value}} months</p>
											</div>
											<div class="col-md-6">
												<p class="font-4"><del class="lighter">Rs {{$airport->price_value}} <br></del>Rs {{$airport->price_value}} </p>
											</div>
										</div>
										
										@PHP
											$options = $airport->price_value.'+'.$airport->price_key;
											$session_key = 'airports'.'_'.$airport->price_key.'_'.$airport->airport->id;
											$printsession = (array) Session::get('cart');														
										@ENDPHP
										<div class="clearfix"> 
											<a class="glass" href="{{route('airport.addtocart', ['id' => $airport->airport->id, 'variation' => $options])}}">
											
										 @if(count($printsession) > 0)
											 @if(array_key_exists($session_key, $printsession['items'])) 
												<span class="fa fa-minus-circle"></span> Remove From Cart 
											 @else
												<span class="fa fa-star"></span> Add to Cart 
											 @endif
										 @else
											<span class="fa fa-star"></span> Add to Cart
										 @endif
											
										</a> 
										</div>
									</div>
								</div>
							@endforeach
						@endif
							
		            </div><!-- row before style ends here -->


        		</div><!-- col-md-8 ends here -->
        		<div class="col-md-2">
            @include('partials.sidebar-cart')
   					
        			
        		</div>
    		</div>
    	</div><!-- container fluid 1 ends here -->
           
</section>	
       

@endsection