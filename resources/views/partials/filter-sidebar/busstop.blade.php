
<div class="page-sidebar">
	<div class="col-md-12 filter-side">
		<h3 class="text-center refine">Refine Your Search</h3>
			
		<a href="{{Request::url()}}" class="btn btn-primary btn-block">Clear All Filters</a>
		<hr>
		<div class="filter-box">
      <form id="busstop-filter">
			<div class="panel-group">

        <!-- panel1  -->
        <div class="panel panel-default panel-filter" id="panel1">
          <div class="panel-heading" >
           <a data-toggle="collapse" href="#collapse1"> <h4 class="panel-title"><span class="glyphicon g-side glyphicon-minus" aria-hidden="true"></span> Price in Rupee</h4></a>
          </div>

          <div id="collapse1" class="panel-collapse collapse">
            <div class="panel-body ">
              <ul class="list-group">
                <li class="list-group-item "><label class="busstop"><input type="radio" class="adfilter" data-value="<=10000" value="<=10000" name="pricerange"> &ensp;< 10,000</label></li>
                <li class="list-group-item"><label class="busstop"><input type="radio" class="adfilter" data-value="10000<>50000" value="10000<>50000" name="pricerange"> &ensp;10,001 to 50,000</label></li>
                <li class="list-group-item"><label class="busstop"><input type="radio" class="adfilter" data-value=">50000" value=">50000" name="pricerange"> &ensp;> 50,000</label></li>
                <li class="list-group-item"></li>
              </ul>
            </div>
          </div>
        </div>

        <!-- panel2 -->

        <div class="panel panel-default panel-filter" id="panel2">
          <div class="panel-heading" >
           <a data-toggle="collapse" href="#collapse2"> <h4 class="panel-title"><span class="glyphicon g-side glyphicon-minus" aria-hidden="true"></span> Top Location in Delhi NCR</h4></a>
          </div>
          <div id="collapse2" class="panel-collapse collapse">
            <div class="panel-body">
              <ul class="list-group">
                <li class="list-group-item"><label class="busstop"><input type="radio" class="adfilter" data-value="east_delhi" value="East Delhi" name="locationFilter"> &ensp;East Delhi</label></li>
                <li class="list-group-item"><label class="busstop"><input type="radio" class="adfilter" data-value="north_delhi" value="North Delhi" name="locationFilter"> &ensp;North Delhi</label></li>
                <li class="list-group-item"><label class="busstop"><input type="radio" class="adfilter" data-value="west_delhi" value="West Delhi" name="locationFilter"> &ensp;West Delhi</label></li>
                <li class="list-group-item"><label class="busstop"><input type="radio" class="adfilter" data-value="south_delhi" value="South Delhi" name="locationFilter"> &ensp;South Delhi</label></li>
                <li class="list-group-item"><label class="busstop"><input type="radio" class="adfilter" data-value="noida" value="Noida" name="locationFilter"> &ensp;Noida</label></li>
                <li class="list-group-item"><label class="busstop"><input type="radio" class="adfilter" data-value="gurugram" value="Gurugram" name="locationFilter"> &ensp;Gurugram</label></li>
              </ul>
            </div>
          </div>
        </div>

        <!-- panel3 -->

       
        <div class="panel panel-default panel-filter" id="panel3">
          <div class="panel-heading" >
           <a data-toggle="collapse" href="#collapse3"> <h4 class="panel-title"><span class="glyphicon g-side glyphicon-minus" aria-hidden="true"></span> Ad Type</h4></a>
          </div>

          <div id="collapse3" class="panel-collapse collapse">
            <div class="panel-body ">
              <ul class="list-group">
                <li class="list-group-item"><label class="busstop"><input type="radio" class="adfilter" data-value="full" value="full" name="category"> &ensp;Full</label></li>
                <li class="list-group-item"><label class="busstop"><input type="radio" class="adfilter" data-value="roof_front" value="roof_front" name="category"> &ensp;Roof Front</label></li>
                <li class="list-group-item"><label class="busstop"><input type="radio" class="adfilter" data-value="seat_backs" value="seat_backs" name="category"> &ensp;Seat Backs</label></li>
                 <li class="list-group-item"><label class="busstop"><input type="radio" class="adfilter" data-value="side_boards" value="side_boards" name="category"> &ensp;Side Boards</label></li>
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
