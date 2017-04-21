@extends('layouts.master')

@section('title')

   Busstop | Media | Ad Launcher

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
                <div class="loader" style="display:none"><img class="img-responsive" src="{{asset('images/logo/loading.gif')}}"/></div>
                <div class="row" id="table-results"> <!-- row repeater starts here -->
                    @PHP
                        $bus_options = array('full' => 'Full', 'both_side' => 'Both Side', 'left_side' => 'Left Side', 'right_side' => 'Right Side', 'back_side' => 'Back Side', 'back_glass' => 'Back Glass ', 'internal_ceiling' => 'Internal Ceiling', 'bus_grab_handles' => 'Bus Grab Handles', 'inside_billboards' => 'Inside Billboards');
                    @ENDPHP

                    @foreach($bus_options as $key => $value)
                        @PHP
                            $image = $key.".jpg";
                        @ENDPHP
                    <div class="col-md-3">
                        <div class="owl-item active">
                            <div class="single-product">
                                <div class="product-img">
                                        <img class="second-img {{$key}}" src="{{asset('images/buses/'.$image)}}" alt="{{$key}}">
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
                                    <div class="add-to-cart"><a href="{{ route('frontend.getfrontBusadByOption', ['busOption' => $key]) }}"><span class="fa fa-shopping-cart"></span> View Details</a></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>  <!-- row repeater ends here -->

                <div class="row cat-data">
                    <div class="col-md-12">
                        <div class="data-box">
                            <h2>About Airport & Airline advertising in India</h2>
                            <p class="data-para">Airline and Airport advertising in India is a recent phenomenon. With the increase in airline passengers and airport traffic number interesting airline advertising options have come up. New large airports in India have also created interesting advertising ideas at the airports. Indigo Airlines, Jet Airways and Spice Jet are few of the large airline carriers in India. Similarly on the airport front, Delhi T3 terminal, Mumbai Airport, Bengaluru Airport and Chennai Airport are few of the large airports in India providing unique opportunities to advertisers to reach out to premium passengers.</p>
                            <p class="data-para">While airline advertising costs and execution is always at national level, airport advertising cost is for a particular city. So Airline and Airport advertising provides the opportunity for both hyper local marketing as well as national advertising campaigns.</p>
                            <p class="data-para">Airports have a lot if unique and interesting advertising options and ideas. Popular advertising options at the airports are billboards, branding in baggage area, hoardings in check in area, conveyor bill branding, trolleys advertising and many others.</p>
                            <p class="data-para">Airport lounges advertising options are unique in nature and very effective for premium brands. Media options in Airport lounges vary from placing banners, product sampling to innovative media options. Popular advertising options in airlines are luggage tag branding, boarding pass branding and airline seat back branding.</p>
                            <h3>Advantages of Airport Advertisement</h3>
                            <ul>
                                <li>Airport displays capture the attention of a huge traveller audience.</li>
                                <li>Advertising campaigns can target lifestyles as well as business needs.</li>
                                <li>Advertising is available in most domestic and international airports, as well as, most regional airport terminals.</li>
                                <li>A variety of Airport advertising options include backlit dioramas, free standing kiosks, state of the art L.E.D, plasma panels a scrolling displays terminal walls, freestanding baggage claim directories, stairways columns, gates, luggage push carts wall wraps all at one place.</li>
                                
                            </ul>
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
