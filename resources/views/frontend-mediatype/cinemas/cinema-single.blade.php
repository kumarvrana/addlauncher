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
<section class="sec-banner">
     <div class="jumbotron jumbo-1 text-center">
         <h1><span>OPTIONS</span></h1>
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
						
						@foreach($cinemas as $cinema)

						
						<div class="col-md-3 col-sm-3 "> 
							<div class="pro-item"> 
								<div class=" cat-opt-img"><img src="{{asset('images/cinemas/'.$cinema->cinema->image)}}"> 
								</div>
								

								<p class="font-1-title">{{$cinema->cinema->title}}</p>
								<p class="font-1">{{ucwords(str_replace('_', ' ', substr($cinema->price_key, 6)))}}</p>
								
								<p class="font-2">{{$cinema->cinema->location}} | {{$cinema->cinema->city}} | {{$cinema->cinema->state}}</p>
								<hr>
								<div class="row">
									<div class="col-md-6">
									@if(substr($cinema->price_key, 6)=='mute_slide_ad')
										<p class="font-3">Per Month Rates <br> For <br>10 Sec</p>
									@else
										<p class="font-3">Per Week Rates <br> For <br>10 Sec</p>
									@endif
									</div>
									<div class="col-md-6">
									<p class="font-2"><del class="lighter">Rs {{$cinema->price_value}}<br></del> 
									Rs{{$cinema->price_value}}</p>
									</div>
									</div>

								@PHP
								$options = $cinema->price_value.'+'.$cinema->price_key;
								$session_key = 'cinemas'.'_'.$cinema->price_key.'_'.$cinema->cinema->id;
								$printsession = (array) Session::get('cart');
												
								@ENDPHP
								<div class="clearfix"> 
									<a class="glass" href="{{route('cinema.addtocart', ['id' => $cinema->cinema->id, 'variation' => $options])}}">
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
						
		            </div><!-- row before style ends here -->
        		</div>
        		<div class="col-md-2">
            @include('partials.sidebar-cart')
                
            </div>
        		
    		</div>
    	</div><!-- container fluid 1 ends here -->
           
	
       
</section>
@endsection