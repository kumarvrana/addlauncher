@extends('layouts.master')

@section('title')

    Outdoor Advertising | Add Launcher

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
     	 <h1><small>&emsp;ADVERTISE ON</small> <br><span>{{ucwords(str_replace('_', ' ', $billboardOption))}}</span></h1>
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
						
						@if($billboards)
							@foreach($billboards as $billboard)
								
								<div class="col-lg-3 col-md-4 col-sm-6 col-xs-12"> 
									<div class="pro-item"> 
										<div class=" cat-opt-img "> <img src="{{asset('images/outdooradvertising/'.$billboard->billboard->image)}}"> </div>
										<p class="font-1">{{$billboard->billboard->title}}</p>
										<p class="font-2">{{$billboard->billboard->landmark}} <br> <span class="cityfont">{{$billboard->billboard->city}} </span>
										</p>
										<hr>
										<div class="row">
											<div class="col-md-6">
												<p class="font-3">1 Ad Per Month<br>
												<span><span class="text-danger">Size: </span>{{$billboard->billboard->size}}</span>
											</div>
											<div class="col-md-6">
												<p class="font-4"><del class="lighter">Rs {{$billboard->price_value}} <br></del>Rs {{$billboard->price_value}} </p>
											</div>
										</div>
										
										@PHP
											$options = $billboard->price_value.'+'.$billboard->price_key;
											$session_key = 'billboards'.'_'.$billboard->price_key.'_'.$billboard->billboard->id;
											$printsession = (array) Session::get('cart');														
										@ENDPHP
										<div class="clearfix"> 
											<a class="glass" href="{{route('billboard.addtocart', ['id' => $billboard->billboard->id, 'variation' => $options])}}">
											
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


        		</div><!-- col-md-8 ends here -->
        		<div class="col-md-2">
            @include('partials.sidebar-cart')
   					
        			
        		</div>
    		</div>
    	</div><!-- container fluid 1 ends here -->
           
</section>	
       

@endsection