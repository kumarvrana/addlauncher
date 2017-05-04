@extends('layouts.master')

@section('title')
    Signin | Ad Launcher
@endsection

@section('content')
<div class="row form-page">
<div class="main animated fadeInUp">
             <div class="login-form">
            <h1>Member Login</h1>
                    <div class="head">
                        <img src="{{asset('images/user.png')}}" style="width: 132px;" alt="">
                    </div>
                <form action="{{ route('user.signin') }}" method="post">
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


                        <input type="email" class="text"  id="email" name="email" value="{{old('email')}}" placeholder="Email">
                        <input type="password" id="password" name="password" value="{{old('password')}}" placeholder="Password" required>
                        <div class="submit">
                            <input type="submit" onclick="myFunction()" value="LOGIN" required>
                    </div>  
                      {{ csrf_field() }}
                    <p><a href="{{ route('user.forgetpassword') }}">Forgot Password ?</a></p>
                </form>
            </div>
            <!--
                <div class="adl-other-login"><a href="{{route('socicalLogin', ['loginWith' => 'facebook'])}}">Facebook login</a></div>
                <div class="adl-other-login"><a href="{{route('socicalLogin', ['loginWith' => 'twitter'])}}">Twitter login</a></div>
                <div class="adl-other-login"><a href="{{route('socicalLogin', ['loginWith' => 'linkedin'])}}">Linkedin login</a></div>
            -->
        </div>

</div>
@endsection


