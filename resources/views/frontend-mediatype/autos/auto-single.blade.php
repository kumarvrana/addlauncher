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
			     	
			     		@if($products)
							@foreach($products as $product)
			     			<div class="col-md-3 col-sm-3 "> 
				     			<div class="pro-item"> 
										<div class=" cat-opt-img "> <img src="{{asset('images/autos/'.$product[11])}}"> </div>
										<p class="font-1">{{$product[6]}}</p>
										<p class="font-2">{{$product[8]}} | {{$product[9]}} | {{$product[10]}}</p>
										<hr>
										<div class="row">
											<div class="col-md-6">
												<p class="font-3">{{$product[23]}} {{ucwords(str_replace('_', ' ', $autoOption))}}<br> for <br> {{$product[25]}} months</p>
											</div>
											<div class="col-md-6">
												<p class="font-4"><del class="lighter">Rs {{$product[21]}} <br></del>Rs {{$product[21]}} </p>
											</div>
										</div>
										
										 @PHP
										$options = $product[21].'+'.$product[20];
										$session_key = 'autos'.'_'.$product[20].'_'.$product[0];
										$printsession = (array) Session::get('cart');
														
									@ENDPHP
										<div class="clearfix"> 
											<a class="glass" href="{{route('auto.addtocart', ['id' => $product[0], 'variation' => $options])}}">
											
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