@extends('layouts.master')

@section('title')
    Reset Password | Ad Launcher
@endsection

@section('content')
<div class="row form-page">
<div class="main animated fadeInUp">
    <div class="login-form">
        <h1>Reset Password</h1>
       <div class="head">
                        <img src="{{asset('images/user.png')}}" style="width: 132px;" alt="">
        </div>
        <form action="" method="post">
            @if(count($errors) > 0 )
                <div class="alert alert-danger">
                    @foreach($errors->all() as $error)
                        <p>{{ $error }}</p>
                    @endforeach
                </div>
            @endif
            @if(Session::has('message'))
                <div class="alert alert-success">
                    <p>{{ Session::get('message') }}</p>
                </div>
            @endif
            @if(Session::has('error'))
                <div class="alert alert-danger">
                   <p>{{ Session::get('error') }}</p>
               </div>
            @endif
            
                    <input type="password" id="password" name="password" placeholder="Password" value="{{old('email')}}" required>
                
                    <input type="password" id="password_confirmation" name="password_confirmation" value="{{old('password')}}" placeholder="Confirm Password" required>
                 
            {{ csrf_field() }}
           <div class="submit"> 
            <input type="submit" value="Update Password">
            </div>
        </form>
    </div>
    </div>
</div>
@endsection