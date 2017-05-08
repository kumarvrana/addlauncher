@extends('layouts.master')

@section('title')

    Television | Media | Ad Launcher

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
         <h1><small>&emsp;ADVERTISE ON</small> <br><span>TELEVISIONS</span></h1>
     </div>
</section>       
<section class="main-sec">

<section class="main-sec">
        <div class="container-fluid"> <!-- container fluid 1 starts here -->
            <div class="row"> <!-- row starts here -->
                <div class="col-md-2">
                  @include('partials.sidebar')
                </div>

                <div class="col-md-8">
                    
                  <div class="row"> <!-- row repeater starts here -->
                   
                    @foreach($televisions_ads as $television)
                        @PHP
                        if($television->status){
                                    switch($television->status){
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

                    <div class="col-md-3">
                        <div class="owl-item active">
                            <div class="single-product">
                                <div class="product-img">
                                        <img class="second-img" src="{{asset('images/televisions/'.$television->image)}}" alt="product">
                                </div>
                                <div class="products-desc">
                                    
                                    <div class="product-price"><span>{{$television->title}}</span></div>
                                    <hr>
                                    <div class="product-name">
                                        {{$television->location}} | {{$television->city}} | {{$television->state}}
                                    </div>
                                </div>
                                <div class="product-mark sold_out">{{$status}}</div>
                                <div class="product-hover">
                                    <div class="add-to-cart"><a href="{{route('frontend.televisionsingle', ['id' => $television->id])}}"><span class="fa fa-shopping-cart"></span> View Details</a></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    @PHP }

                    else { @ENDPHP

                    <div class="col-md-3">
                        <div class="owl-item active">
                            <div class="single-product">
                                <div class="product-img">
                                        <img class="second-img" src="{{asset('images/televisions/'.$television->image)}}" alt="product">
                                </div>
                                <div class="products-desc">
                                    
                                    <div class="product-price"><span>{{$television->title}}</span></div>
                                    <hr>
                                    <div class="product-name">
                                        {{$television->location}} | {{$television->city}} | {{$television->state}}
                                    </div>
                                </div>
                                <div class="product-mark available">{{$status}}</div>
                                <div class="product-hover">
                                    <div class="add-to-cart"><a href="{{route('frontend.televisionsingle', ['id' => $television->id])}}"><span class="fa fa-shopping-cart"></span> View Details</a></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    @PHP } @ENDPHP
                    
                    @endforeach

        
          </div> <!-- row repeater ends here -->

          <div class="row cat-data">
                    <div class="col-md-12">
                        <div class="data-box">
                            <h2>About Television advertising in India</h2>

                            @foreach($mediacats as $mediacat)

                                @if($mediacat->label=='television') 

                                    {!!$mediacat->description!!}

                                @endif   

                            @endforeach
                            
                        </div>
                    </div>
                    
                </div>
           
        </div>

       <div class="col-md-2">
                    @include('partials.sidebar-cart')
                </div>
            </div>
        </div><!-- row ends here -->
        </div><!-- container fluid 1 ends here -->

</section>     
    

@endsection
