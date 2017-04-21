@extends('layouts.master')

@section('title')
    Forget Password | Ad Launcher
@endsection

@section('content')
<div class="row form-page">

<div class="main animated fadeInUp">
    <div class="login-form">
            <h1>Forget Password?</h1>
                    <div class="head">
                        <img src="{{asset('images/user.png')}}" style="width: 132px;" alt="">
                    </div>
                <form action="{{ route('user.postforgetpassword') }}" method="post">
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


                        <input type="email" class="text"  id="email" name="email" value="{{old('email')}}" placeholder="Enter Your Email">
                        
                        <div class="submit">
                        {{ csrf_field() }}
                            <input type="submit" onclick="myFunction()" value="Send Password" required>
                    </div>  
                    <p>Or <a href="{{ route('user.signin') }}"><span class="fa fa-user"></span> Login Here</a></p>

                      
                </form>
            </div>
                
</div>
  
</div>
@endsection