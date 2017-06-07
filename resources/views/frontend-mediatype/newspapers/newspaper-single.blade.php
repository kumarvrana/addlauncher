@extends('layouts.master')

@section('title')

    Newspaper/Magazine | Print Media | Add Launcher

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
         <h1><small>&emsp;ADVERTISE ON</small> <br><span>Print Media</span></h1>
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
						
						@if($priceData)
							@foreach($priceData as $printMedia)
								
								<div class="col-lg-3 col-md-4 col-sm-6 col-xs-12"> 
									<div class="pro-item"> 
										<div class=" cat-opt-img "> <img src="{{asset('images/newspapers/'.$printMedia->printmedia->image)}}"> </div>
										<p class="font-1">{{$printMedia->printmedia->title}}</p>
										<p class="font-2">{{$printMedia->printmedia->location}} | {{$printMedia->printmedia->state}}</p>
										
										<hr>
										@if($printmediaType === 'newspaper')
										<div class="row">
											<div class="col-md-6">
												<p class="font-3"> {{ucwords(str_replace('_', ' ', substr($printMedia->price_key, 6)))}} Ad <br>
												Rs {{$printMedia->total_price }} per {{$printMedia->pricing_type}}</p>
											</div>
											<div class="col-md-6">
												<p class="font-4"><del class="lighter">Rs {{$printMedia->total_price * 16}} <br>16 {{$printMedia->pricing_type}} <br></del>Rs {{$printMedia->total_price * 16}} <br>16 {{$printMedia->pricing_type}}</p>
											</div>
											
										</div>
										@else
											<div class="row">
												<div class="col-md-6">
													<p class="font-3">  {{ucwords(str_replace('_', ' ', substr($printMedia->price_key, 6)))}} Ad</p>
												</div>
												<div class="col-md-6">
													<p class="font-4"><del class="lighter">Rs {{$printMedia->price_value}} per edition <br></del>Rs {{$printMedia->price_value}} per edition</p>
												</div>
												
											</div>
										@endif
										
										@PHP
											if($printmediaType === 'newspaper'){
												$options = $printMedia->total_price.'+'.$printMedia->price_key;
												$session_key = 'newspaper'.'_'.$printMedia->price_key.'_'.$printMedia->printmedia->id;
												$printsession = (array) Session::get('cart');
											}else{
												$options = $printMedia->price_value.'+'.$printMedia->price_key;
												$session_key = 'magazine'.'_'.$printMedia->price_key.'_'.$printMedia->printmedia->id;
												$printsession = (array) Session::get('cart');
											}
											
										@ENDPHP
										<div class="clearfix"> 
											<a class="glass" href="{{route('newspaper.addtocart', ['id' => $printMedia->printmedia->id, 'variation' => $options])}}">

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