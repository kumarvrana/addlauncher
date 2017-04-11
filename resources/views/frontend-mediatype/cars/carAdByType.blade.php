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
         <h1><span>{{ucwords(str_replace('_', ' ', $cartype))}}</span> AD</h1>
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
                 
                        @PHP
                           $car_options = array('bumper' => 'Bumper', 'rear_window_decals' => 'Rear Window Decals', 'doors' => 'Doors');
                                
                        @ENDPHP
                        
                        @foreach($car_options as $key => $value)
                            @PHP
                                $image = $key.".png";
                            @ENDPHP
                        <div class="col-md-3">
                                <div class="owl-item active">
                                    <div class="single-product">
                                        <div class="product-img">
                                                <img class="second-img {{$key}}" src="{{asset('images/display/car/'.$cartype.'/'.$image)}}" alt="{{$key}}">
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
                                            <div class="add-to-cart"><a href="{{route('frontend.getfrontCaradByOption', ['cartype' => $cartype,'carOption' => $key])}}"><span class="fa fa-shopping-cart"></span> View Details</a></div>
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

       
    

@endsection
