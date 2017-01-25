@extends('backend.layouts.backend-master')

@section('title')
   Product's List
@endsection

@section('content')
     <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
          <h1 class="page-header">Products List</h1>
    <div class="row">
        <!--div class="col-md-3">
            <a href="{{route('dashboard.addCategory')}}" type="button" class="btn btn-success">Post New Ad Category <i class="fa fa-plus" aria-hidden="true"></i>
</a>
        </div-->
    </div>
    <hr>
    <div class="panel panel-default">
        <!-- Default panel contents -->
        <div class="panel-heading"><strong>Products List</strong></div>

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
                <th>Price</th>
                <th>Category</th>
                <th>Location</th>
                <th>State</th>   
                <th>Rank</th>
                <th>Image</th>
                <th>Status</th>
                
                <th>Actions</th>
                
            </tr>
            @if($products)
                @foreach($products as $product)
            <tr class="row-details">
            
                <td>{{$loop->iteration}}</td>
                <td>{{$product->title}}</td>
                <td>{{$product->price}}</td>
                <td>{{$product->mediatype_id}}</td>
                <td>{{$product->location}}</td>
                <td>{{$product->state}}</td>
                <td>{{$product->rank}}</td>
                <td>
               
                    <img src="{{asset('images/'.$product->imagepath)}}" alt="{{$product->title}}" width="50px" height="50px" class="img-responsive">
                
                </td>
                @PHP
                    if($product->status){
                        switch($product->status){
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
                        <a type="button" href="{{route('dashboard.getEditproduct', ['productID' => $product->id])}}" class="btn btn-primary">Edit <i class="fa fa-pencil-square-o" aria-hidden="true"></i>
</a>
                        <a type="button" type="button" href="{{route('dashboard.getdeleteproduct', ['productID' => $product->id])}}" class="btn btn-danger">Delete <i class="fa fa-trash" aria-hidden="true"></i>
</a>
                     </div>
                </td>
                <td class="hidden"><input type="hidden" value="{{$product->id}}" id="category-id"></td>
            </tr>
            @endforeach
            @else
            <tr>ADD Category!!!</tr>
            @endif
           
            
        </table>
        
    </div>
    </div>
   
@endsection

@section('scripts')
<script>
   
</script>
@endsection