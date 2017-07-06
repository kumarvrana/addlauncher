<?php
	$printsession = (array) Session::get('cart');
?>

<!-- <div id="loadpage"></div> -->

<div class="header-content">
	<div class="sidebar_menu">
		<div id="menu">
			<div class="panel list-group">
				<a href="#" class="list-group-item" data-toggle="collapse" data-target="#sm" data-parent="#menu">Catergory<i class="fa fa-times pull-right"></i></a>
				@if(!empty($mediacats))
					@foreach($mediacats as $mediacat) 
						@if($mediacat->label=='Airport')
							<a href="#" class="list-group-item" data-toggle="collapse" data-target="#{{$mediacat->label}}" data-parent="#menu"><span class="cat-menu-img {{str_replace(' ','_', strtolower($mediacat->title))}} "></span>&nbsp;<b>{{$mediacat->label}}</b></a>
							<div id="{{$mediacat->label}}" class="sublinks collapse">
								<a href="{{env('APP_URL')}}{{$mediacat->slug}}" class="list-group-item small"><b>{{$mediacat->label}}</b></a>
								@foreach($airport_menu as $key => $value)
									<a href="{{ route('frontend.getfrontAirportadByOption', ['airportOption' => $key]) }}"  class="list-group-item small">{{$value}}</a>
								@endforeach
							</div>
						@elseif($mediacat->label=='Auto')
							<a href="#" class="list-group-item" data-toggle="collapse" data-target="#{{$mediacat->label}}" data-parent="#menu"><span class="cat-menu-img {{str_replace(' ','_', strtolower($mediacat->title))}} "></span>&nbsp;{{$mediacat->label}}</a>
							<div id="{{$mediacat->label}}" class="sublinks collapse">
								<a href="{{env('APP_URL')}}{{$mediacat->slug}}" class="list-group-item small">{{$mediacat->label}}</a>
								@foreach($auto_menu as $key => $value)
									<a href="{{ route('frontend.getfrontAutoadByType', ['autotype' => $key]) }}"  class="list-group-item small">{{$value}}</a>
								@endforeach
							</div>
						@elseif($mediacat->label=='Cars')
							<a href="#" class="list-group-item" data-toggle="collapse" data-target="#{{$mediacat->label}}" data-parent="#menu"><span class="cat-menu-img {{str_replace(' ','_', strtolower($mediacat->title))}} "></span>&nbsp;{{$mediacat->label}}</a>
							<div id="{{$mediacat->label}}" class="sublinks collapse">
								<a href="{{env('APP_URL')}}{{$mediacat->slug}}" class="list-group-item small">{{$mediacat->label}}</a>
								@foreach($car_menu as $key => $value)
									<a href="{{ route('frontend.getfrontCaradByType', ['cartype' => $key]) }}"  class="list-group-item small">{{$value}}</a>
								@endforeach
							</div>
						@elseif($mediacat->label=='Outdoor Advertising')
							<a href="#" class="list-group-item" data-toggle="collapse" data-target="#{{str_replace(' ','_', strtolower($mediacat->label))}}" data-parent="#menu"><span class="cat-menu-img {{str_replace(' ','_', strtolower($mediacat->title))}} "></span>&nbsp;{{$mediacat->label}}</a>
							<div id="{{str_replace(' ','_', strtolower($mediacat->label))}}" class="sublinks collapse">
								<a href="{{env('APP_URL')}}{{$mediacat->slug}}" class="list-group-item small">{{$mediacat->label}}</a>
								@foreach($outdoor_menu as $key => $value)
									<a href="{{ route('frontend.getfrontBillboardadByOption', ['billboardOption' => $key]) }}"  class="list-group-item small">{{$value}}</a>
								@endforeach
							</div>
						@else 
							<a href="{{env('APP_URL')}}{{$mediacat->slug}}" class="list-group-item" ><span class="cat-menu-img {{str_replace(' ','_', strtolower($mediacat->title))}} "></span>&nbsp;{{$mediacat->label}}</a>
						@endif
					@endforeach
				@endif
			</div>
		</div>
	</div>
	<div class="desktop_menu">
		<div class="fixed-div"> <!-- fixed-div starts here -->
			<nav id="top">
				<div class="container">
					<div class="container-ink wow fadeInDown">
						<div class="row">
							<div class="col-md-6 col-sm-6 hidden-xs">
								<div class="top-links-left">
									<ul class="list-inline wow fadeInUp" style="visibility: visible; animation-name: fadeInUp;">
										<li><a href="{{$general->twitter}}"><i class="fa fa-twitter fa-fw"></i></a></li>
										<li><a href="{{$general->facebook}}"><i class="fa fa-facebook fa-fw"></i></a></li>
										<li><a href="{{$general->linkedin}}"><i class="fa fa-linkedin fa-fw"></i></a></li>
										<li><a href="{{$general->instagram}}"><i class="fa fa-instagram fa-fw"></i></a></li>
										<li><a href="{{$general->rss}}"><i class="fa fa-rss fa-fw"></i></a></li>
										<li><a href="{{$general->google}}"><i class="fa fa-google-plus fa-fw"></i></a></li>
									</ul>
								</div>
							</div>
							<div class="col-md-6 col-sm-6 col-xs-12">
								<div class="top-links-right">
									<div class="top-wishlist">
										<a href="callto:{{$general->firstphone}}" id="wishlist-total" >
											<em class="lnr lnr-phone-handset"></em>
											<span class="text-top-wishlist"> {{$general->firstphone}}</span>
										</a>
									</div>
									<div class="top-checkout">
										<a href="mailto:{{$general->firstemail}}" title="{{$general->firstemail}}">
											<em class="lnr lnr-envelope"></em> 
											<span class="text-top-checkout">{{$general->firstemail}}</span>
										</a>
									</div> 
								</div>
							</div>
						</div>
					</div>
				</div>
			</nav>
			<header class="header">
				<div class="container-fluid">
					<div class="row">
						<div class="visible-sm visible-xs col-sm-2 col-xs-3">
							<i class="fa fa-bars toggle_menu visible-sm visible-xs""></i>
						</div>
						<div class="col-lg-3 col-md-3 col-sm-4 col-xs-8">
							<div id="logo">
								<a href="{{env('APP_URL')}}"><img src="{{asset('images/logo/'.$general->logo)}}" id="logoimg" title="Add Launcher" alt="Add Launcher" class="img-responsive" /></a>
								<a href="{{env('APP_URL')}}"><img src="{{asset('images/logo/'.$general->logo_fixed)}}" id="logoimg2" title="Add Launcher" alt="Add Launcher" class="img-responsive" /></a>
							</div>
						</div>
						<div class="col-lg-3 col-md-3 hidden-sm hidden-xs">
							<div class="megamenu_div">
								<div class="cd-dropdown-wrapper">
									<a class="cd-dropdown-trigger" href="#0"><span class="hidden-sm hidden-xs">Advertise By Category</span><span class="visible-sm visible-xs">Category</span></a>
									<nav class="cd-dropdown">
										<h2>Choose Category</h2>
											<a href="#0" class="cd-close">Close</a>
											<ul class="cd-dropdown-content">
												@if(!empty($mediacats))
													@foreach($mediacats as $mediacat) 
														@if($mediacat->label=='Airport')
															<li class="has-children">
																<a href="{{env('APP_URL')}}{{$mediacat->slug}}"><span class="cat-menu-img {{str_replace(' ','_', strtolower($mediacat->title))}} "></span>&nbsp;{{$mediacat->label}}</a>
																<ul class="cd-dropdown-icons is-hidden">
																	<li class="go-back"><a href="#0">Menu</a></li>
																	@foreach($airport_menu as $key => $value)
																		<li>
																			<a href="{{ route('frontend.getfrontAirportadByOption', ['airportOption' => $key]) }}"  class="cd-dropdown-item {{str_replace(' ','_', strtolower($value))}}">
																				<h3>{{$value}}</h3>
																				<p>This is the item description</p>
																			</a>
																		</li>
																	@endforeach
																</ul>
															</li>
														@elseif($mediacat->label=='Auto')
															<li class="has-children">
																<a href="{{env('APP_URL')}}{{$mediacat->slug}}"><span class="cat-menu-img {{str_replace(' ','_', strtolower($mediacat->title))}} "></span>&nbsp;{{$mediacat->label}}</a>
																<ul class="cd-dropdown-icons is-hidden">
																	@foreach($auto_menu as $key => $value)
																		<li>
																			<a href="{{ route('frontend.getfrontAutoadByType', ['autotype' => $key]) }}" class="cd-dropdown-item {{str_replace(' ','_', strtolower($value))}}">
																				<h3>{{$value}}</h3>
																				<p>This is the item description</p>
																			</a>
																		</li>
																	@endforeach
																	<div class="img_mega">
																		<img src="{{asset('images/'.$mediacat->image)}}" class="img-responsive">
																	</div>
																</ul>
															</li>
														@elseif($mediacat->label=='Cars')
															<li class="has-children">
																<a href="{{env('APP_URL')}}{{$mediacat->slug}}"><span class="cat-menu-img {{str_replace(' ','_', strtolower($mediacat->title))}} "></span>&nbsp;{{$mediacat->label}}</a>
																<ul class="cd-dropdown-icons is-hidden">
																	@foreach($car_menu as $key => $value)
																		<li>
																			<a href="{{ route('frontend.getfrontCaradByType', ['cartype' => $key]) }}" class="cd-dropdown-item {{str_replace(' ','_', strtolower($value))}}">
																				<h3>{{$value}}</h3>
																				<p>This is the item description</p>
																			</a>
																		</li>
																	@endforeach
																	<div class="img_mega">
																		<img src="{{asset('images/'.$mediacat->image)}}" class="img-responsive">
																	</div>
																</ul>
															</li>
														@elseif($mediacat->label=='Outdoor Advertising')
															<li class="has-children">
																<a href="{{env('APP_URL')}}{{$mediacat->slug}}"><span class="cat-menu-img {{str_replace(' ','_', strtolower($mediacat->title))}} "></span>&nbsp;{{$mediacat->label}}</a>
																<ul class="cd-dropdown-icons is-hidden">
																	@foreach($outdoor_menu as $key => $value)
																		<li>
																			<a href="{{ route('frontend.getfrontBillboardadByOption', ['billboardOption' => $key]) }}" class="cd-dropdown-item {{str_replace(' ','_', strtolower($value))}}">
																				<h3>{{$value}}</h3>
																				<p>This is the item description</p>
																			</a>
																		</li>
																	@endforeach
																	<div class="img_mega">
																		<img src="{{asset('images/'.$mediacat->image)}}" class="img-responsive">
																	</div>
																</ul>
															</li>
														@else
															<li>
																<a href="{{env('APP_URL')}}{{$mediacat->slug}}"><span class="cat-menu-img {{str_replace(' ','_', strtolower($mediacat->title))}} "></span>&nbsp;{{$mediacat->label}}</a>
															</li>
														@endif
													@endforeach
												@endif
											</ul> <!-- .cd-dropdown-content -->
										</nav> <!-- .cd-dropdown -->
									</div> <!-- .cd-dropdown-wrapper -->
								</div>  <!-- end of megamenu_div -->
							</div>
							<div class="col-lg-2 col-md-1 col-sm-2 col-xs-6">
								<div class="button-link-top">
								 <div id="cart" class="btn-group btn-block">
									<a href="{{ route('cart.shoppingCart') }}" class="btn btn-inverse btn-block btn-lg">
										<span id="cart-total">
											@if($printsession['totalQty'] > 0)
												@if( $printsession['totalQty'] != 0 )
													<span class="item-top-cart"><span class="cartQuantity">{{$printsession['totalQty']}}</span> <span class="cart-item">item(s) -</span>
												@else
													<span class="item-top-cart"><span class="cartQuantity">0</span> <span class="cart-item">item(s) -</span>
												@endif
												@if( $printsession['totalPrice'] != 0 )
													<span class="fa fa-inr"><span class="cartTotal">{{$printsession['totalPrice']}} </span></span>
												@else
													<span class="fa fa-inr"><span class="cartTotal"> 0.00</span></span>
												@endif
											@else
												<span class="item-top-cart"><span class="cartQuantity">0</span> <span class="cart-item">item(s) -</span>
												<span class="fa fa-inr"><span class="cartTotal"> 0.00</span></span>
											@endif
										</span>
									</a>
								</div>
							</div>
						</div>
						<div class="col-lg-2 col-md-2 col-sm-3 col-xs-6">
							<div class="nav_right hidden-xs">
								@if(Sentinel::check()) 
									<a class="home_register"><em class="fa fa-user-circle"></em>&nbsp;Hello {{ Sentinel::getUser()->first_name }}</a>
								@else 
									<a class="home_register"><em class="fa fa-user-circle-o"></em> &nbsp;Manage Advertising</a>
								@endif
								<div class="dropdown-inner-log">
									<div class="dropdown-inner-arrow"></div>
									<div class="drop_inner_login">
										@if(Sentinel::check())
											<p>Welcome to Add Launcher</p>
											<div class="sub_log">
												<div class="forgot_pw">
													<div class="btn thb-fill-style">
														<span><a data-name="Login Form" href="{{route('user.profile')}}" id="login">Profile</a></span>
													</div>
													<div class="btn thb-fill-style">
														<span>
															<form action="{{ route('user.postsignout') }}" method="POST" id="logout-form">{{csrf_field()}}
																<a href="#" onclick="document.getElementById('logout-form').submit()">Logout</a>
															</form>
														</span>
													</div>
												</div>
											</div>
										@else
											<p>ALREADY MEMBER ? LOGIN HERE</p>
											<div class="sub_log">
												<div class="forgot_pw">
													<div class="btn thb-fill-style">
														<span><a data-name="Login Form" href="{{route('user.signin')}}" id="login">Login Now</a></span>
													</div>
												</div>
											</div>
										@endif
									</div>
									<div class="member_log">
										@if(Sentinel::check())
											@if(Sentinel::getUser()->roles()->first()->slug == 'admin') 
												<p><a href="{{route('dashboard')}}"><em class="lnr lnr-cog"></em> Dashboard</a></p>
											@endif
										@else
											<p>NOT A MEMBER YET ? <a data-name="Register Here" href="{{route('user.signup')}}" id="register">REGISTER</a> NOW</p>
										@endif
									</div>
								</div>
							</div>
							<div class="dropdown visible-xs">
								@if(Sentinel::check()) 
									<button class="btn btn-primary dropdown-toggle xs_btn" type="button" data-toggle="dropdown">Hello {{ Sentinel::getUser()->first_name }}
										<span class="caret"></span>
									</button>
									<ul class="dropdown-menu">
										<li><a data-name="Login Form" href="{{route('user.profile')}}" id="login">Profile</a></li>
										<li><form action="{{ route('user.postsignout') }}" method="POST" id="logout-form">{{csrf_field()}}<a href="#" onclick="document.getElementById('logout-form').submit()">Logout</a></form></li>
										@if(Sentinel::getUser()->roles()->first()->slug == 'admin') 
											<li><a href="{{route('dashboard')}}"><em class="lnr lnr-cog"></em> Dashboard</a></li>
										@endif
									</ul>
								@else 
									<button class="btn btn-primary dropdown-toggle xs_btn" type="button" data-toggle="dropdown">Manage Advertising
										<span class="caret"></span>
									</button>
									<ul class="dropdown-menu">
										<li><a data-name="Login Form" href="{{route('user.signin')}}" id="login">Login Now</a></li>
										<li><a data-name="Register Here" href="{{route('user.signup')}}" id="register">Register</a></li>
									</ul>
								@endif
							</div>
						</div>
						<div class="col-lg-2 col-md-3 hidden-sm hidden-xs">
							<div class="head_support pull-right">
								<h3>+91 11 41557685</h3>
								<!-- <p>[Call Now]</p> -->
								<h5><img src="{{asset('images/logo/whatsapp.png')}}"> <span>+91-9888575401</span></h5>
							</div>
						</div>
					</div>
				</div>
			</header>

