
<div class="page-sidebar">
	<div class="col-md-12 filter-side">
		<div class="clear_filter">
    <a href="{{Request::url()}}" class="btn thb-fill-style">Clear All Filters</a>
    </div>
		<hr>
		<div class="filter-box">
      <form id="shoppingmall-filter" class="filterform">
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
           <a data-toggle="collapse" href="#collapse2"> <h4 class="panel-title"><span class="fa fa-caret-right g-side" aria-hidden="true"></span> Top Location</h4></a>
          </div>
          <div class="panel-collapse collapse in" id="collapse2">
            <div class="panel-body">
              <ul class="list-group">
                @foreach ($filter_location as $f_location) 
                <?php $loc_class= strtolower(str_replace(' ','_',$f_location->location)); ?>
                  <li class="list-group-item"><label class="shoppingmall"><input type="radio" class="adfilter" data-value="{{$loc_class}}" value="{{$f_location->location}}" name="locationFilter"> &ensp;{{$f_location->location}}</label></li>
                @endforeach
              </ul>
            </div>
          </div>
        </div>

        <!-- panel3 -->

       
        <div class="panel panel-default panel-filter" id="panel3">
          <div class="panel-heading" >
           <a data-toggle="collapse" href="#collapse3"> <h4 class="panel-title"><span class="fa fa-caret-right g-side" aria-hidden="true"></span> Category</h4></a>
          </div>

          <div class="panel-collapse collapse in" id="collapse3">
            <div class="panel-body ">
              <ul class="list-group">
                <li class="list-group-item"><label class="shoppingmall"><input type="radio" class="adfilter" data-value="danglers" value="danglers" name="category"> &ensp;Danglers</label></li>
                <li class="list-group-item"><label class="shoppingmall"><input type="radio" class="adfilter" data-value="drop_down_banners" value="drop_down_banners" name="category"> &ensp;Drop Down banners</label></li>
                <li class="list-group-item"><label class="shoppingmall"><input type="radio" class="adfilter" data-value="signage" value="signage" name="category"> &ensp;Signage</label></li>
                 <li class="list-group-item"><label class="shoppingmall"><input type="radio" class="adfilter" data-value="pillar_branding" value="pillar_branding" name="category"> &ensp;Pillar Branding</label></li>
                <li class="list-group-item"><label class="shoppingmall"><input type="radio" class="adfilter" data-value="washroom_branding" value="washroom_branding" name="category"> &ensp;Washroom Branding</label></li>
                <li class="list-group-item"><label class="shoppingmall"><input type="radio" class="adfilter" data-value="wall_branding" value="wall_branding" name="category"> &ensp;Wall Branding</label></li>
                <li class="list-group-item"><label class="shoppingmall"><input type="radio" class="adfilter" data-value="popcorn_tub_branding" value="popcorn_tub_branding" name="category"> &ensp;Popcorn Tub Branding</label></li>
                <li class="list-group-item"><label class="shoppingmall"><input type="radio" class="adfilter" data-value="product_kiosk" value="product_kiosk" name="category"> &ensp;Product Kiosk</label></li>
                <li class="list-group-item"><label class="shoppingmall"><input type="radio" class="adfilter" data-value="standee" value="standee" name="category"> &ensp;Standee</label></li>
              </ul>
            </div>
          </div>
        </div>
      </div>
      </form>
    </div>

	</div>
</div>
