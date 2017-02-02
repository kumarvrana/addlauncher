@extends('layouts.master')

@section('title')
    Signup | Ad Launcher
@endsection

@section('content')
<div class="row">
    <div class="col-md-4 col-md-offset-4">
        <h1>Sign Up</h1>
       
        <form action="{{ route('user.signup') }}" method="post">
             @if(count($errors) > 0 )
            <div class="alert alert-danger">
                @foreach($errors->all() as $error)
                    <p>{{ $error }}</p>
                @endforeach
            </div>
            @endif
            <div class="form-group">
                <div class="input-group">
                    <label class="input-group-addon" for="email"><i class="fa fa-envelope"></i></label>
                    <input type="email" id="email" name="email" placeholder="example@exp.com" value="{{old('email')}}" class="form-control">
                </div>
            </div>
            <div class="form-group">
                <div class="input-group">
                    <label class="input-group-addon" for="first_name"><i class="fa fa-user"></i></label>
                    <input type="text" id="first_name" name="first_name" placeholder="First Name" value="{{old('first_name')}}" class="form-control">
                </div>
            </div>
             <div class="form-group">
                <div class="input-group">
                    <label class="input-group-addon" for="last_name"><i class="fa fa-user"></i></label>
                    <input type="text" id="last_name" name="last_name" placeholder="Last Name" value="{{old('last_name')}}" class="form-control">
                </div>
            </div>
            <div class="form-group">
                 <div class="input-group">
                    <label class="input-group-addon" for="password"><i class="fa fa-lock" aria-hidden="true"></i>
</label>
                    <input type="password" id="password" name="password" class="form-control" value="{{old('password')}}" placeholder="password" required>
                </div>
            </div>
            <div class="form-group">
                 <div class="input-group">
                    <label class="input-group-addon" for="password_confirmation"><i class="fa fa-lock" aria-hidden="true"></i>
</label>
                    <input type="password" id="password_confirmation" name="password_confirmation" value="{{old('password_confirmation')}}" class="form-control" placeholder="confirm password" required>
                </div>
            </div>
            {{ csrf_field() }}
            <button type="submit" class="btn btn-primary pull-right">Sign Up</button>
            
        </form>
    </div>
</div>
@endsection