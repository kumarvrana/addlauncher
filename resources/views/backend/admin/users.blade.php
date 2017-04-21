@extends('backend.layouts.backend-master')

@section('title')
   Users | Ads Launcher
@endsection

@section('content')
   <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
          <h1 class="well text-center">Users List</h1>
        <div class="panel panel-primary">
        <!-- Default panel contents -->
        <div class="panel-heading"><strong>Recent 10 users</strong></div>
        
        
        <!-- Table -->
        <table class="table table-hover table-striped">
        <thead>
            <tr>
                <th>#</th>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Phone Number</th>
                <th>Email Id</th>
                <th>Total No. of Order</th>
                <th>Order History</th>
            </tr>
        </thead>   
            @foreach($users as $users)
            <tr>
                <td>{{$loop->iteration}}</td>
                <td>{{$users['first_name']}}</td>
                <td>{{$users['last_name']}}</td>
                <td>{{$users['phone_number']}}</td>
                <td>{{$users['email']}}</td>
                <td>{{count($users->orders)}}</td>
                <td><a href="{{route('history', ['id' => $users['id']])}}" class="btn btn-success">View Orders</a></td>
            </tr>
            @endforeach
        </table>
        </div>
        
      
    </div><!-- /.modal -->
@endsection