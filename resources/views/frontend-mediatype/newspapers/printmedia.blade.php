@extends('layouts.master')
@section('title')
Print Media | Add Launcher
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
@include('banner.printmediaBanner')   
<section class="main-sec">
   <div class="container-fluid">
      <!-- container fluid 1 starts here -->
      <div class="row">
         <!-- row starts here -->
         <div class="col-md-2">
            @include('partials.sidebar')
         </div>
         <div class="col-md-8">
            <div class="ad-sec">
               <div class="loader" style="display:none"></div>
               <div class="data-box" >
                  <!-- row repeater starts here -->
                  <div class="row" id="table-results">
                   
                     <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
                            <div class="owl-item active">
                                <a href="{{route('frontend.getallnewspapers')}}">
                                    <div class="single-product">
                                        <div class="product-img">
                                            <img class="second-img media-newspaper" src="http://192.168.0.39/myshop/public/images/airports/backlit_panel.jpg" alt="newspaper">
                                        </div>
                                        <div class="products-desc">

                                            <div class="product-price"><span>Newspaper</span></div>
                                            <hr>
                                            <div class="btn thb-fill-style">
                                                <span>Delhi NCR</span>
                                            </div>
                                        </div>

                                    </div>
                                </a>
                            </div>
                        </div>
                    
                     <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
                            <div class="owl-item active">
                                <a href="{{route('frontend.getallmagazine')}}">
                                    <div class="single-product">
                                        <div class="product-img">
                                            <img class="second-img media-magazine" src="http://192.168.0.39/myshop/public/images/airports/backlit_panel.jpg" alt="magazine">
                                        </div>
                                        <div class="products-desc">

                                            <div class="product-price"><span>Magazine</span></div>
                                            <hr>
                                            <div class="btn thb-fill-style">
                                                <span>Delhi NCR</span>
                                            </div>
                                        </div>

                                    </div>
                                </a>
                            </div>
                        </div>
                  </div>
                  <!-- row repeater ends here -->
               </div>
            </div>
         </div>
         <div class="col-md-2">
            @include('partials.sidebar-cart')
         </div>
      </div>
      <!-- row ends here -->
   </div>
   <!-- container fluid 1 ends here -->
</section>
@endsection