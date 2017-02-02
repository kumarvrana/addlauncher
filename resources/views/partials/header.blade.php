
  <!-- Top Bar starts here -->
<div class="topbar"><div class="container">
      <ul class="list-inline pull-left">
        <li><a href="#"><span class="fa fa-facebook"></span></a></li>
  <li><a href="#"><span class="fa fa-twitter"></span></a></li>
  <li><a href="#"><span class="fa fa-linkedin"></span></a></li>
  <li><a href="#"><span class="fa fa-google-plus"></span></a></li>
  <li><a href="#"><span class="fa fa-instagram"></span></a></li>
        
        </ul>
  <ul class="list-inline pull-right">
  <li><a href="callto:011-41557685"><span class="fa fa-phone"></span>&emsp;011-41557685</a></li>
  <li><a href="mailto:info@addlauncher.com"><span class="fa fa-envelope"></span>&emsp;info@addlauncher.com</a></li>

        </ul>
      </div>
  </div>  <!-- Top Bar ends here -->




<nav class="navbar navbar-default menu-bg">
  <div class="container">
    <div class="main-head">
      <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="{{route('product.index')}}">ADD <span class="logo-sub">LAUNCHER</span></a>
        </div>
        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
          <ul class="nav navbar-nav navbar-right main-right-menu">
            
            @if(Sentinel::check())
              @if(Sentinel::getUser()->roles()->first()->slug == 'admin')
                <li><a href="{{route('dashboard')}}">Dashboard <i class="fa fa-tachometer" aria-hidden="true"></i></a></li>
              @endif
            @endif
           
            <li><a href="{{ route('product.shoppingCart') }}">Shop Cart <i class="fa fa-shopping-cart" aria-hidden="true"></i><span class="badge">{{ Session::has('cart') ? Session::get('cart')->totalQty : '' }}</span>
            </a></li>
            <li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><i class="fa fa-user" aria-hidden="true"></i>@if(Sentinel::check()) Hi {{ Sentinel::getUser()->first_name }} @else User @endif <span class="caret"></span></a>
              <ul class="dropdown-menu">
                  @if(Sentinel::check())
                        <li><a href="{{route('user.profile')}}"><i class="fa fa-user-md" aria-hidden="true"></i>
 Profile</a></li>
                        <li role="separator" class="divider"></li>
                        <li><form action="{{ route('user.postsignout') }}" method="POST" id="logout-form">{{csrf_field()}}<a href="#" onclick="document.getElementById('logout-form').submit()"><i class="fa fa-sign-out" aria-hidden="true"></i>
Logout</a></form></li>
                  @else
                        <li><a data-name="Register Here" href="{{route('user.signup')}}" id="register"><i class="fa fa-user-plus" aria-hidden="true"></i>
SignUp</a></li>
                        <li><a data-name="Login Form" href="{{route('user.signin')}}" id="login"><i class="fa fa-sign-in" aria-hidden="true"></i>
SignIn</a></li>
                  @endif
               
                
              </ul>
            </li>
          </ul>
        </div><!-- /.navbar-collapse -->
    </div><!-- main-head close -->
    
  </div><!-- /.container-fluid -->
</nav>