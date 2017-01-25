@extends('layouts.master')

@section('title')
        Add Launcher
@endsection

@section('content')
        <div class="row">
            @foreach($mediacats as $mediacat)        
            <div class="col-xs-6 col-md-3">
               <a href="{{route('frontend.adProductsByName', ['catName' => $mediacat->slug])}}" class="thumbnail">
                <img src="{{asset('images/'.$mediacat->image)}}" class="img-responsive" alt="...">
                    <figcaption>
                        <h2>{{$mediacat->title}}</h2>
                        <p>Coming Soon<br>
                        <a href="#" title="{{$loop->iteration}}" data-gallery="">View more</a></p>            
                    </figcaption>
                </a>
            </div>
         @endforeach
            
@endsection