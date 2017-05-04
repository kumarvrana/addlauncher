@extends('layouts.master')

@section('title')

    Auto | Add Launcher

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
         <h1><span>{{ucwords(str_replace('_', ' ', $autoOption))}}</span> OPTIONS</h1>
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
				
					@if($autos)
					@if($autoOption == 'tricycle')
						@foreach($autos as $auto)
						<div class="col-md-3 col-sm-3 "> 
							<div class="pro-item"> 
								<div class=" cat-opt-img "> <img src="{{asset('images/autos/'.$auto->image)}}"> </div>
								<p class="font-1">{{$auto->title}}</p>
								<p class="font-2">{{$auto->location}} | {{$auto->city}} | {{$auto->state}}</p>
								<hr>
								<div class="row">
									<div class="col-md-6">
										<p class="font-3">{{$auto->auto_number}} {{ucwords(str_replace('_', ' ', $autoOption))}}<br> for <br> 1 month</p>
									</div>
									<div class="col-md-6">
										<p class="font-4"><del class="lighter">Rs {{$auto->price}} <br></del>Rs {{$auto->price}} </p>
									</div>
								</div>
								@PHP
									$options = $auto->price.'+tricycle';
									$session_key = 'autos'.'_tricycle_'.$auto->id;
									$printsession = (array) Session::get('cart');
								@ENDPHP
								<div class="clearfix"> 
									<a class="glass" href="{{route('auto.addtocart', ['id' => $auto->id, 'variation' => $options])}}">
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
						@else
						@foreach($autos as $auto)
						<div class="col-md-3 col-sm-3"> 
							<div class="pro-item"> 
								<div class=" cat-opt-img "> <img src="{{asset('images/autos/'.$auto->auto->image)}}"> </div>
								<p class="font-1">{{$auto->auto->title}}</p>
								<p class="font-2">{{$auto->auto->location}} | {{$auto->auto->city}} | {{$auto->auto->state}}</p>
								<hr>
								<div class="row">
									<div class="col-md-6">
										<p class="font-3">{{$auto->number_value}} {{ucwords(str_replace('_', ' ', $autoOption))}}<br> for <br> {{$auto->duration_value}} months</p>
									</div>
									<div class="col-md-6">
										<p class="font-4"><del class="lighter">Rs {{$auto->price_value}} <br></del>Rs {{$auto->price_value}} </p>
									</div>
								</div>
								@PHP
								$options = $auto->price_value.'+'.$auto->price_key;
								$session_key = 'autos'.'_'.$auto->price_key.'_'.$auto->auto->id;
								$printsession = (array) Session::get('cart');
								@ENDPHP
								
								<div class="clearfix"> 
									<a class="glass" href="{{route('auto.addtocart', ['id' => $auto->auto->id, 'variation' => $options])}}">
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