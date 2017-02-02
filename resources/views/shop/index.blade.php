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
        <div class="container-fluid"> <!-- container fluid 1 starts here -->

        <!-- Section for Breadcrumbs -->

            <!-- <section class="mt-contact-banner style4" style="background-image: url(images/img11.jpg);">
                    <div class="container">
                        <div class="row">
                            <div class="col-xs-12 text-center">
                                <h1>SUB CATEGORY</h1> -->
                                <!-- Breadcrumbs of the Page -->
                               <!--  <nav class="breadcrumbs">
                                    <ul class="list-unstyled">
                                        <li><a href="#">Home <i class="fa fa-angle-right"></i></a></li>
                                        <li><a href="#">Category <i class="fa fa-angle-right"></i></a></li>
                                        <li>Sub Category</li>
                                    </ul> -->
                                <!-- </nav> --><!-- Breadcrumbs of the Page end -->
                          <!--   </div>
                        </div>
                    </div>
                </section> -->

        <!-- Breadcrumb Section Ends     -->

        

        @if(count($products) >= 1)
        @foreach( $products->chunk(3) as $productchunk)
        
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-3">
                    <h2>Sidebar</h2>
                    <div class="list-group">
                        <a href="#" class="list-group-item">Section</a>
                        <a href="#" class="list-group-item">Section</a>
                        <a href="#" class="list-group-item">Section</a>
                        <a href="#" class="list-group-item">Section</a>
                        <a href="#" class="list-group-item">Section</a>
                        <a href="#" class="list-group-item">Section</a>
                        <a href="#" class="list-group-item">Section</a>
                        <a href="#" class="list-group-item">Section</a>
                        <a href="#" class="list-group-item">Section</a>
                    </div>
                </div>

                <div class="col-md-9">
                    
                <h2>Result Found:</h2>

          <div class="row row-repeater">
               @foreach( $productchunk as $product)
                <div class="col-md-3 repeater-product">
                    <div class="box-first-cat">
                       <a href="{{ route('frontend.productsingle', ['id' => $product->id]) }}"><!-- old class="product-module" -->
                    
                    <img src="{{asset('images/'.$product->imagepath)}}" alt="{{$product->title}}" class="img-responsive">
                    <div class="cat-box-1">
                        <h2>{{$product->title}}</h2>
                        <h3>{{$product->location}}, {{$product->city}}, {{$product->state}}</h3>
                        </div>
                    
                    </a> 

                            <div class="more-item"><span class="fa fa-inr"></span> {{$product->price}}</div>
                        <!--a href="{{ route('product.addtocart', ['id' => $product->id]) }}" class="btn btn-success pull-right" role="button">Add To Cart</a-->
                                        </div><!-- cat-2-box ends here -->
                    
                </div>
             @endforeach
        </div> <!-- row repeater ends here -->
        </div> <!-- col-md-9 ends here -->
        </div><!-- row ends here -->
        </div><!-- container-fluid ends here -->

        @endforeach
        @else

        

        </div> <!-- Container fluid 1 ends here --> 

        <div class="row">
              
                <div class="col-md-6 col-md-offset-5">
                    <span class="alert alert-danger"> No Media add for this category!!!</span>
                </div>
            
        </div>
        @endif

@endsection
