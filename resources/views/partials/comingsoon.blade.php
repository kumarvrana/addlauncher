@extends('layouts.master')

@section('title')

    Comming Soon

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
    <div class="container-fluid">
    <div class="row cart-body">
        <div class="col-md-8 col-md-offset-2 wrapper form-box">
               <form role="form" class="registration-form" action="javascript:void(0);">
               <fieldset>
                    <div class="form-bottom">
                        <div class="row">
                            <div class="row">
                                <div class="col-md-8 col-md-offset-2 ">
                                    <img src="{{asset('images/comingsoon2.jpg')}}" class="img-responsive">
                                </div>
                            </div>
                        </div>
                    </div>
                </fieldset>
                </form>
        </div>
    </div>
    </div>        

@endsection
