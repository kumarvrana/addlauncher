

@PHP
$printsession = (array) Session::get('cart');

@ENDPHP


<div class="header-content">
  <nav id="top">
    <div class="container">
      <div class="container-ink">
        <div class="row">
          <div class="col-md-6 col-sm-6 col-xs-12">
             <div class="top-links-left">
                <div class="dropdown top-account">

                  <a href="#" title="" class="dropdown-toggle" data-toggle="dropdown">
                    <span class=""><em class="lnr lnr-user"></em> 
                      @if(Sentinel::check()) 
                        Hi {{ Sentinel::getUser()->first_name }} 
                      @else 
                        My Account 
                      @endif
                    </span><i class="fa fa-angle-down "></i>
                  </a>


                  <ul class="dropdown-menu dropdown-menu-right">
                    @if(Sentinel::check())
                          <li><a href="{{route('user.profile')}}"> Profile</a></li>
                          <li><form action="{{ route('user.postsignout') }}" method="POST" id="logout-form">{{csrf_field()}}<a href="#" onclick="document.getElementById('logout-form').submit()">Logout</a></form></li>
                          @else
                          <li><a data-name="Register Here" href="{{route('user.signup')}}" id="register">Register</a></li>
                          <li><a data-name="Login Form" href="{{route('user.signin')}}" id="login">Login</a></li>
                    @endif
                  </ul>
                  
                  @if(Sentinel::check())
                    @if(Sentinel::getUser()->roles()->first()->slug == 'admin') 
                        <a href="{{route('dashboard')}}" class="head-link" >
                          <em class="lnr lnr-cog"></em>
                            Dashboard 
                        </a>
                    @endif
                  @endif
                 
                  
                </div>

            </div>
          </div>
             
         
          <div class="col-md-6 col-xs-12 col-sm-6">
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

<div class="fixed-div"> <!-- fixed-div starts here -->
  <header class="header">
    <div class="container">
      <div class="row">
        <div class="col-md-3 col-sm-3 col-sms-12">
          <div id="logo">
            <a href="{{env('APP_URL')}}"><img src="{{asset('images/logo/'.$general->logo)}}" title="Add Launcher" alt="Add Launcher" class="img-responsive" /></a>
          </div>
        </div>
        <div class="col-md-6 col-sm-6 col-sms-12">
          <div id="cmsblock-30" class="cmsblock">
            <div class="description">
                  <div class="header-icon">
                    <div class="col col1">
                      <em class="lnr lnr-phone"></em>
                      <div class="header-content">
                        <h2>Free shipping</h2>
                        <p>Free shipping on all order</p>
                      </div>
                      
                      
                    </div>
                    <div class="col col2">
                      <em class="lnr lnr-rocket"></em>
                      <div class="header-content">
                        <h2>Suppost 24/7</h2>
                        <p>We support online 24 hours a day</p>
                      </div>

                    </div>
                  </div>                                    
              </div>
          </div>
        </div>
        <div class="col-md-3 col-sm-3 col-sms-12">
          <div class="">
            <div class="button-link-top">
               <div id="cart" class="btn-group btn-block">
                <a href="{{ route('cart.shoppingCart') }}" class="btn btn-inverse btn-block btn-lg">
                  <span id="cart-total">
                    @if(count($printsession) > 0)
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
                  </span>
                </a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </header>
