@extends('layouts.master')

@section('title')

    Car/Taxi | Media | Ad Launcher

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
         <h1><small>&emsp;ADVERTISE ON</small> <br><span>CARS</span></h1>
     </div>
</section>       
<section class="main-sec">      
<section class="main-sec">
        <div class="container-fluid"> <!-- container fluid 1 starts here -->
            <div class="row"> <!-- row starts here -->
                <div class="col-md-2">
                  @include('partials.filter-sidebar.car-full')
                </div>

                <div class="col-md-8">
                 
                   <div class="ad-sec">  
                        <div class="loader" style="display:none"></div>
                        <div class="data-box" > <!-- row repeater starts here -->
                            <div class="row" id="table-results">
                    
                    @foreach($car_type as $key => $value)
                    @PHP
                        $image = $key.".jpg";
                    @ENDPHP
                    <div class="col-md-3">
                        <div class="owl-item active">
                        <a href="{{ route('frontend.getfrontCaradByType', ['cartype' => $key]) }}">
                            <div class="single-product">
                                <div class="product-img">
                                        <img class="second-img {{$key}}" src="{{asset('images/cars/'.$image)}}" alt="{{$key}}">
                                </div>
                                <div class="products-desc">
                                    
                                    <div class="product-price"><span>{{$value}}</span></div>
                                    <hr>
                                    <div class="btn thb-fill-style">
                                        Delhi NCR
                                    </div>
                                </div>
                                <div class="product-mark"></div>
                                
                            </div>
                            </a>
                        </div>
                    </div>
                    @endforeach
                    </div>
                        </div>

          </div> <!-- row repeater ends here -->
          <div class="row cat-data">
                    <div class="col-md-12">
                        <div class="data-box">
                            <h2>About Car advertising in India</h2>
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

       
    

@endsection
