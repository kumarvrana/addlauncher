
<div class="page-sidebar">
	<div class="col-md-12 filter-side">
		<div class="clear_filter">
    <a href="{{Request::url()}}" class="btn thb-fill-style">Clear All Filters</a>
    </div>
		<hr>
		<div class="filter-box">
      <form id="auto-filter" class="filterform">
			<div class="panel-group">

        <!-- panel1  -->
        <div class="panel panel-default panel-filter" id="panel1">
          <div class="panel-heading" >
           <a data-toggle="collapse" href="#collapse1">  <h4 class="panel-title"><span class="fa fa-caret-right g-side" aria-hidden="true"></span> Price in Rupee</h4></a>
          </div>

          <div class="panel-collapse collapse in" id="collapse1">
            <div class="panel-body ">
              <div ng-app="rzSliderDemo">
                  <div ng-controller="MainCtrl" id="auto-nng" class="wrapper">
                    <article>
                    
                      <input type="hidden" value="@{{minRangeSlider.minValue}}" name="minpricerange" ng-model="minRangeSlider.minValue" />
                      
                      <input type="hidden" value="@{{minRangeSlider.maxValue}}" name="maxpricerange" ng-model="minRangeSlider.maxValue" />
                     
                      <rzslider class="adfilter" name="pricerange" rz-slider-model="minRangeSlider.minValue" rz-slider-high="minRangeSlider.maxValue" rz-slider-options="minRangeSlider.options"></rzslider>
                    </article>
                    
                  </div>
                  
                </div>
            </div>
          </div>
        </div>

        <!-- panel2 -->

        <div class="panel panel-default panel-filter" id="panel2">
          <div class="panel-heading" >
           <a data-toggle="collapse" href="#collapse2">  <h4 class="panel-title"><span class="fa fa-caret-right g-side" aria-hidden="true"></span> Top Location</h4></a>
          </div>
          <div class="panel-collapse collapse in" id="collapse2">
            <div class="panel-body">
              <ul class="list-group">
                @foreach ($filter_location as $f_location) 
                <?php $loc_class= strtolower(str_replace(' ','_',$f_location->location)); ?>
                  <li class="list-group-item"><label class="auto"><input type="radio" class="adfilter" data-value="{{$loc_class}}" value="{{$f_location->location}}" name="locationFilter"> &ensp;{{$f_location->location}}</label></li>
                @endforeach
              </ul>
            </div>
          </div>
        </div>

        <!-- panel3 -->

        @if($autotype=='auto_rikshaw')
       
        <div class="panel panel-default panel-filter" id="panel3">
          <div class="panel-heading" >
           <a data-toggle="collapse" href="#collapse3">  <h4 class="panel-title"><span class="fa fa-caret-right g-side" aria-hidden="true"></span> Ad Type</h4></a>
          </div>

          <div class="panel-collapse collapse in" id="collapse3">
            <div class="panel-body ">
              <ul class="list-group">
                <li class="list-group-item"><label class="auto"><input type="radio" class="adfilter" data-value="sticker" value="sticker" name="category"> &ensp;Sticker</label></li>
                <li class="list-group-item"><label class="auto"><input type="radio" class="adfilter" data-value="auto_hood" value="auto_hood" name="category"> &ensp;Auto Hood</label></li>
                <li class="list-group-item"><label class="auto"><input type="radio" class="adfilter" data-value="backboard" value="backboard" name="category"> &ensp;Backboard</label></li>
                <li class="list-group-item"><label class="auto"><input type="radio" class="adfilter" data-value="full_auto" value="full_auto" name="category"> &ensp;Full Auto</label></li>
                <li class="list-group-item"></li>
              </ul>
            </div>
          </div>
        </div>
  
        @elseif ($autotype=='e_rikshaw')

        <div class="panel panel-default panel-filter" id="panel3">
           <div class="panel-heading" >
          <a data-toggle="collapse" href="#collapse4">  <h4 class="panel-title"><span class="fa fa-caret-right g-side" aria-hidden="true"></span> Ad Type</h4></a>
          </div>

          <div class="panel-collapse collapse in" id="collapse4">
            <div class="panel-body ">
              <ul class="list-group">
                <li class="list-group-item"><label class="auto"><input type="radio" class="adfilter" data-value="back_board" value="back_board" name="category"> &ensp;Back Board</label></li>
                <li class="list-group-item"><label class="auto"><input type="radio" class="adfilter" data-value="stepney_tier" value="stepney_tier" name="category"> &ensp;Stepney Tier</label></li>
                <li class="list-group-item"></li>
              </ul>
            </div>
          </div>
        </div>


        @endif

      </div>
      </form>
    </div>

	</div>
</div>
