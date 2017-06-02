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
		@if($generalCinemaads)
		@foreach($generalCinemaads as  $cinemaad)
		@if($loop->iteration==1)
		<h1>{{ $cinemaad->cinema->title }}</h1>
		@break;
		@endif
		@endforeach
		@endif
	</div>
</section>         
<section class="main-sec">        

	<div class="container-fluid"> <!-- container fluid 1 starts here -->
		<div class="row">
			<div class="col-md-2">
                  @include('partials.sidebar-cart')
			</div>
			
			<div class="col-md-8">
				@if($generalCinemaads)


				<section class="sec-head-sub-title">
					@if($generalCinemaads)
					@foreach($generalCinemaads as  $cinemaad)
					@if($loop->iteration==1)
					<h1><span><i class="fa fa-map-marker"></i>&nbsp;&nbsp;{{$cinemaad->cinema->location}} , {{$cinemaad->cinema->city}}</span></h1>
					@break;
					@endif
					@endforeach
					@endif
				</section>

				<div class="ad-sec">  
					
						<h2 class="inner-head">General Options</h2>
						<div class="inner-box">
							<div class="row" > 
								@foreach($generalCinemaads as $cinemaad)

								<div class="col-lg-3 col-md-4 col-sm-6 col-xs-12"> 
									<div class="pro-item"> 
										<div class="ribbon"><span class="{{$cinemaad->cinema->cinemacategory}}">{{$cinemaad->cinema->cinemacategory}}</span></div>
										<div class=" cat-opt-img"><img src="{{asset('images/cinemas/'.$cinemaad->cinema->image)}}"> </div>
										<p class="font-1">{{ucwords(str_replace('_', ' ', substr($cinemaad->price_key, 6)))}}</p>
										<hr class="hr_1">
										<div class="row">

											@PHP $discount_price = $cinemaad->price_value - ($cinemaad->price_value * ($cinemaad->cinema->discount/100)); @endphp

											<div class="col-md-12">
												@if(substr($cinemaad->price_key, 6)=='mute_slide_ad')
												<p class="font-3">Per Month Rates For 10 Sec</p>
												@else
												<p class="font-3">Per Week Rates For 10 Sec</p>
												@endif
											</div>
											<div class="col-md-12">	
												<p class="font-price"><del class="lighter">Rs {{$cinemaad->price_value}} </del>Rs {{$discount_price}}</p>
											</div>
										</div>
										@PHP
										$options = $cinemaad->price_value.'+'.$cinemaad->price_key;
										$session_key = 'cinemas'.'_'.$cinemaad->price_key.'_'.$cinemaad->cinema->id;
										$printsession = (array) Session::get('cart');
										
										@ENDPHP
										<div class="clearfix"> 
											<a class="glass" href="{{route('cinema.addtocart', ['id' => $cinemaad->cinema->id, 'variation' => $options])}}">
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
							</div>
						</div><!-- row before style ends here -->
						@endif



						@if($additionalCinemaads)
						<h2 class="inner-head">Additional Options</h2>
						<div class="inner-box">
							<div class="row" > 
							@foreach($additionalCinemaads as $cinemaad)

							<div class="col-lg-3 col-md-4 col-sm-6 col-xs-12"> 

								<div class="pro-item"> 
									<div class=" cat-opt-img"><img src="{{asset('images/cinemas/'.$cinemaad->cinema->image)}}"> </div>
									<p class="font-1">{{ucwords(str_replace('_', ' ', substr($cinemaad->price_key, 6)))}}</p>
									<hr class="hr_1">
									<div class="row">
										<div class="col-md-12">
											<p class="font-3">Price&nbsp;{{$cinemaad->duration_value}}</p>
										</div>
										<div class="col-md-12">	
											<p class="font-price"><del class="lighter">Rs {{$cinemaad->price_value}} </del>Rs {{$cinemaad->price_value}}</p>

										</div>
									</div>
									@PHP
									$options = $cinemaad->price_value.'+'.$cinemaad->price_key;
									$session_key = 'cinemas'.'_'.$cinemaad->price_key.'_'.$cinemaad->cinema->id;
									$printsession = (array) Session::get('cart');
									
									@ENDPHP
									<div class="clearfix"> 
										<a class="glass" href="{{route('cinema.addtocart', ['id' => $cinemaad->cinema->id, 'variation' => $options])}}">
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
							</div>
						</div><!-- row before style ends here -->
						@endif

					
				</div>



				<section class="sec-head-sub-title">
					@if($generalCinemaads)
					@foreach($generalCinemaads as  $cinemaad)
					@if($loop->iteration==1)
					<h1><span><i class="fa  fa-bookmark "></i>&nbsp;&nbsp;About {{$cinemaad->cinema->title}}</span></h1>
					@break;
					@endif
					@endforeach
					@endif
				</section>

				<div class="single_cat_info">
					<div class="row">
						<div class="col-md-12">
							@if($generalCinemaads)
							@foreach($generalCinemaads as  $cinemaad)
							@if($loop->iteration==1)
							<p>{!! $cinemaad->cinema->description !!}</p>
							@break;
							@endif
							@endforeach
							@endif
						</div>
					</div>
				</div>

			</div>
			<div class="col-md-2">
				@include('partials.sidebar-cart')
			</div>
		</div>
	</div><!-- container fluid 1 ends here -->

	
</section>      

@endsection