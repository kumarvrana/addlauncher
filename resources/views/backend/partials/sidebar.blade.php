<!--nav class="navbar navbar-inverse sidebar" role="navigation">
    <div class="container-fluid">
		
		<div class="navbar-header">
			<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-sidebar-navbar-collapse-1">
				<span class="sr-only">Toggle navigation</span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</button>
			<a class="navbar-brand" href="#">SideBar Menu</a>
		</div>
		
		<div class="collapse navbar-collapse" id="bs-sidebar-navbar-collapse-1">
			<ul class="nav navbar-nav sidebar-nav">
				<li><a href="{{route('dashboard')}}">Home<span style="font-size:16px;" class="pull-right hidden-xs showopacity glyphicon glyphicon-home"></span></a></li>
				<li ><a href="{{ route('dashboard.addCategoryList') }}">Ad Category List<span style="font-size:16px;" class="pull-right hidden-xs showopacity"><i class="fa fa-television" aria-hidden="true"></i>
</span></a></li>
				<li ><a href="{{route('dashboard.getproduct')}}">Add Product<span style="font-size:16px;" class="pull-right hidden-xs showopacity glyphicon glyphicon-envelope"></span></a></li>
				<li class="dropdown">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown">Settings <span class="caret"></span><span style="font-size:16px;" class="pull-right hidden-xs showopacity glyphicon glyphicon-cog"></span></a>
					<ul class="dropdown-menu forAnimate" role="menu">
						<li><a href="#">Action</a></li>
						<li><a href="#">Another action</a></li>
						<li><a href="#">Something else here</a></li>
						<li class="divider"></li>
						<li><a href="#">Separated link</a></li>
						<li class="divider"></li>
						<li><a href="#">One more separated link</a></li>
					</ul>
				</li>
			
			</ul>
		</div>
	</div>
</nav-->

 <div class="col-sm-3 col-md-2 sidebar sidebar-nav">
          <ul class="nav nav-sidebar">
            <li><a href="{{route('dashboard')}}">Overview <span class="sr-only">(current)</span></a></li>
            <li><a href="{{ route('dashboard.addCategoryList') }}">Ad Category List</a></li>
            <li><a href="{{route('dashboard.getproductlist')}}">Products</a>
							<ul role="menu">
									<li><a href="{{route('dashboard.getproductlist')}}">Products</a></li>
									<li><a href="{{route('dashboard.getproduct')}}">Add Product</a></li>
							</ul>
						</li>
            <li><a href="#">Export</a></li>
          </ul>
          <ul class="nav nav-sidebar">
            <li><a href="">Nav item</a></li>
            <li><a href="">Nav item again</a></li>
            <li><a href="">One more nav</a></li>
            <li><a href="">Another nav item</a></li>
            <li><a href="">More navigation</a></li>
          </ul>
          <ul class="nav nav-sidebar">
            <li><a href="">Nav item again</a></li>
            <li><a href="">One more nav</a></li>
            <li><a href="">Another nav item</a></li>
          </ul>
        </div>