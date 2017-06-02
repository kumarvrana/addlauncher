@extends('layouts.master')

@section('title')

    Television | Add Launcher

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
			@if($televisionads)
				@foreach($televisionads as $televisionad)
				<div class="col-lg-3 col-md-4 col-sm-6 col-xs-12"> 
					<div class="pro-item"> 
						<div class=" cat-opt-img"><img src="{{asset('images/televisions/'.$televisionad->television->image)}}"> </div>
						<p class="font-1">{{$televisionad->television->title}}</p>
						<p class="font-2">{{$televisionad->television->location}} | {{$televisionad->television->city}} | {{$televisionad->television->state}}</p>
						<hr>
						<div class="row">
							<div class="col-md-6">
								<p class="font-3">{{$televisionad->time_band_value}} {{ucwords(str_replace('_', ' ', substr($televisionad->rate_key, 5)))}} Ads<br> for <br> {{$televisionad->exposure_value}} months</p>
							</div>
						<div class="col-md-6">	
							<p class="font-2"><del class="lighter">Rs {{$televisionad->rate_value}} <br></del>Rs {{$televisionad->rate_value}}</p>
						</div>
						</div>
						@PHP
						$options = $televisionad->rate_value.'+'.$televisionad->rate_key;
						$session_key = 'televisions'.'_'.$televisionad->rate_key.'_'.$televisionad->television->id;
						$printsession = (array) Session::get('cart');
									
						@ENDPHP
						<div class="clearfix"> 
							<a class="glass" href="{{route('television.addtocart', ['id' => $televisionad->television->id, 'variation' => $options])}}">
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
				{{$televisionad->televisionsprice}}
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