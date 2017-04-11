@extends('layouts.master')

@section('title')

    Auto | Media | Ad Launcher

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
         <h1><span>{{ucwords(str_replace('_', ' ', $autotype))}}</span> AD</h1>
     </div>
</section> 

<section class="main-sec">        
        <div class="container-fluid"> <!-- container fluid 1 starts here -->
            <div class="row"> <!-- row starts here -->
                <div class="col-md-2">
                  @include('partials.sidebar')
                </div>

                <div class="col-md-8">
                   
                  <div class="row"> <!-- row repeater starts here -->
                  @if($autotype != 'tricycle')
                        @PHP
                            switch($autotype){
                                case 'auto_rikshaw':
                                    $options = array('sticker' => 'Sticker', 'auto_hood' => 'Auto Hood', 'backboard' => 'Backboard', 'full_auto' => 'Full Auto');
                                break;
                                case 'e_rikshaw':
                                    $options = array('back_board' => 'Back Board', 'stepney_tier' => 'Stepney Tier');
                                break;
                            }
                                
                        @ENDPHP
                        
                        @foreach($options as $key => $value)
                            @PHP
                                $image = $key.".png";
                            @ENDPHP
                        <div class="col-md-3">
                                <div class="owl-item active">
                                    <div class="single-product">
                                        <div class="product-img">
                                                <img class="second-img {{$key}}" src="{{asset('images/display/auto/'.$image)}}" alt="{{$key}}">
                                        </div>
                                        <div class="products-desc">
                                            
                                            <div class="product-price"><span>{{$value}}</span></div>
                                            <hr>
                                            <div class="product-name">
                                                Delhi NCR
                                            </div>
                                        </div>
                                        <div class="product-mark"></div>
                                        <div class="product-hover">
                                            <div class="add-to-cart"><a href="{{route('frontend.getfrontAutoadByOption', ['autotype' => $autotype,'autoOption' => $key])}}"><span class="fa fa-shopping-cart"></span> View Details</a></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach

                    @else
                    
                        @if($products)
                            <div class="display-title">
                                <h2>Tricyle Ads:</h2>
                            </div>
                            @foreach($products as $product)
                            <div class="col-md-3 col-sm-3 "> 
                                    <div class="pro-item"> 
                                        <div class="cat-opt-img"><img class="second-img" src="{{asset('images/display/auto/tricycle.png')}}" alt="{{$product->title}}"></div>
                                        <p class="font-1">{{$product->title}} in {{$product->location}}</p>
                                        <p class="font-3">{{$product->auto_number}} Tricycles for 1 months</p>
                                        <p class="font-2"><del class="lighter">Rs {{$product->price}}</del>Rs {{$product->price}}</p>
                                        @PHP
                                            $options = $product->price.'+tricycle';
                                            $session_key = 'autos'.'_'.'tricycle'.'_'.$product->id;
                                            $printsession = (array) Session::get('cart');
                                        
                                        @ENDPHP
                                        <div class="clearfix"> 
                                            <a class="glass" href="{{route('auto.addtocart', ['id' => $product->id, 'variation' => $options])}}"><span class="fa fa-star"></span>
                                                @if(count($printsession) > 0)
                                                @if(array_key_exists($session_key, $printsession['items'])) 
                                                    Remove From Cart 
                                                @else
                                                    Add to Cart 
                                                @endif
                                                @else
                                                    Add to Cart
                                                @endif
                                            </a> 
                                        </div>
                                    </div>
                                </div>
                        
                                @endforeach
                        @endif
		           
                    @endif

          </div> <!-- row repeater ends here -->
           
        </div>

        <div class="col-md-2">
                    @include('partials.sidebar-cart')
        </div>

        </div><!-- row ends here -->
        </div><!-- container fluid 1 ends here -->
</section>
       
    

@endsection
