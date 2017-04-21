@extends('layouts.master')

@section('title')
    Signup | Ad Launcher
@endsection

@section('content')
<div class="row form-page">

        <div class="main animated fadeInUp">
             <div class="login-form">
            <h1>User Registration</h1>
                    <div class="head">
                        <img src="{{asset('images/user.png')}}" style="width: 132px;" alt="">
                    </div>
                <form action="{{ route('user.signup') }}" method="post" class="">
                    @if(count($errors) > 0 )
                    <div class="alert alert-danger">
                        @foreach($errors->all() as $error)
                            <p>{{ $error }}</p>
                        @endforeach
                    </div>
                    @endif
                        <input type="email" class="text"  id="email" name="email" value="{{old('email')}}" placeholder="example@exp.com">
                        <input type="text" class="text"  id="first_name" name="first_name" value="{{old('first_name')}}" placeholder="First Name">
                        <input type="text" class="text"  id="last_name" name="last_name" value="{{old('last_name')}}" placeholder="Last Name">
                        <input type="text" class="text"  id="phone_number" name="phone_number" value="{{old('phone_number')}}" placeholder="Phone Number">
                        <input type="password" id="password" name="password" value="{{old('password')}}" placeholder="Password" required>
                        <input type="password" id="password_confirmation" name="password_confirmation" value="{{old('password_confirmation')}}" placeholder="Confirm Password" required>
                        <div class="submit">
                            <input type="submit" onclick="myFunction()" value="Register" required>
                    </div> 
                      {{ csrf_field() }}
                    

                </form>
            </div>
                
        </div>

</div>
@endsection