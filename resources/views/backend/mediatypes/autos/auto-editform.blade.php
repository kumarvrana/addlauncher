@extends('backend.layouts.backend-master')

@section('title')
   Edit Auto | Ad Launcher
@endsection

@section('content')
    <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
          <h1 class="page-header">Auto Edit Form</h1>
   
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
  <form class="form" action="{{route('dashboard.Postautosad', ['ID' => $auto->id])}}" method="post" enctype="multipart/form-data">
        <div class="step">
            <div class="step-header">General Options</div>
            <div class="form-group">
                    <label for="title">Ad Name:</label>
                    <input type="text" id="title" name="title" class="form-control" placeholder="Name of the product" value="{{$auto->title}}" required>
                </div>
                <div class="form-group">
                    <label for="price">Ad Price:</label>
                    <input type="text" id="price" name="price" class="form-control" value="{{$auto->price}}" placeholder="Put Base price here eg: 1213" required>
                </div>
                <div class="form-group">
                    <label for="location">Location:</label>
                    <input type="text" id="location" name="location" placeholder="example: saket metro/ IGI Airport" value="{{$auto->location}}" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="city">City:</label>
                    <input type="text" id="city" name="city" placeholder="example: Mumbai" value="{{$auto->city}}" class="form-control" required>
                </div>

                <div class="form-group">
                    <label for="ad-state">State:</label>
                    <input type="text" id="state" name="state" placeholder="example: Maharashtra" value="{{$auto->state}}" class="form-control" required>
                </div>
                             
                <div class="form-group">
                    <label for="rank">City Rank:</label>
                    <input type="text" id="rank" name="rank" placeholder="example: (432) rank according to location" value="{{$auto->rank}}" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="landmark">Landmark:</label>
                    <input type="text" id="landmark" name="landmark" placeholder="example: near children park or opposite to city post office" value="{{$auto->landmark}}" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="description">Description:</label>
                    <textarea id="description" name="description" class="form-control">{{$auto->description}}</textarea>
                </div>
                
                
                @PHP
                    $ad_status = array( 1 => 'Available', 2 => 'Sold Out', 3 => 'Coming Soon');
                @ENDPHP
                <div class="form-group">
                    <label for="status">Ad Status:</label>
                    <select class="form-control" name="status" id="status" required="required">
                        <option value="">--Select--</option>
                        @foreach( $ad_status as $key => $value )
                        <option value="{{$key}}" @PHP if($auto->status == $value){
                            echo "Selected";
                        } @ENDPHP>{{$value}}</option>
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
                     $autodisplayData = unserialize($auto->autorikshaw_options);
                     $erikhshawData = unserialize($auto->erikshaw_options);


                @ENDPHP
                <div class="panel panel-primary">
                    <div class="panel-heading "><h3 class="panel-title">Auto Options</h3></div>
                    <div class="panel-body">
                    <div class="form-group">
                         <label for="autotype">Auto Type:</label>
                            <select class="form-control" name="autotype" id="autotype" required="required" disabled readonly>
                                <option value="">--Select--</option>
                                @foreach( $auto_type as $key => $value )
                                <option value="{{$key}}" @PHP if($auto->autotype == $key){
                            echo "Selected";
                        } @ENDPHP>{{$value}}</option>
                                @endforeach
                            
                            </select>
                                
                    </div> 

                    <div class="form-group autorikshawOtions">
                        <label for="autodisplay">Auto Rikshaw Ad Display Options: </label>
                             
                    @foreach($autorikshawOtions as $key => $value)
                        <label class='checkbox-inline'><input data-label='Auto Ad Display Options' onclick="addDomToPriceOptionsAuto('{{$value}}', 'autorikshaw_options')" name='autodisplay[]' type='checkbox'  @PHP if($autodisplayData){ if(in_array($key, $autodisplayData)){echo "checked"; } } @ENDPHP value={{$key}}>{{$value}}</label>
                    @endforeach
                                       
                    </div> 
                    
                    <div class="form-group e_rickshawOtions">

                   
                        <label for="erikshawdisplay">E Rikshaw Ad Display Options: </label>

                         @foreach($e_rickshawOtions as $key => $value)
                            <label class='checkbox-inline'><input data-label='erikshawdisplay' onclick="addDomToPriceOptionsAuto('{{$value}}', 'erikshaw_options')" name='erikshawdisplay[]' type='checkbox'  @PHP if($erikhshawData){ if(in_array($key, $erikhshawData)){echo "checked"; } } @ENDPHP value={{$key}}>{{$value}}</label>
                        @endforeach

                    </div>

               

                    <div class="form-group"><label for="bslighting">Do you want lighting options on Auto Panels?: </label><label class="checkbox-inline"><input class="checkEvent" data-label="Bus Shelter lighting options" onclick="addDomToPriceOptionsWithLight('No')" name="autolighting" type="radio" @PHP if($auto->light_option == 0) echo "checked"; @ENDPHP value="0">No</label><label class="checkbox-inline"><input class="checkEvent" data-label="Bus Shelter lighting options" onclick="addDomToPriceOptionsWithLight('Yes')" name="autolighting" type="radio" @PHP if($auto->light_option == 1) echo "checked"; @ENDPHP  value="1">Yes</label></div>



                    <div class="form-group">
                        <label for="autosnumber">Numbers Of Autos Display this Ad? : </label>
                        <input class="form-control" type="text" name="autosnumber" value="{{$auto->auto_number}}" required>
                    </div>
                    <div class="form-group">
                        <label for="autosnumber">Discount (%): </label>
                        <input class="form-control" type="text" name="autodiscount" placeholder="put an integer value for discount like 5 or 10" value="{{$auto->discount}}">
                    </div>
                    </div>
                </div>

                <div class="step-header">Pricing Options</div>
                    <div id="light-content" class="alert alert-info">
                                You have check the Light Options in ads. So, Please fill the Price including light charges in different the Ad display Size!
                        </div>
                    <div id="pricing-options-step">
                        <input type="hidden" id="priceData" value="{{json_encode(unserialize($fieldData))}}">
                        <input type="hidden" id="display_options" value="{{json_encode(unserialize($auto->display_options))}}">
                        <input type="hidden" id="front_pamphlets_reactanguler_options" value="{{json_encode(unserialize($auto->front_pamphlets_reactanguler_options))}}">
                        <input type="hidden" id="front_stickers_options" value="{{json_encode(unserialize($auto->front_stickers_options))}}">
                        <input type="hidden" id="hood_options" value="{{json_encode(unserialize($auto->hood_options))}}">
                        <input type="hidden" id="interior_options" value="{{json_encode(unserialize($auto->interior_options))}}">
                        <input type="hidden" id="uncheckID" value="{{$auto->id}}">
                        <input type="hidden" id="tablename" value="autos">
                        
                         @foreach($autopricemeta as $autoprice)
                         
                            <div id="p{{$autoprice->price_key}}" class="form-group">
                                <label for="{{$autoprice->price_key}}">Price for {{ucfirst(substr(str_replace("_", " ", $autoprice->price_key), 6))}} Auto Ad:</label>
                                <input class="form-control" type="text" name="{{$autoprice->price_key}}" value="{{$autoprice->price_value}}" required>
                            </div>
                            <div id="p{{$autoprice->number_key}}" class="form-group">
                                <label for="{{$autoprice->number_key}}">Number of {{ucfirst(substr(str_replace("_", " ", $autoprice->number_key), 7))}} Auto Ad:</label>
                                <input class="form-control" type="text" name="{{$autoprice->number_key}}" value="{{$autoprice->number_value}}" required>
                            </div>
                            <div id="p{{$autoprice->duration_key}}" class="form-group">
                                <label for="{{$autoprice->duration_key}}">Duration for {{ucfirst(substr(str_replace("_", " ", $autoprice->duration_key), 9))}} Auto Ad:</label>
                                <input class="form-control" type="text" name="{{$autoprice->duration_key}}" value="{{$autoprice->duration_value}}" required>
                            </div>
                        @endforeach
                    </div>

            </div>
        
        <div class="step">
            <div class="step-header">Image and References Options</div>
            <div class="form-group">
                <label for="image">Ad Image:</label>
                <input type="file" id="image" name="image" class="form-control">
            </div>
            <div class="form-group">
                <label for="reference_mail">Reference Mail:</label>
                <input type="email" id="reference_mail" name="reference_mail" value="{{$auto->reference_mail}}" class="form-control" required>
            </div>
            <div class="form-group">
                    <label for="reference">Other Reference:</label>
                    <textarea id="reference" name="reference" class="form-control">{{$auto->references}}</textarea>
                </div>
        </div>
        {{csrf_field()}}
        
        <button type="button" class="action back btn btn-info">Back</button>
        <button type="button" class="action next btn btn-info">Next</button>
        <button type="submit" class="action submit btn btn-success">Edit Auto</button>    
    </form>
   
   </div>
@endsection

@section('scripts')
<script>
    var uncheckDeleteURL = "{{route('dashboard.deleteUncheckPriceAuto')}}";
</script>
<script src={{URL::to('js/multistep-form.js')}}></script>
@endsection