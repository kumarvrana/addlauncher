@extends('layouts.master')

@section('title')

    Bus | Media | Ad Launcher

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
         <h1><small>&emsp;ADVERTISE ON</small> <br><span>BUSES</span></h1>
     </div>
</section>       
<section class="main-sec">
    <div class="container-fluid"> {{-- container fluid 1 starts here --}}
        <div class="row"> {{-- row starts here --}}
            <div class="col-md-2">
                @include('partials.sidebar')
            </div>

            <div class="col-md-8">
              <div class="ad-sec">  
                <div class="loader" style="display:none"></div>
                <div class="data-box" > <!-- row repeater starts here -->
                <div class="row" id="table-results">
                    
                    @foreach($bus_options as $bus)
                        @PHP
                            $image = $bus.".jpg";
                        @ENDPHP
                    <div class="col-md-3">
                        <div class="owl-item active">
                            <div class="single-product">
                                <div class="product-img">
                                        <img class="second-img {{$bus->image}}" src="{{asset('images/buses/'.$image)}}" alt="{{$bus}}">
                                </div>
                                <div class="products-desc">
                                    
                                    <div class="product-price"><span>{{$bus->title}}</span></div>
                                    <hr>
                                    <div class="product-name">
                                        {{$location}}
                                    </div>
                                </div>
                                <div class="product-mark"></div>
                                <div class="product-hover">
                                    <div class="add-to-cart"><a href="{{ route('frontend.getfrontBusadByOption', ['busOption' => $bus]) }}"><span class="fa fa-shopping-cart"></span> View Details</a></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
                </div> <!-- row repeater ends here -->

                <div class="row cat-data">
                    <div class="col-md-12">
                        <div class="data-box">
                            <h2>About Bus & Airline advertising in India</h2>
                           
                          @foreach($mediacats as $mediacat)

                                @if($mediacat->label=='Buses') 
 
                                    {!!$mediacat->description!!}

                                @endif   

                            @endforeach
                            
                        </div>
                    </div>
                    
                </div>

                </div>
            </div>
            <div class="col-md-2">
            @include('partials.sidebar-cart')
                
            </div>
            <!--div id="table-results"></div-->
        </div><!-- row ends here -->
    </div><!-- container fluid 1 ends here -->
</section>       
    

@endsection
