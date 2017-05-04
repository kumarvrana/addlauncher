@extends('backend.layouts.backend-master')

@section('title')
   Television Ad List | Ad Launcher
@endsection

@section('content')
     <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
          <h1 class="page-header">Television ads</h1>
    <div class="row">
        <div class="col-md-3">
            <a href="{{route('dashboard.getTelevisionForm')}}" type="button" class="btn btn-success">Add New Television Ad <i class="fa fa-plus" aria-hidden="true"></i>
</a>
        </div>
    </div>
    <hr>
    <div class="panel panel-default">
        <!-- Default panel contents -->
        <div class="panel-heading"><strong>Television Ad List</strong></div>

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
                <th>Genre</th>
                <th>Description</th>
                <th>Location</th>
                <th>City</th>
                <th>State</th>
                <th>Image</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        
            @foreach($television_ads as $televisionad)
            <tr class="row-details">
            
                <td>{{$loop->iteration}}</td>
                <td>{{$televisionad->title}}</td>
                <td>{{$televisionad->genre}}</td>
                <td>{{substr(strip_tags($televisionad->description), 0, 100)}}
                <td>{{$televisionad->location}}</td>
                <td>{{$televisionad->city}}</td>
                <td>{{$televisionad->state}}</td>
                <td>
               
                    <img src="{{asset('images/televisions/'.$televisionad->image)}}" alt="{{$televisionad->title}}" width="50px" height="50px" class="img-responsive">
                
            </td>
                @PHP
                    if($televisionad->status){
                        switch($televisionad->status){
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
                        <a type="button" href="{{route('dashboard.edittelevisionsad', ['ID' => $televisionad->id])}}" class="btn btn-primary">Edit <i class="fa fa-pencil-square-o" aria-hidden="true"></i>
                        </a>
                        <a type="button" type="button" href="{{route('dashboard.deleteTelevisionad', ['televisionadID' => $televisionad->id])}}" class="btn btn-danger">Delete <i class="fa fa-trash" aria-hidden="true"></i>
                        </a>
                     </div>
                </td>
                
            </tr>
            @endforeach
             
           
            
        </table>
        
    </div>
    </div>
    
@endsection

@section('scripts')

@endsection