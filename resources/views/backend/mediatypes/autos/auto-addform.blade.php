@extends('backend.layouts.backend-master')

@section('title')
   Add Auto | Ad Launcher
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
  <form class="form" action="{{route('dashboard.postAutoForm')}}" method="post" enctype="multipart/form-data">
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

               
                
            <div class="step-header">Auto Display Options</div>
                <input type="hidden" name="modelname" id="modelname" value="Auto">
                @PHP
                    $auto_type = array('auto_rikshaw' => 'Auto Rikshaw', 'e_rikshaw' => 'E Rikshaw', 'tricycle' => 'Tricycle');
                    $autorikshawOtions = array('sticker' => 'Sticker', 'auto_hood' => 'Auto Hood', 'backboard' => 'Backboard', 'full_auto' => 'Full Auto');
                    $e_rickshawOtions = array('back_board' => 'Back Board', 'stepney_tier' => 'Stepney Tier');
                    
                @ENDPHP
                <div class="panel panel-primary">
                    <div class="panel-heading "><h3 class="panel-title">Auto Options</h3></div><div class="panel-body">
                    <div class="form-group">
                         <label for="autotype">Auto Type:</label>
                            <select class="form-control" name="autotype" id="autotype" required="required">
                                <option value="">--Select--</option>
                                @foreach( $auto_type as $key => $value )
                                <option value="{{$key}}">{{$value}}</option>
                                @endforeach
                            
                            </select>
                                
                    </div> 
                    <div class="form-group autorikshawOtions">
                        <label for="autodisplay">Auto Rikshaw Ad Display Options: </label>
                             
                    @foreach($autorikshawOtions as $key => $value)
                        <label class='checkbox-inline'><input data-label='Auto Ad Display Options' onclick="addDomToPriceOptionsAuto('{{$value}}', 'autorikshaw_options')" name='autodisplay[]' type='checkbox' value={{$key}}>{{$value}}</label>
                    @endforeach
                                       
                    </div> 

                    <div class="form-group e_rickshawOtions">

                   
                        <label for="erikshawdisplay">E Rikshaw Ad Display Options: </label>

                         @foreach($e_rickshawOtions as $key => $value)
                            <label class='checkbox-inline'><input data-label='erikshawdisplay' onclick="addDomToPriceOptionsAuto('{{$value}}', 'erikshaw_options')" name='erikshawdisplay[]' type='checkbox' value={{$key}}>{{$value}}</label>
                        @endforeach

                    </div>
 

                    <div class="form-group"><label for="bslighting">Do you want lighting options on Auto Panels?: </label><label class="checkbox-inline"><input class="checkEvent" data-label="Bus Shelter lighting options" onclick="addDomToPriceOptionsWithLight('No')" name="autolighting" type="radio" value="0">No</label><label class="checkbox-inline"><input class="checkEvent" data-label="Bus Shelter lighting options" onclick="addDomToPriceOptionsWithLight('Yes')" name="autolighting" type="radio" value="1">Yes</label></div>
                    <div class="form-group">
                        <label for="busesnumber">Numbers Of Auto Display this Ad? : </label>
                        <input class="form-control" type="text" name="autosnumber" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="busesnumber">Discount (%): </label>
                        <input class="form-control" type="text" name="autodiscount" placeholder="put an integer value for discount like 5 or 10">
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
                    <label for="reference">Other Reference:</label>
                    <textarea id="reference" name="reference" class="form-control">{{old('reference')}}</textarea>
                </div>
        </div>
        {{csrf_field()}}
        
        <button type="button" class="action back btn btn-info">Back</button>
        <button type="button" class="action next btn btn-info">Next</button>
        <button type="submit" class="action submit btn btn-success">Add Auto</button>    
    </form>
   
   </div>
@endsection

@section('scripts')
<script src={{URL::to('js/multistep-form.js')}}></script>
@endsection