@extends('layouts.master')

@section('title')

    Billboard | Add Launcher

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
         <h1><span>{{ucwords(str_replace('_', ' ', $billboardOption))}}</span> OPTION</h1>
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
										<div class=" cat-opt-img "><img src="{{asset('images/outdooradvertising/'.$product[11])}}"> </div>
										<p class="font-1">{{$product[3]}}</p>
										<p class="font-2">{{$product[5]}} | {{$product[6]}} | {{$product[7]}}</p>
										<hr>
										<div class="row">
											<div class="col-md-6">
												<p class="font-3">{{$product[17]}} {{ucwords(str_replace('_', ' ', $billboardOption))}}<br> for <br> {{$product[15]}} months</p>
											</div>
											<div class="col-md-6">
												<p class="font-2"><del class="lighter">Rs {{$product[19]}} <br> </del>Rs {{$product[19]}} </p>
											</div>
										</div>
										 @PHP
										$options = $product[19].'+'.$product[18];
										$session_key = 'billboards'.'_'.$product[18].'_'.$product[0];
										$printsession = (array) Session::get('cart');
												
									@ENDPHP
										<div class="clearfix"> 
											<a class="glass" href="{{route('billboard.addtocart', ['id' => $product[0], 'variation' => $options])}}">
											
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