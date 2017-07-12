@extends('backend.layouts.backend-master')

@section('title')
   Add Metro | Ad Launcher
@endsection

@section('content')
    <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
          <h1 class="page-header">Metro Add Form</h1>
   
        <div class="progress">
  <div class="progress-bar progress-bar-striped active" role="progressbar" aria-valuemin="0" aria-valuemax="100">
</div>
    </div>
    <hr>
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
  <form class="form" action="{{route('dashboard.postMetroForm')}}" method="post" enctype="multipart/form-data">
        <div class="step">
            <div class="step-header">General Options</div>
            <div class="form-group">
                <label for="metroline_id">Metro Line:</label>
                <select class="form-control" name="metroline_id" required>
                    <option value="">--Metro line--</option>
                    @foreach($metro_line as $line)
                    <option value="{{$line->id}}">{{$line->line}}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="station_name">Station Name:</label>
                <input type="text" id="station_name" name="station_name" class="form-control" placeholder="station name" value="{{old('station_name')}}" required>
            </div>
            <div class="form-group">
                <label for="location">Location:</label>
                <input type="text" id="location" name="location" class="form-control" value="{{old('location')}}" placeholder="location" required>
            </div>
            <div class="form-group">
                <label for="media">Media:</label>
                <input type="text" id="media" name="media" placeholder="media" value="{{old('media')}}" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="city">City:</label>
                <input type="text" id="city" name="city" placeholder="example: Mumbai" value="{{old('city')}}" class="form-control" required>
            </div>

            <div class="form-group">
                <div class="row">
                    <div class="col-sm-6">
                        <label for="units">Unit(s):</label>
                        <input type="number" min="1" max="10" id="units" name="units" placeholder="units" value="{{old('units')}}" class="form-control" required>
                    </div>
                    <div class="col-sm-6">
                        <label for="faces">Face(s):</label>
                        <input type="number" min="1" max="10" id="faces" name="faces" placeholder="faces" value="{{old('faces')}}" class="form-control">
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="row">
                    <div class="col-sm-4">
                        <label for="width">Width(in ft.):</label>
                        <input type="text" id="width" name="width" class="form-control" value="{{old('width')}}" placeholder="" required>
                    </div>
                    <div class="col-sm-4">
                        <label for="height">Height(in ft.):</label>
                        <input type="text" id="height" name="height" class="form-control" value="{{old('height')}}" placeholder="" required> 
                    </div>
                    <div class="col-sm-4">
                        <label for="area">Total Area (SQ Ft):</label>
                        <input type="text" id="area" name="area" class="form-control" value="{{old('area')}}" placeholder="" required>
                    </div>
                </div>
            </div>
             <div class="form-group">
                <div class="row">
                    <div class="col-sm-6">
                        <label for="price">Price:</label>
                        <input type="text" id="price" name="price" placeholder="Price" value="{{old('price')}}" class="form-control" required>
                    </div>
                    <div class="col-sm-6">
                        <label for="discount_price">Discounted Price:</label>
                        <input type="text" id="discount_price" name="discount_price" placeholder="Discounted Price" value="{{old('discount_price')}}" class="form-control" required>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label for="description">Description:</label>
                <textarea id="description" name="description" class="form-control">{{old('description')}}</textarea>
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

        </div>
        <div class="step">
            <div class="step-header">Image and References Options</div>
            <div class="form-group">
                <label for="image">Ad Image:</label>
                <input type="file" id="image" name="image" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="reference_mail">Reference mail:</label>
                <input type="email" id="reference_mail" name="reference_mail" value="{{old('reference_mail')}}" class="form-control" required>
            </div>
            <div class="form-group">
                    <label for="reference">Other Reference:</label>
                    <textarea id="reference" name="reference" class="form-control">{{old('reference')}}</textarea>
            </div>
            <div class="form-group">
                <label for="ad_code">Ad Code:</label>
                <input type="text" id="ad_code" name="ad_code" placeholder="Ad Code" value="{{old('ad_code')}}" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="source">Source:</label>
                <input type="text" id="source" name="source" placeholder="source" value="{{old('source')}}" class="form-control" required>
            </div>
        </div>
        {{csrf_field()}}
        
        <button type="button" class="action back btn btn-info">Back</button>
        <button type="button" class="action next btn btn-info">Next</button>
        <button type="submit" class="action submit btn btn-success">Add Metro</button>    
    </form>
   
   </div>
@endsection

@section('scripts')
<script src={{URL::to('js/multistep-form.js')}}></script>
@endsection