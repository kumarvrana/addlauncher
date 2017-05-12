
<div class="page-sidebar">
	<div class="col-md-12 filter-side">
		<h3 class="text-center refine">Refine Your Search</h3>
			
		<a href="{{Request::url()}}" class="btn btn-primary btn-block">Clear All Filters</a>
		<hr>
		<div class="filter-box">
      <form id="shoppingmall-filter">
			<div class="panel-group">

        <!-- panel1  -->
        <div class="panel panel-default panel-filter" id="panel1">
          <div class="panel-heading" >
            <h4 class="panel-title"><span class="glyphicon g-side glyphicon-minus" aria-hidden="true"></span> Price in Rupee</h4>
          </div>

          <div class="">
            <div class="panel-body ">
              <ul class="list-group">
                <li class="list-group-item "><label class="shoppingmall"><input type="radio" class="adfilter" data-value="<=10000" value="<=10000" name="pricerange"> &ensp;< 10,000</label></li>
                <li class="list-group-item"><label class="shoppingmall"><input type="radio" class="adfilter" data-value="10000<>50000" value="10000<>50000" name="pricerange"> &ensp;10,001 to 50,000</label></li>
                <li class="list-group-item"><label class="shoppingmall"><input type="radio" class="adfilter" data-value=">50000" value=">50000" name="pricerange"> &ensp;> 50,000</label></li>
                <li class="list-group-item"></li>
              </ul>
            </div>
          </div>
        </div>

        <!-- panel2 -->

        <div class="panel panel-default panel-filter" id="panel2">
          <div class="panel-heading" >
            <h4 class="panel-title"><span class="glyphicon g-side glyphicon-minus" aria-hidden="true"></span> Top Location in Delhi NCR</h4>
          </div>
          <div id="collapse2" class="">
            <div class="panel-body">
              <ul class="list-group">
                <li class="list-group-item"><label class="shoppingmall"><input type="radio" class="adfilter" data-value="east_delhi" value="East Delhi" name="locationFilter"> &ensp;East Delhi</label></li>
                <li class="list-group-item"><label class="shoppingmall"><input type="radio" class="adfilter" data-value="north_delhi" value="North Delhi" name="locationFilter"> &ensp;North Delhi</label></li>
                <li class="list-group-item"><label class="shoppingmall"><input type="radio" class="adfilter" data-value="west_delhi" value="West Delhi" name="locationFilter"> &ensp;West Delhi</label></li>
                <li class="list-group-item"><label class="shoppingmall"><input type="radio" class="adfilter" data-value="south_delhi" value="South Delhi" name="locationFilter"> &ensp;South Delhi</label></li>
                <li class="list-group-item"><label class="shoppingmall"><input type="radio" class="adfilter" data-value="noida" value="Noida" name="locationFilter"> &ensp;Noida</label></li>
                <li class="list-group-item"><label class="shoppingmall"><input type="radio" class="adfilter" data-value="gurugram" value="Gurugram" name="locationFilter"> &ensp;Gurugram</label></li>
              </ul>
            </div>
          </div>
        </div>

        <!-- panel3 -->

       
        <div class="panel panel-default panel-filter" id="panel3">
          <div class="panel-heading" >
            <h4 class="panel-title"><span class="glyphicon g-side glyphicon-minus" aria-hidden="true"></span> Category</h4>
          </div>

          <div class="">
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
