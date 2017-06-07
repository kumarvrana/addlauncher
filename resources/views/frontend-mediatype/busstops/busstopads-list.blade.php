@extends('layouts.master')

@section('title')

    Busstops List | Add Launcher

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

@include('banner.busstopBanner')
<section class="main-sec">
        <div class="container-fluid"> <!-- container fluid 1 starts here -->
            <div class="row"> <!-- row starts here -->
                <div class="col-md-2">
                  @include('partials.filter-sidebar.busstop')
                </div>

                <div class="col-md-8">
                <div class="ad-sec">  
                <div class="loader" style="display:none"></div>
                <div class="data-box" > <!-- row repeater starts here -->
                <div class="row" id="table-results">    
             @foreach( $products->chunk(3) as $productchunk)
                @foreach( $productchunk as $product)
                       @PHP
                       $status = $product->status;
                       $st_class = strtolower(str_replace(' ','_', $status));
                       $class_cursor1 = $st_class."_cursor";
                       $class_cursor = ($status !='Available') ? $class_cursor1 : '';
                      @ENDPHP
                    <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
                    <div class="owl-item active">
                    @if( $status === 'Available') <a href="{{ route('frontend.busstopsingle', ['id' => $product->id]) }}"> @endif
                        <div class="single-product {{$class_cursor}} ">
                          <div class="ribbon"><span class="{{$st_class}}">{{$status}}</span></div>

                            <div class="product-img">
                                    <img class="second-img" src="{{asset('images/busstops/'.$product->image)}}" alt="product">
                            </div>
                                <div class="products-desc">
                                    
                                    <div class="product-price"><span>{{$product->title}}</span></div>
                                    <hr>
                                    <div class="btn thb-fill-style">
                                       <span> {{$product->location}} | {{$product->city}} | {{$product->state}}</span>
                                    </div>
                                </div>
                                
                            </div>
                        @if( $status === 'Available') </a>  @endif
                        </div>
                    </div>

                @endforeach
            @endforeach

          </div> <!-- row repeater ends here -->
          <div class="row cat-data">
                    <div class="col-md-12">
                        <div class="data-box">
                            <h2>About Airport & Airline advertising in India</h2>
                                {!!$mediacat->description!!}
                        </div>
                    </div>
                    
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
