@extends('backend.layouts.backend-master')

@section('title')
   Add Print Media | Ad Launcher
@endsection

@section('content')
    <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
          <h1 class="page-header">Print Media Add Form</h1>
   
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
  <form class="form" action="{{route('dashboard.postNewspaperForm')}}" method="post" enctype="multipart/form-data">
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
 
            <div class="step-header">Newspaper/Magazine General Options</div>
                <input type="hidden" name="modelname" id="modelname" value="Newspaper">

                                 
               
                <div class="panel panel-primary">
                    <div class="panel-heading "><h3 class="panel-title">Newspaper/Magazine General Options</h3></div>
                    <div class="panel-body">
                     <div class="form-group">
                         <label for="printmedia_type">Print Media Ad Type (Delhi):</label>
                            <select class="form-control" name="printmedia_type" id="printmedia_type" required="required">
                                <option value="">--Select--</option>
                                @foreach( $printMedia_type as $key => $value )
                                <option value="{{$key}}">{{$value}}</option>
                                @endforeach
                            </select>    
                    </div> 
                    <div class="form-group newspaper">
                        <label for="newspaperlist">News Paper List (Delhi):</label>
                        <select class="form-control" name="printmedia_name" id="newspaperlist" required="required">
                            <option value="">--Select--</option>
                            @foreach( $newspapers_list as $newspaper )
                            <option value="{{$newspaper->name}}">{{$newspaper->name}}</option>
                            @endforeach
                        </select>            
                    </div>
                    <div class="form-group magazine">
                        <label for="magazinelist">Magazines List (Delhi):</label>
                        <select class="form-control" name="printmedia_name" id="magazinelist" required="required">
                            <option value="">--Select--</option>
                            @foreach( $magazine_list as $magazine )
                            <option value="{{$magazine->name}}">{{$magazine->name}}</option>
                            @endforeach
                        </select>
                    </div> 
                    <div class="form-group magazine">
                        <label for="genre">Magazine Genres: </label>
                         @foreach($megazineGenre as $value)
                        <label class='checkbox-inline'><input data-label='Magazine Ad Genre Options' name='genre[]' type='checkbox' value={{$value}}>{{$value}}</label>
                        @endforeach
                   </div> 
                    
                    <div class="form-group">
                        <label for="circulation">Circulation: </label>
                        <input class="form-control" type="text" name="circulation" placeholder="Enter Circulation">
                    </div>

                    <div class="form-group">
                        <label for="language">Languages:</label>
                        <select class="form-control" name="language" id="language" required="">
                            <option value="">--Language--</option>
                            @foreach( $languages as $language )
                                <option value="{{$language->name}}">{{$language->name}}</option>
                            @endforeach
                        </select>
                    </div>

                
                    <div class="form-group magazine">
                        <label for="magazinedisplay">Magazine Display Options: </label>
                         @foreach($magezineOption as $key => $value)
                        <label class='checkbox-inline'><input data-label='Magazine Ad Display Options' onclick="addDomToPriceOptionsMegazine('{{$value}}',  'megazine')" name='magazinedisplay[]' type='checkbox' value={{$key}}>{{$value}}</label>
                        @endforeach
                   </div> 
                    
                    <div class="form-group newspaperOptions">
                        <label for="newspaperdisplay">Newspaper Display Options: </label>
                        @foreach($newspaper_options as $key => $value)
                        <label class='checkbox-inline'><input data-label='Newspaper Ad Display Options' onclick="addDomToPriceOptionsNewspaper('{{$value}}', 'newspaper')" name='newspaperdisplay[]' type='checkbox' value={{$key}}>{{$value}}</label>
                        @endforeach
                    </div>

                    <div class="form-group Times-of-India">
                        <label for="newspaperdisplay">Newspaper Display Options: </label>
                        @foreach($toiOptions as $key => $value)
                        <label class='checkbox-inline'><input data-label='Newspaper Ad Display Options' onclick="addDomToPriceOptionsNewspaper('{{$value}}', 'newspaper')" name='newspaperdisplay[]' type='checkbox' value={{$key}}>{{$value}}</label>
                        @endforeach
                    </div>  
                   
                    
                    <div class="form-group">
                        <label for="discount">Discount (%): </label>
                        <input class="form-control" type="text" name="discount" placeholder="put an integer value for discount like 5 or 10">
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
        <button type="submit" class="action submit btn btn-success">Add Print Media</button>    
    </form>
   
   </div>
@endsection

@section('scripts')
<script src={{URL::to('js/multistep-form.js')}}></script>
@endsection