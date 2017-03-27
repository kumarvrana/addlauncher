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
              
        @foreach( $products->chunk(3) as $productchunk)
        
       
            <div class="row">
                <div class="col-md-3">
                  @include('partials.sidebar')
                </div>

                <div class="col-md-9">
                    
                <h2>Result Found:</h2>

          <div class="row row-repeater">
               @foreach( $productchunk as $product)
                <div class="col-md-3 repeater-product">
                    <div class="box-first-cat">
                       <a href="{{ route('frontend.socialmediasingle', ['id' => $product->id]) }}">
                    
                    <img src="{{asset('images/socialmedias/'.$product->image)}}" alt="{{$product->title}}" class="img-responsive">
                    <div class="cat-box-1">
                        <h2>{{$product->title}}</h2>
                        <h3>{{$product->location}}, {{$product->city}}, {{$product->state}}</h3>
                        </div>
                    
                    </a> 
                   <div class="more-item"><span class="fa fa-inr"></span> {{$product->price}}</div>
                       
                    </div>
                    
                </div>
              @endforeach
          </div> 
        </div>
        </div>
        </div><!-- container fluid 1 ends here -->

        @endforeach
      

@endsection
