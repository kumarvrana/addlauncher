@extends('backend.layouts.backend-master')

@section('title')
   Admin Panel
@endsection

@section('content')
   <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
          <h1 class="page-header">Dashboard</h1>
        <div class="panel panel-default">
        <!-- Default panel contents -->
        <div class="panel-heading">Users</div>
        <div class="panel-body">
            <p>Recent 10 users</p>
        </div>
        
        <!-- Table -->
        <table class="table">
            <tr>
                <th>#</th>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Email Id</th>
            </tr>
           
            @foreach($users as $users)
            <tr>
                <td>{{$loop->iteration}}</td>
                <td>{{$users['first_name']}}</td>
                <td>{{$users['last_name']}}</td>
                <td>{{$users['email']}}</td>
            </tr>
            @endforeach
        </table>
        </div>
        
      
    </div><!-- /.modal -->
@endsection