@extends('layouts.master')

@section('title')

    Busstop | Add Launcher

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
			@if($busstopads)
				@foreach($busstopads as $busstopad)
				<div class="col-md-3 col-sm-3 "> 
					<div class="pro-item"> 
						<div class=" cat-opt-img"><img src="{{asset('images/busstops/'.$busstopad->busstop->image)}}"> </div>
						<p class="font-1">{{$busstopad->busstop->title}}</p>
						<p class="font-2">{{$busstopad->busstop->location}} | {{$busstopad->busstop->city}} | {{$busstopad->busstop->state}}</p>
						<hr>
						<div class="row">
							<div class="col-md-6">
								<p class="font-3">{{$busstopad->number_value}} {{ucwords(str_replace('_', ' ', substr($busstopad->price_key, 6)))}} Ads for {{$busstopad->duration_value}} months</p>
							</div>
						<div class="col-md-6">	
							<p class="font-2"><del class="lighter">Rs {{$busstopad->price_value}} <br></del>Rs {{$busstopad->price_value}}</p>
						</div>
						</div>
						@PHP
						$options = $busstopad->price_value.'+'.$busstopad->price_key;
						$session_key = 'busstops'.'_'.$busstopad->price_key.'_'.$busstopad->busstop->id;
						$printsession = (array) Session::get('cart');
									
						@ENDPHP
						<div class="clearfix"> 
							<a class="glass" href="{{route('busstop.addtocart', ['id' => $busstopad->busstop->id, 'variation' => $options])}}">
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
				{{$busstopad->busstopsprice}}
				@endforeach	
			@endif
			</div><!-- row before style ends here -->
			</div>
			<div class="col-md-2">
			@include('partials.sidebar-cart')
			</div>
		</div>
	</div><!-- container fluid 1 ends here -->
           
	
 </section>      

@endsection