@extends('layouts.master')

@section('title')

    Coming Soon

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
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <img src="{{asset('images/comingsoon2.jpg')}}" class="img-responsive">
            </div>
        </div>
    </div>
          

@endsection
