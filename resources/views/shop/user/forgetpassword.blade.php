@extends('layouts.master')

@section('title')
    Forget Password | Ad Launcher
@endsection

@section('content')
<div class="row">
    <div class="col-md-4 col-md-offset-4">
        <h1>Forget Password</h1>
       
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
            <div class="form-group">
                <div class="input-group">
                    <label class="input-group-addon" for="email"><i class="fa fa-envelope"></i></label>
                    <input type="email" id="email" name="email" placeholder="example@exp.com" value="{{old('email')}}" class="form-control" required>
                </div>
              </div> 
             
            {{ csrf_field() }}
              <button type="submit" class="btn btn-primary pull-right">Send Password</button>
            
        </form>
    </div>
</div>
@endsection