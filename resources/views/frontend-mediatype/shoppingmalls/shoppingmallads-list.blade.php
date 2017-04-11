@extends('layouts.master')

@section('title')

    Products

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
         <h1><span>SHOPPING MALL</span> AD OPTIONS</h1>
     </div>
</section>       
<section class="main-sec">
        <div class="container-fluid"> <!-- container fluid 1 starts here -->
            <div class="row"> <!-- row starts here -->
                <div class="col-md-2">
                  @include('partials.sidebar')
                </div>

                <div class="col-md-8">
                    <h2>Choose Shopping Mall Ad:</h2><hr>
           

                  <div class="row"> <!-- row repeater starts here -->
                    
                @PHP
                   $shoppingmall_options = array('danglers' => 'Danglers', 'drop_down_banners' => 'Drop Down Banners', 'signage' => 'Signage', 'pillar_branding' => 'Pillar Branding', 'washroom_branding' => 'Washroom Branding', 'wall_branding' => 'Wall Branding', 'popcorn_tub_branding' => 'Popcorn Tub Branding', 'product_kiosk' => 'Product Kiosk', 'standee' => 'Standee');
                    
                @ENDPHP
                    @foreach($shoppingmall_options as $key => $value)
                    @PHP
                        $image = $key.".png";
                    @ENDPHP
                    <div class="col-md-3">
                        <div class="owl-item active">
                            <div class="single-product">
                                <div class="product-img">
                                        <img class="second-img {{$key}}" src="{{asset('images/shoppingmalls/'.$image)}}" alt="{{$key}}">
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
                                    <div class="add-to-cart"><a href="{{ route('frontend.getfrontShoppingmalladByOption', ['shoppingmallOption' => $key]) }}"><span class="fa fa-shopping-cart"></span> View Details</a></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
        
          </div> <!-- row repeater ends here -->
           
        </div>
        <div class="col-md-2">
            @include('partials.sidebar-cart')
                
            </div>
        </div><!-- row ends here -->
        </div><!-- container fluid 1 ends here -->

</section>       
    

@endsection
