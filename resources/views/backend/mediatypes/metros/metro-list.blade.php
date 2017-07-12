@extends('backend.layouts.backend-master')

@section('title')
   Metro Ad List | Ad Launcher
@endsection

@section('content')
     <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
          <h1 class="page-header">Metro ads</h1>
    <div class="row">
        <div class="col-md-3">
            <a href="{{route('dashboard.getMetroForm')}}" type="button" class="btn btn-success">Add New Metro Ad <i class="fa fa-plus" aria-hidden="true"></i>
</a>
        </div>
    </div>
    <hr>
    <div classs="col-md-6">
    <form method='GET' action ='http://192.168.0.5/myshop/public/dashboard/cat/metro-list' class = 'navbar-form navbar-left pull-right' role='search'>
        <div class="input-group custom-search-form">
            <input type="text" name="search" class="form-control">
            <span class="input-group-btn">
                <button type="submit" class="btn btn-default-sm">
                    <i class="fa fa-search"></i>
                </button>
            </span>
        </div>
   </form>
    </div>
    <div class="panel panel-default">
        <!-- Default panel contents -->
        <div class="panel-heading"><strong>Metro Ad List</strong></div>

        @if(count($errors) > 0 )
            <div class="alert alert-danger">
                @foreach($errors->all() as $error)
                    <p>{{ $error }}</p>
                @endforeach
            </div>
        @endif
       @if(Session::has('message'))
            <div class="alert alert-success">
                <p>{{Session::get('message')}}</p>
            </div>
        @endif
              <!-- Table -->
        <table class="table">
            <tr>
                <th>S.NO</th>
                <th>Name</th>
                <th>Description</th>
                <th>Location</th>
                <th>City</th>
                <th>State</th>
                <th>Image</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
             @foreach($metro_ads as $metroad)
            <tr class="row-details">
            
                <td>{{$loop->iteration}}</td>
                <td>{{$metroad->metroline->label}}</td>
                <td>{{$metroad->station_name}}
                <td>{{$metroad->location}}</td>
                <td>{{$metroad->city}}</td>
                <td>{{$metroad->media}}</td>
                <td>
               
                    <img src="{{asset('images/metros/'.$metroad->image)}}" alt="{{$metroad->title}}" width="50px" height="50px" class="img-responsive">
                
                </td>
                @PHP
                    if($metroad->status){
                        switch($metroad->status){
                            case 1:
                                $status = 'Available';
                            break;
                            case 2:
                                $status = 'Sold Out';
                            break;
                            case 3:
                                $status = 'Coming Soon';
                            break;
                        }
                    }
                @ENDPHP
                <td>{{$status}}</td>
                <td>
                    <div class="btn-group" role="group" aria-label="...">
                        <a type="button" href="{{route('dashboard.editmetrosad', ['metroadID' => $metroad->id])}}" class="btn btn-primary">Edit <i class="fa fa-pencil-square-o" aria-hidden="true"></i>
</a>
                        <a type="button" type="button" href="{{route('dashboard.deleteMetroad', ['metroadID' => $metroad->id])}}" class="btn btn-danger">Delete <i class="fa fa-trash" aria-hidden="true"></i>
</a>
                     </div>
                </td>
                
            </tr>
            @endforeach
           
            
        </table>
        
    </div>
    {{$metro_ads->links()}}
    </div>
    
@endsection

@section('scripts')

@endsection