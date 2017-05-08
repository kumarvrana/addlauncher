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
         <h1><span>{{$title}}</span> OPTIONS</h1>
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
				
					@if($televisionad)
						@foreach($televisionad as $television)
						<div class="col-md-3 col-sm-3"> 
							<div class="pro-item"> 
								<div class=" cat-opt-img "> <img src="{{asset('images/televisions/'.$television->television->image)}}"> </div>
								<p class="font-1">{{$television->television->title}} | {{ucwords(str_replace('_', ' ', substr($television->rate_key, 5)))}}</p>
								<p class="font-2">{{$television->television->location}} | {{$television->television->city}} | {{$television->television->state}}</p>
								<hr>
								<div class="row">
									<div class="col-md-6">
										<p class="font-3">{{$television->exposure_value}} {{ucwords(str_replace('_', ' ', substr($television->rate_key, 5)))}}<br> for <br> {{$television->exposure_value}} months</p>
									</div>
									<div class="col-md-6">
										<p class="font-4"><del class="lighter">Rs {{$television->rate_value}} <br></del>Rs {{$television->rate_value}} </p>
									</div>
								</div>
								@PHP
								$options = $television->rate_value.'+'.$television->rate_key;
								$session_key = 'televisions'.'_'.$television->rate_key.'_'.$television->television->id;
								$printsession = (array) Session::get('cart');
								@ENDPHP
								
								<div class="clearfix"> 
									<a class="glass" href="{{route('television.addtocart', ['id' => $television->television->id, 'variation' => $options])}}">
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