
<div class="page-sidebar">
	<div class="col-md-12 filter-side">
		<h3 class="text-center refine">Refine Your Search</h3>
		<a href="{{Request::url()}}" class="btn btn-primary btn-block">Clear All Filters</a>
		<hr>
		<div class="filter-box">
      <form id="auto-filter">
			<div class="panel-group">

        <!-- panel1  -->
        <div class="panel panel-default panel-filter" id="panel1">
          <div class="panel-heading" >
            <h4 class="panel-title"><span class="glyphicon g-side glyphicon-minus" aria-hidden="true"></span> Price in Rupee</h4>
          </div>

          <div class="">
            <div class="panel-body ">
              <ul class="list-group">
                <li class="list-group-item"><label class="auto"><input type="radio" class="adfilter" data-value="<=10000" value="<=10000" name="pricerange"> &ensp;< 10,000</label></li>
                <li class="list-group-item"><label class="auto"><input type="radio" class="adfilter" data-value="10000<>50000" value="10000<>50000" name="pricerange"> &ensp;10,001 to 50,000</label></li>
                <li class="list-group-item"><label class="auto"><input type="radio" class="adfilter" data-value=">50000" value=">50000" name="pricerange"> &ensp;> 50,000</label></li>
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
                <li class="list-group-item"><label class="auto"><input type="radio" class="adfilter" data-value="east_delhi" value="East Delhi" name="locationFilter"> &ensp;East Delhi</label></li>
                <li class="list-group-item"><label class="auto"><input type="radio" class="adfilter" data-value="north_delhi" value="North Delhi" name="locationFilter"> &ensp;North Delhi</label></li>
                <li class="list-group-item"><label class="auto"><input type="radio" class="adfilter" data-value="west_delhi" value="West Delhi" name="locationFilter"> &ensp;West Delhi</label></li>
                <li class="list-group-item"><label class="auto"><input type="radio" class="adfilter" data-value="south_delhi" value="South Delhi" name="locationFilter"> &ensp;South Delhi</label></li>
                <li class="list-group-item"><label class="auto"><input type="radio" class="adfilter" data-value="noida" value="Noida" name="locationFilter"> &ensp;Noida</label></li>
                <li class="list-group-item"><label class="auto"><input type="radio" class="adfilter" data-value="gurugram" value="Gurugram" name="locationFilter"> &ensp;Gurugram</label></li>
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
                <li class="list-group-item"><label class="auto"><input type="radio" id="auto_rikshaw_filter" class="adfilter" data-value="auto_rikshaw" value="auto_rikshaw" name="type"> &ensp;Auto Rickshaw</label></li>
                <li class="list-group-item"><label class="auto"><input type="radio" id="e_rikshaw_filter" class="adfilter" data-value="e_rikshaw" value="e_rikshaw" name="type"> &ensp;E Rickshaw</label></li>
                
                <li class="list-group-item"></li>
              </ul>
            </div>
          </div>
        </div>
  
       
        <div class="panel panel-default panel-filter" id="panel4">
          <div class="panel-heading" >
            <h4 class="panel-title"><span class="glyphicon g-side glyphicon-minus" aria-hidden="true"></span> Ad Types</h4>
          </div>

          <div class="">
            <div class="panel-body ">
              <ul class="list-group auto_rikshaw">
                <li class="list-group-item"><label class="auto"><input type="radio" class="adfilter" data-value="sticker" value="sticker" name="category"> &ensp;Sticker</label></li>
                <li class="list-group-item"><label class="auto"><input type="radio" class="adfilter" data-value="auto_hood" value="auto_hood" name="category"> &ensp;Auto Hood</label></li>
                <li class="list-group-item"><label class="auto"><input type="radio" class="adfilter" data-value="backboard" value="backboard" name="category"> &ensp;Backboard</label></li>
                <li class="list-group-item"><label class="auto"><input type="radio" class="adfilter" data-value="full_auto" value="full_auto" name="category"> &ensp;Full Auto</label></li>
              </ul>

              <ul class="list-group e_rikshaw">
                <li class="list-group-item"><label class="auto"><input type="radio" class="adfilter" data-value="back_board" value="back_board" name="category"> &ensp;Back Board</label></li>
                <li class="list-group-item"><label class="auto"><input type="radio" class="adfilter" data-value="stepney_tier" value="stepney_tier" name="category"> &ensp;Stepney Tier</label></li>
                <li class="list-group-item"></li>
              </ul>
            </div>
          </div>
        </div>
  
 

      </div>
      </form>
    </div>

	</div>
</div>
