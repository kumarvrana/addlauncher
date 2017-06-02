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
<section class="sec-banner-metro">

    <div class="metro-anim">

        <div class="metro-train-anim">

            <img class="metro-clip" src="../images/header-animation/delhi-metro/metro-train-clip.png">

        </div>

        <div class="metro-bridge-static">

            
        </div>

        <div class="flying-plane3-anim">

  <img class="autos-clip" src="../images/header-animation/cars-anim/flying-plane-clip.png">

  </div>

    </div>
</section>  

<section class="sec-head-title">
    <h1>Advertise on <span>Metro</span></h1>
</section>      
<section class="main-sec">
        <div class="container-fluid"> <!-- container fluid 1 starts here -->
            <div class="row"> <!-- row starts here -->
                <div class="col-md-2">
                  @include('partials.sidebar')
                </div>

    <div class="col-md-8">
                    <h2>Result Found:</h2>
           

                  <div class="row"> <!-- row repeater starts here -->
                    
             @foreach( $products->chunk(3) as $productchunk)
                       @foreach( $productchunk as $product)
                        @PHP
                            if($product->status){
                                switch($product->status){
                                    case 1:
                                        $status = 'Available';
                                    break;
                                    case 2:
                                        $status = 'Sold Out';
                                    break;
                                    case 3:
                                        $status = 'Coming Soon';
                                    break;
                                }
                            }
                            $st_class= strtolower(str_replace(' ','_', $status));
                             
                      if($status!='Available')  {
                      @ENDPHP
                    <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
                        <div class="owl-item active">
                            <div class="single-product">
                                <div class="product-img">
                                        <img class="second-img" src="{{asset('images/metros/'.$product->image)}}" alt="product">
                                </div>
                                <div class="products-desc">
                                    
                                    <div class="product-price"><span>{{$product->title}}</span></div>
                                    <hr>
                                    <div class="product-name">
                                        {{$product->location}}, {{$product->city}}, {{$product->state}}
                                    </div>
                                </div>
                                <div class="product-mark {{$st_class}}">{{$status}}</div>
                                <div class="product-hover">
                                    <div class="add-to-cart {{$st_class}}"><span class="fa fa-ban"></span> {{$status}}</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    @PHP }

                    else { @ENDPHP

                    <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
                        <div class="owl-item active">
                            <div class="single-product">
                                <div class="product-img">
                                        <img class="second-img" src="{{asset('images/metros/'.$product->image)}}" alt="product">
                                </div>
                                <div class="products-desc">
                                    
                                    <div class="product-price"><span>{{$product->title}}</span></div>
                                    <hr>
                                    <div class="product-name">
                                        {{$product->location}}, {{$product->city}}, {{$product->state}}
                                    </div>
                                </div>
                                <div class="product-mark {{$st_class}}">{{$status}}</div>
                                <div class="product-hover">
                                    <div class="add-to-cart"><a href="{{ route('frontend.metrosingle', ['id' => $product->id]) }}"><span class="fa fa-shopping-cart"></span> View Details</a></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    @PHP } @ENDPHP

              @endforeach
        @endforeach
        
          </div> <!-- row repeater ends here -->
          <div class="row cat-data">
                    <div class="col-md-12">
                        <div class="data-box">
                            <h2>About Metro advertising in India</h2>
                            {!!$mediacat->description!!}
                        </div>
                    </div>
                    
                </div>
           
        </div>
        <div class="col-md-2">
            @include('partials.sidebar-cart')
                
        </div>
        </div><!-- row ends here -->
        </div><!-- container fluid 1 ends here -->

       
    
</section>
@endsection
