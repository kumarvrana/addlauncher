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
                                 <img class="second-img" src="{{asset('images/newspapers/'.$product->image)}}" alt="product">
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
                                 <img class="second-img" src="{{asset('images/newspapers/'.$product->image)}}" alt="product">
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
                                 <div class="add-to-cart"><a href="{{ route('frontend.newspapersingle', ['id' => $product->id]) }}"><span class="fa fa-shopping-cart"></span> View Details</a></div>
                              </div>
                           </div>
                        </div>
                     </div>
                     @PHP } @ENDPHP
                     @endforeach
                     @endforeach
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