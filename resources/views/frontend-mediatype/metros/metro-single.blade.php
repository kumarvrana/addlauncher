@extends('layouts.master')

@section('title')

   Metro | Add Launcher

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
	
					@if($metros)
						@foreach($metros as $metro)
						<div class="col-lg-3 col-md-4 col-sm-6 col-xs-12"> 
							<div class="pro-item"> 
								<div class=" cat-opt-img "> <img src="{{asset('images/metros/'.$metro->metro->image)}}"> </div>
								<p class="font-1">{{$metro->metro->title}}</p>
								<p class="font-2">{{$metro->metro->location}} | {{$metro->metro->city}} | {{$metro->metro->state}}</p>
								<hr>
								<div class="row">
									<div class="col-md-6">
										<p class="font-3"> {{ucwords(str_replace('_', ' ',$metro->metro->metro_line))}} Ads<br> for <br> 1 months</p>
									</div>
									<div class="col-md-6">
										<p class="font-4"><del class="lighter">Rs {{$metro->totalprice}} <br></del>Rs {{$metro->totalprice}} </p>
									</div>
								</div>
								@PHP
								$session_key = 'metros'.'_'.$metro->id.'_'.$metro->metro->id;
								$printsession = (array)
								Session::get('cart');
								@ENDPHP
								
								<div class="clearfix"> 
									<a class="glass" href="{{route('metro.addtocart', ['id' => $metro->metro->id, 'variation' => $metro->id])}}">
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

        		</div>

        		<div class="col-md-2">
            		@include('partials.sidebar-cart')
        		</div>

    		</div>
    	</div><!-- container fluid 1 ends here -->
 </section>          
	
       

@endsection