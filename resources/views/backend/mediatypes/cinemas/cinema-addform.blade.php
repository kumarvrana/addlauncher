@extends('backend.layouts.backend-master')

@section('title')
   Add Cinema | Ad Launcher
@endsection

@section('content')
    <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
          <h1 class="page-header">Products Form</h1>
   
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
  <form class="form" action="{{route('dashboard.postCinemaForm')}}" method="post" enctype="multipart/form-data">
        <div class="step">
            <div class="step-header">General Options</div>
            <div class="form-group">
                    <label for="title">Ad Name:</label>
                    <input type="text" id="title" name="title" class="form-control" placeholder="Name of the product" value="{{old('title')}}" required>
                </div>
                <div class="form-group">
                    <label for="price">Ad Price:</label>
                    <input type="text" id="price" name="price" class="form-control" value="{{old('price')}}" placeholder="Put Base price here eg: 1213" required>
                </div>
                <div class="form-group">
                    <label for="location">Location:</label>
                    <input type="text" id="location" name="location" placeholder="example: saket metro/ IGI Airport" value="{{old('location')}}" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="city">City:</label>
                    <input type="text" id="city" name="city" placeholder="example: Mumbai" value="{{old('city')}}" class="form-control" required>
                </div>

                <div class="form-group">
                    <label for="ad-state">State:</label>
                    <input type="text" id="state" name="state" placeholder="example: Maharashtra" value="{{old('state')}}" class="form-control" required>
                </div>
                             
                <div class="form-group">
                    <label for="rank">City Rank:</label>
                    <input type="text" id="rank" name="rank" placeholder="example: (432) rank according to location" value="{{old('rank')}}" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="landmark">Landmark:</label>
                    <input type="text" id="landmark" name="landmark" placeholder="example: near children park or opposite to city post office" value="{{old('landmark')}}" class="form-control" required>
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

               
                
            <div class="step-header">Cinema Ad Options</div>
                <input type="hidden" name="modelname" id="modelname" value="Cinema">
               
                <div class="panel panel-primary">
                    <div class="panel-heading "><h3 class="panel-title">Cinema Options</h3></div><div class="panel-body">
                     <div class="form-group">
                         <label for="status">Cinema Category:</label>
                        <select class="form-control" name="cinemacategory" id="cinemacategory" required="required">
                            <option value="">--Select--</option>
                            @foreach( $cinema_category as $key => $value )
                            <option value="{{$key}}">{{$value}}</option>
                            @endforeach                        
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="cinemadisplay">Cinema Ads</label>
                             
                    @foreach($cinema_options as $key => $value)
                        <label class='checkbox-inline'><input data-label='cinema_options' onclick="addDomToPriceOptionsCinema('{{$value}}', 'cinema_options')" name='cinemadisplay[]' type='checkbox' value={{$key}}>{{$value}}</label>
                    @endforeach
                                       
                    </div> 
                   
                    <div class="form-group">
                         <label for="status">Other Ad Options In Cinema Halls:</label>
                            @foreach( $additionlsAds as $key => $value )
                             <label class='checkbox-inline'>
                                <input data-label='additionalsAds' onclick="addDomToPriceOptionsCinema('{{$value}}', 'cinema_options')" name='additionalsAds[]' type='checkbox' value={{$key}}>{{$value}}
                             </label>
                            @endforeach                        
                      
                    </div>
                    <div class="form-group">
                        <label for="audiseats">Numbers Of Seats in Audi? : </label>
                        <input class="form-control" type="text" name="audiseats" required>
                    </div>
                    <div class="form-group">
                        <label for="audinumber">Numbers Of Audi Display this Ad? : </label>
                        <input class="form-control" type="text" name="audinumber" required>
                    </div>
                    <div class="form-group">
                        <label for="cinemasnumber">Numbers Of Cinema Display this Ad? : </label>
                        <input class="form-control" type="text" name="cinemasnumber" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="cinemadiscount">Discount (%): </label>
                        <input class="form-control" type="text" name="cinemadiscount" placeholder="put an integer value for discount like 5 or 10">
                    </div>
                    </div>
                </div>

                <div class="step-header">Pricing Options</div>
                    <div id="light-content" class="alert alert-info">
                                You have check the Light Options in ads. So, Please fill the Price including light charges in different the Ad display Size!
                        </div>
                    <div id="pricing-options-step">
                        
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
        </div>
        {{csrf_field()}}
        
        <button type="button" class="action back btn btn-info">Back</button>
        <button type="button" class="action next btn btn-info">Next</button>
        <button type="submit" class="action submit btn btn-success">Add Cinema</button>    
    </form>
   
   </div>
@endsection

@section('scripts')
<script src={{URL::to('js/multistep-form.js')}}></script>
@endsection