@extends('backend.layouts.backend-master')

@section('title')
   Add Product
@endsection

@section('content')
        <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
          <h1 class="page-header">Add Product</h1>
            <div class="col-sm-9 col-sm-offset-1 col-md-6 col-md-offset-1">
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
         
            <form action="{{route('dashboard.postproduct')}}" method="post" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="title">Ad Name:</label>
                    <input type="text" id="title" name="title" class="form-control" value="{{old('title')}}" required>
                </div>
                <div class="form-group">
                    <label for="price">Ad Price:</label>
                    <input type="text" id="price" name="price" class="form-control" value="{{old('price')}}" required>
                </div>
                <div class="form-group">
                    <label for="location">Location:</label>
                    <input type="text" id="location" name="location" value="{{old('location')}}" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="ad-state">State:</label>
                    <input type="text" id="state" name="state" value="{{old('state')}}" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="city">City:</label>
                    <input type="text" id="city" name="city" value="{{old('city')}}" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="imagepath ">Ad Image:</label>
                    <input type="file" id="imagepath" name="imagepath" value="{{old('image')}}" class="form-control" required>
                </div>
                
                <div class="form-group">
                    <label for="sel1">Select Media Type:</label>
                    <select class="form-control" name="mediatype_id" id="mediatype" required="required">
                        <option value="">--Select--</option>
                        @foreach( $categories as $category)
                        <option data-name="{{strtolower(str_replace(' ', '-', $category->title))}}" value="{{$category->id}}">{{$category->title}}</option>
                        @endforeach
                    
                    </select>
                </div>
                <div class="panel panel-primary results">
                    
                </div>
                <div class="form-group">
                    <label for="rank">City Rank:</label>
                    <input type="text" id="rank" name="rank" value="{{old('rank')}}" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="landmark">Landmark:</label>
                    <input type="text" id="landmark" name="landmark" value="{{old('landmark')}}" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="description">Description:</label>
                    <textarea id="description" name="description" class="form-control">{{old('description')}}</textarea>
                </div>
                
                <div class="form-group">
                    <label for="reference">Other Reference:</label>
                    <textarea id="reference" name="reference" class="form-control">{{old('reference')}}</textarea>
                </div>
                @PHP
                    $ad_status = array( 1 => 'Available', 2 => 'Sold Out', 3 => 'Coming Soon');
                @ENDPHP
                <div class="form-group">
                    <label for="status">Ad Status:</label>
                    <select class="form-control" name="status" id="status" required="required">
                        <option value="">--Select--</option>
                        @foreach( $ad_status as $key => $value )
                        <option value="{{$key}}">{{$value}}</option>
                        @endforeach
                    
                    </select>
                </div>
               
                {{csrf_field()}}
               <button type="submit" class="btn btn-primary">Add Product</button>
                
            </form>
            </div>
            
        </div>
      
        
@endsection

@section('scripts')

<script>
    var CathtmlUrl = "{{route('dashboard.getproductvariationshtmlbycat')}}";
</script>

@endsection