@extends('backend.layouts.backend-master')

@section('title')
   Add Category List
@endsection

@section('content')
     <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
          <h1 class="page-header">Media Category</h1>
    <div class="row">
        <div class="col-md-3">
            <a href="{{route('dashboard.addCategory')}}" type="button" class="btn btn-success">Post New Ad Category <i class="fa fa-plus" aria-hidden="true"></i>
</a>
        </div>
    </div>
    <hr>
    <div class="panel panel-default">
        <!-- Default panel contents -->
        <div class="panel-heading"><strong>Add Category List</strong></div>

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
                <th>Image</th>
                <th>Actions</th>
            </tr>
            @if($categories)
                @foreach($categories as $category)
            <tr class="row-details">
            
                <td>{{$loop->iteration}}</td>
                <td>{{$category->title}}</td>
                <td>{{substr(strip_tags($category->description), 0, 100)}}</td>
                <td>
               
                    <img src="{{asset('images/'.$category->image)}}" alt="$category->title" width="50px" height="50px" class="img-responsive">
                
                </td>
                <td>
                    <div class="btn-group" role="group" aria-label="...">
                        <a type="button" href="{{route('dashboard.editcategory', ['edit' => $category->id])}}" class="btn btn-primary">Edit <i class="fa fa-pencil-square-o" aria-hidden="true"></i>
</a>
                        <a type="button" type="button" href="{{route('dashboard.getdeletecat', ['catID' => $category->id])}}" class="btn btn-danger">Delete <i class="fa fa-trash" aria-hidden="true"></i>
</a>
                     </div>
                </td>
                <td class="hidden"><input type="hidden" value="{{$category->id}}" id="category-id"></td>
            </tr>
            @endforeach
            @else
            <tr>ADD Category!!!</tr>
            @endif
           
            
        </table>
        
    </div>
    </div>
    <!--div class="modal fade" tabindex="-1" role="dialog" id="edit-ad-category">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Edit Add Category</h4>
            </div>
            <div class="modal-body">
                <form action="#" method="post" enctype="multipart/form-data" id="edit-form-ad-category">
                   
                    <div class="form-group">
                        <label for="description">Category Description:</label>
                        <textarea id="description" name="description" class="form-control"></textarea>
                    </div-->
                    <!--div class="form-group">
                        <label for="image">Category Image:</label>
                        <input name="image" id="image" type="file" class="form-control" required>
                    </div>
                   
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="update-cat-modal">Save changes</button>
            </div>
            </div--><!-- /.modal-content -->
        <!--/div--><!-- /.modal-dialog -->
    <!--/div--><!-- /.modal -->
@endsection

@section('scripts')
<script>
    //var updateCatUrl = "{{ route('dashboard.editcategory', ['edit' => $category->id]) }}";
</script>
@endsection