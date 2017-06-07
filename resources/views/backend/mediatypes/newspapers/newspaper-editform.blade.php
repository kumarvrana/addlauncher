@extends('backend.layouts.backend-master')

@section('title')
   Edit Print Media | Ad Launcher
@endsection

@section('content')
    <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
          <h1 class="page-header">Print Media Edit Form</h1>
   
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
            <?php //dd(unserialize($newspaper->genre)); ?>
  <form class="form" action="{{route('dashboard.Updatenewspapersad', ['ID' => $printmediaAd->id])}}" method="post" enctype="multipart/form-data">
		<div class="step">
            <div class="step-header">General Options</div>
            <div class="form-group">
                    <label for="title">Ad Name:</label>
                    <input type="text" id="title" name="title" class="form-control" placeholder="Name of the product" value="{{$printmediaAd->title}}" required>
                </div>
                <div class="form-group">
                    <label for="price">Ad Price:</label>
                    <input type="text" id="price" name="price" class="form-control" value="{{$printmediaAd->price}}" placeholder="Put Base price here eg: 1213" required>
                </div>
                <div class="form-group">
                    <label for="location">Location:</label>
                    <input type="text" id="location" name="location" placeholder="example: saket metro/ IGI Airport" value="{{$printmediaAd->location}}" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="city">City:</label>
                    <input type="text" id="city" name="city" placeholder="example: Mumbai" value="{{$printmediaAd->city}}" class="form-control" required>
                </div>

                <div class="form-group">
                    <label for="ad-state">State:</label>
                    <input type="text" id="state" name="state" placeholder="example: Maharashtra" value="{{$printmediaAd->state}}" class="form-control" required>
                </div>
                             
                <div class="form-group">
                    <label for="rank">City Rank:</label>
                    <input type="text" id="rank" name="rank" placeholder="example: (432) rank according to location" value="{{$printmediaAd->rank}}" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="landmark">Landmark:</label>
                    <input type="text" id="landmark" name="landmark" placeholder="example: near children park or opposite to city post office" value="{{$printmediaAd->landmark}}" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="description">Description:</label>
                    <textarea id="description" name="description" class="form-control">{{$printmediaAd->description}}</textarea>
                </div>
                
                
                @PHP
                    $ad_status = array( 1 => 'Available', 2 => 'Sold Out', 3 => 'Coming Soon');
                @ENDPHP
                <div class="form-group">
                    <label for="status">Ad Status:</label>
                    <select class="form-control" name="status" id="status" required="required">
                        <option value="">--Select--</option>
                        @foreach( $ad_status as $key => $value )
                        <option value="{{$key}}" @PHP if($printmediaAd->status == $key){
                            echo "Selected";
                        } @ENDPHP>{{$value}}</option>
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
                                <option <?php if($printmediaAd->printmedia_type === $key) echo ' selected '; ?>value="{{$key}}">{{$value}}</option>
                                @endforeach
                            </select>    
                    </div> 
                    <div class="form-group newspaper">
                    
                        <label for="newspaperlist">News Paper List (Delhi):</label>
                        <select class="form-control" name="printmedia_name" id="newspaperlist" required="required">
                            <option value="">--Select--</option>
                            @foreach( $newspapers_list as $newspaper )
                            <option <?php if($printmediaAd->printmedia_name === $newspaper->name) echo ' selected '; ?> value="{{$newspaper->name}}">{{$newspaper->name}}</option>
                            @endforeach
                        </select>            
                    </div>
                    <div class="form-group magazine">
                        <label for="magazinelist">Magazines List (Delhi):</label>
                        <select class="form-control" name="printmedia_name" id="magazinelist" required="required">
                            <option value="">--Select--</option>
                            @foreach( $magazine_list as $magazine )
                            <option <?php if($printmediaAd->printmedia_name === $magazine->name) echo ' selected '; ?> value="{{$magazine->name}}">{{$magazine->name}}</option>
                            @endforeach
                        </select>
                    </div> 
                    <div class="form-group magazine">
                    <?php $megazine_geree = unserialize($printmediaAd->genre);
                         $megazine_op = unserialize($printmediaAd->magazine_options);
                         $newspaper_op = unserialize($printmediaAd->general_options);
                    ?>
                   
                        <label for="genre">Magazine Genres: </label>
                         @foreach($megazineGenre as $value)
                        <label class='checkbox-inline'><input data-label='Magazine Ad Genre Options' <?php if($megazine_geree){ if(in_array($value,$megazine_geree)){ echo "checked "; }} ?> name='genre[]' type='checkbox' value={{$value}}>{{$value}}</label>
                        @endforeach
                   </div> 
                    
                    <div class="form-group">
                        <label for="circulation">Circulation: </label>
                        <input class="form-control" type="text" name="circulation" value="{{$printmediaAd->circulations}}"" placeholder="Enter Circulation">
                    </div>

                    <div class="form-group">
                        <label for="language">Languages:</label>
                        <select class="form-control" name="language" id="language" required="">
                            <option value="">--Language--</option>
                            @foreach( $languages as $language )
                                <option <?php if($printmediaAd->language === $language->name) echo ' selected '; ?> value="{{$language->name}}">{{$language->name}}</option>
                            @endforeach
                        </select>
                    </div>

                
                    <div class="form-group magazine">
                        <label for="magazinedisplay">Magazine Display Options: </label>
                         @foreach($magezineOption as $key => $value)
                        <label class='checkbox-inline'><input data-label='Magazine Ad Display Options' <?php if($megazine_op){ if(in_array($key,$megazine_op)){ echo "checked "; }} ?>  onclick="addDomToPriceOptionsMegazine('{{$value}}',  'megazine')" name='magazinedisplay[]' type='checkbox' value={{$key}}>{{$value}}</label>
                        @endforeach
                   </div> 
                    
                    <div class="form-group newspaperOptions">
                        <label for="newspaperdisplay">Newspaper Display Options: </label>
                        @foreach($newspaper_options as $key => $value)
                        <label class='checkbox-inline'><input data-label='Newspaper Ad Display Options' <?php if($newspaper_op){ if(in_array($key,$newspaper_op)){ echo "checked "; }} ?>  onclick="addDomToPriceOptionsNewspaper('{{$value}}', 'newspaper')" name='newspaperdisplay[]' type='checkbox' value={{$key}}>{{$value}}</label>
                        @endforeach
                    </div>

                    <div class="form-group Times-of-India">
                        <label for="newspaperdisplay">Newspaper Display Options: </label>
                        @foreach($toiOptions as $key => $value)
                        <label class='checkbox-inline'><input data-label='Newspaper Ad Display Options' <?php if($newspaper_op){ if(in_array($key,$newspaper_op)){ echo "checked "; }} ?>  onclick="addDomToPriceOptionsNewspaper('{{$value}}', 'newspaper')" name='newspaperdisplay[]' type='checkbox' value={{$key}}>{{$value}}</label>
                        @endforeach
                    </div>  
                   
                    
                    <div class="form-group">
                        <label for="discount">Discount (%): </label>
                        <input class="form-control" type="text" name="discount" value="{{$printmediaAd->discount}}" placeholder="put an integer value for discount like 5 or 10">
                    </div>
                    </div>
                </div>

                <div class="step-header">Pricing Options</div>
                  
                    <div id="pricing-options-step">
                        <input type="hidden" id="priceData" value="{{json_encode(unserialize($fieldData))}}">
                        <input type="hidden" id="uncheckID" value="{{$printmediaAd->id}}">
                        <input type="hidden" id="tablename" value="newspapers">
                        <?php if($printType === 'magazine'){
                        foreach($pricemeta as $data){
                            $mainKey = substr($data->price_key, 6);
                        ?>
                            <div class="form-group" id="p{{$data->price_key}}">
                                <label for="{{$data->price_key}}">Price for {{ucwords(str_replace('_', ' ', substr($data->price_key, 6)))}} Megazine Ad Per unit:</label>
                                <input type="text" name="{{$data->price_key}}" class="form-control" id="{{$data->price_key}}" value="{{$data->price_value}}" required="required" placeholder="put value as number eg: 35345">
                            </div>
                            <div class="form-group" id="pnumber_{{$mainKey}}">
                                <label for="number_{{$mainKey}}">Number of Times Megazine print {{ucwords(str_replace('_', ' ', substr($data->price_key, 6)))}} Ad(in 1 month):</label>
                                <input type="text" name="number_{{$mainKey}}" class="form-control" value="{{$data->number_value}}" id="number_{{$mainKey}}" required="required" placeholder="How many times this megazine print in a month eg: 1">
                            </div>
                        <?php } 
                            }else{ 
                            foreach($pricemeta as $data){ 
                                $mainKey = substr($data->price_key, 6);
                            
                        ?>
                            <div class="form-group" id="pbase_price_{{$mainKey}}">
                                <label for="base_price_{{$mainKey}}">Base Price for {{ucwords($mainKey)}} Newspaper Ad:</label>
                                <input type="text" name="base_price_{{$mainKey}}" class="form-control" id="base_price_{{$mainKey}}" value="{{$data->base_price}}" required="required" placeholder="base price eg: 35345">
                            </div>
                            <div class="form-group" id="padd_on_price_{{$mainKey}}">
                                <label for="add_on_price_{{$mainKey}}">Add-on Price for {{ucwords($mainKey)}} Newspaper Ad:</label>
                                <input type="text" name="add_on_price_{{$mainKey}}" class="form-control" value="{{$data->addon_price}}" id="add_on_price_{{$mainKey}}" required="required" placeholder="Add on eg: 35345">
                            </div>
                            <div class="form-group" id="ptotal_price_{{$mainKey}}">
                                <label for="total_price_{{$mainKey}}">Total Price for {{ucwords($mainKey)}} Newspaper Ad:</label>
                                <input type="text" name="total_price_{{$mainKey}}" value="{{$data->total_price}}" class="form-control" id="total_price_{{$mainKey}}" required="required" placeholder="total price eg: 35345">
                            </div>
                            <div class="form-group" id="pgenre_{{$mainKey}}">
                                <label for="genre_{{$mainKey}}">Select Ad Genre: </label>
                                <select name="genre_{{$mainKey}}" class="form-control" id="genre_{{$mainKey}}" required="required">
                                    <?php foreach($classified_options as $key=>$value) { ?>
                                    <option <?php if($data->genre){ if($data->genre === $key){ echo " Selected "; } }?> value="{{$key}}">{{$value}}</option>
                                    <?php } ?>
                                </select>
                            </div>
                            <?php $printingType = array('sq cm', 'column', 'insert', 'day'); ?>
                            <div class="form-group" id="prate_{{$mainKey}}">
                                <label for="rate_{{$mainKey}}">Select printing Options: </label>
                                <select name="rate_{{$mainKey}}" class="form-control" id="rate_{{$mainKey}}" required="required">
                                <?php foreach($printingType as $print) { ?>
                                    <option <?php if($data->pricing_type){ if($data->pricing_type === $print){ echo " Selected "; } }?> value="{{$print}}">{{$print}}</option>
                                <?php } ?>
                                </select>
                            </div>
                            <div class="form-group" id="pcolor_{{$mainKey}}">
                                <label for="color_{{$mainKey}}">Select Color Ad Or not:</label>
                                <select name="color_{{$mainKey}}" class="form-control" id="color_{{$mainKey}}" required="required">
                                    <option <?php if($data->color){ if($data->color == 0){ echo " Selected "; } }?> value="0">NO</option>
                                    <option <?php if($data->color){ if($data->color == 1){ echo " Selected "; } }?> value="1">YES</option>
                                </select>
                            </div>
                        <?php } } ?>
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
                <input type="email" id="reference_mail" name="reference_mail" value="{{$printmediaAd->reference_mail}}" class="form-control" required>
            </div>
            <div class="form-group">
                    <label for="reference">Other Reference:</label>
                    <textarea id="reference" name="reference" class="form-control">{{$printmediaAd->references}}</textarea>
                </div>
        </div>
        {{csrf_field()}}
		
		<button type="button" class="action back btn btn-info">Back</button>
		<button type="button" class="action next btn btn-info">Next</button>
		<button type="submit" class="action submit btn btn-success">Edit Print Media</button>	
  	</form>
   
   </div>
@endsection

@section('scripts')
<script>
    var uncheckDeleteURL = "{{route('dashboard.deleteUncheckPrice', ['table' => 'Newspaper'])}}";
</script>
<script src={{URL::to('js/multistep-form.js')}}></script>
@endsection