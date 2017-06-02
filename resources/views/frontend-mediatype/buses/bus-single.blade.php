@extends('layouts.master')

@section('title')

    Bus | Add Launcher

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
         <h1> OPTIONS</h1>
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
				
				@foreach($buspricesad as $busprice)

				
					<div class="col-lg-3 col-md-4 col-sm-6 col-xs-12"> 
						<div class="pro-item"> 
							<div class=" cat-opt-img"><img src="{{asset('images/buses/'.$busprice->bus->image)}}"> </div>
							<p class="font-1">{{$busprice->bus->title}}</p>
							<p class="font-2">{{$busprice->bus->location}} | {{$busprice->bus->city}} | {{$busprice->bus->state}}</p>
							<hr>
							<div class="row">
								<div class="col-md-6">
									<p class="font-3">{{$busprice->number_value}} {{ucwords(str_replace('_', ' ', substr($busprice->price_key, 6)))}} Ads<br> for  <br> {{$busprice->duration_value}} months</p>
								</div>
							<div class="col-md-6">	
								<p class="font-2"><del class="lighter">Rs {{$busprice->price_value}} <br></del>Rs {{$busprice->price_value}}</p>
							</div>
							</div>
							@PHP
							$options = $busprice->price_value.'+'.$busprice->price_key;
							$session_key = 'buses'.'_'.$busprice->price_key.'_'.$busprice->bus->id;
							$printsession = (array) Session::get('cart');
											
							@ENDPHP
							<div class="clearfix"> 
								<a class="glass" href="{{route('bus.addtocart', ['id' => $busprice->bus->id, 'variation' => $options])}}">
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