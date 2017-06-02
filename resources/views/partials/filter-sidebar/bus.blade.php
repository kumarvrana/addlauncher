
<div class="page-sidebar">
	<div class="col-md-12 filter-side">
		<div class="clear_filter">
    <a href="{{Request::url()}}" class="btn thb-fill-style">Clear All Filters</a>
    </div>
		<hr>
		<div class="filter-box">
      <form id="bus-filter" class="filterform">
			<div class="panel-group">

        <!-- panel1  -->
         <div class="panel panel-default panel-filter" id="panel1">
          <div class="panel-heading" >
           <a data-toggle="collapse" href="#collapse1">  <h4 class="panel-title"><span class="fa fa-caret-right g-side" aria-hidden="true"></span> Price in Rupee</h4></a>
          </div>

          <div class="panel-collapse collapse in" id="collapse1">
            <div class="panel-body ">
              <div ng-app="rzSliderDemo">
                  <div ng-controller="MainCtrl" id="bus-nng" class="wrapper">
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
             <a data-toggle="collapse" href="#collapse2"><h4 class="panel-title"><span class="fa fa-caret-right g-side" aria-hidden="true"></span> Top Location</h4></a>
          </div>
          <div id="collapse2" class="panel-collapse collapse">
            <div class="panel-body">
              <ul class="list-group">

                @foreach ($filter_location as $f_location) 
                <?php $loc_class= strtolower(str_replace(' ','_',$f_location->location)); ?>
                  <li class="list-group-item"><label class="bus"><input type="radio" class="adfilter" data-value="{{$loc_class}}" value="{{$f_location->location}}" name="locationFilter"> &ensp;{{$f_location->location}}</label></li>
                @endforeach

              </ul>
            </div>
          </div>
        </div>

        <!-- panel3 -->

       
        <div class="panel panel-default panel-filter" id="panel3">
          <div class="panel-heading" >
             <a data-toggle="collapse" href="#collapse3"><h4 class="panel-title"><span class="fa fa-caret-right g-side" aria-hidden="true"></span> Category</h4></a>
          </div>

          <div class="panel-collapse collapse" id="collapse3">
            <div class="panel-body ">
              <ul class="list-group">
                <li class="list-group-item"><label class="bus"><input type="radio" class="adfilter" data-value="full" value="full" name="category"> &ensp;Full</label></li>
                <li class="list-group-item"><label class="bus"><input type="radio" class="adfilter" data-value="both_side" value="both_side" name="category"> &ensp;Both Side</label></li>
                <li class="list-group-item"><label class="bus"><input type="radio" class="adfilter" data-value="left_side" value="left_side" name="category"> &ensp;Left Side</label></li>
                <li class="list-group-item"><label class="bus"><input type="radio" class="adfilter" data-value="right_side" value="right_side" name="category"> &ensp;Right Side</label></li>
                <li class="list-group-item"><label class="bus"><input type="radio" class="adfilter" data-value="back_glass" value="back_glass" name="category"> &ensp;Back Glass</label></li>
                <li class="list-group-item"><label class="bus"><input type="radio" class="adfilter" data-value="internal_ceiling" value="internal_ceiling" name="category"> &ensp;Internal Ceiling</label></li>
                <li class="list-group-item"><label class="bus"><input type="radio" class="adfilter" data-value="bus_grab_handles" value="bus_grab_handles" name="category"> &ensp;Bus Grab Handles</label></li>
                <li class="list-group-item"><label class="bus"><input type="radio" class="adfilter" data-value="inside_billboards" value="inside_billboards" name="category"> &ensp;Inside Billboards</label></li>
              </ul>
            </div>
          </div>
        </div>
      </div>
      </form>
    </div>

	</div>
</div>
