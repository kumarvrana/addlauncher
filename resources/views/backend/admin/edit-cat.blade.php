@extends('backend.layouts.backend-master')

@section('title')
   Edit Category
@endsection

@section('content')
    <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
          <h1 class="page-header">Edit Media Category</h1>
       
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
        <form action="{{route('dashboard.updatecategory', ['editcatid' => $categorycontent->id])}}" method="post" enctype="multipart/form-data">
       
        
            <div class="form-group">
                <label for="title">Category Name:</label>
                <input type="text" id="category-name" name="title"class="form-control" value="{{$categorycontent->title}}" required>
            </div>
            <div class="form-group">
                <label for="description">Category Description:</label>
                <textarea name="description" class="form-control">{{$categorycontent->description}}</textarea>
            </div>
            <div class="form-group">
                <label for="image">Category Image:</label>
                <input name="image" type="file" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary">Edit Category</button>
            {{ csrf_field() }}
        </form>
    </div>


@endsection