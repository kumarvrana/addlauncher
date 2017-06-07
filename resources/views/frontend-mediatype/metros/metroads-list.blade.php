@extends('layouts.master')

@section('title')

    Metro | Media | Ad Launcher

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

        @include('banner.metroBanner')
        <section class="sec-head-title">
    <h1>Advertise on <span>Cars</span></h1>
</section>  

<section class="main-sec">
        <div class="container-fluid"> <!-- container fluid 1 starts here -->
            <div class="row"> <!-- row starts here -->
                <div class="col-md-2">
                  @include('partials.sidebar')
                </div>

                <div class="col-md-8">
                 
                   <div class="ad-sec">  
                        <div class="loader" style="display:none"></div>
                        <div class="data-box" > <!-- row repeater starts here -->
                    <div class="row" id="table-results">

                    @foreach($metro_line as $key => $value)
                     
                    @PHP
                        $image = $key.".jpg";
                    @ENDPHP
                    <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
                        <div class="owl-item active">
                        <a href="{{ route('frontend.metrosingle', ['metro_line' => $key]) }}">
                            <div class="single-product">
                                <div class="product-img">
                                        <img class="second-img {{$key}}" src="{{asset('images/metros/'.$image)}}" alt="{{$key}}">
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
