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
        @if(count($products) >= 1)
        @foreach( $products->chunk(3) as $productchunk)
          <div class="row">
               @foreach( $productchunk as $product)
                <div class="col-sm-6 col-md-4">
                    <div class="thumbnail-product">
                    <img src="{{asset('images/'.$product->imagepath)}}" alt="{{$product->title}}" class="img-responsive">
                    <div class="caption">
                        <h3>{{$product->title}}</h3>
                        <p class="description">{{$product->location}}, {{$product->city}}, {{$product->state}}</p>
                        <div class="clearfix">
                            <div class="pull-left price">Rs {{$product->price}}</div>
                        <a href="{{ route('product.addtocart', ['id' => $product->id]) }}" class="btn btn-success pull-right" role="button">Add To Cart</a></div>
                    </div>
                    </div>
                </div>
             @endforeach
        </div>
        @endforeach
        @else

        <div class="row">
              
                <div class="col-md-6 col-md-offset-5">
                    <span class="alert alert-danger"> No Media add for this category!!!</span>
                </div>
            
        </div>
        @endif

@endsection
