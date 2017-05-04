
 <nav class="navbar navbar-inverse navbar-fixed-top">
      <div class="container-fluid">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a href="{{env('APP_URL')}}"><img src="{{asset('images/logo/'.$general->logo)}}" title="Add Launcher" alt="Add Launcher" class="img-responsive" width="220px" /></a>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
          <ul class="nav navbar-nav navbar-right">
          <li><a href="{{route('users')}}">Users</a></li>
            <li><a href="{{route('dashboard.orders')}}">Orders<span class="badge">1</span></a></li>
            <li class="dropdown"><a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><i class="fa fa-user" aria-hidden="true"></i>
 Settings<span class="caret"></span></a>
              <ul class="dropdown-menu">
              <li><a href="{{route('dashboard.generalsettings')}}">General Options</a></li>
              <li class="dropdown"><a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
 Payments
              <ul class="dropdown-menu">
                <li><a href="{{route('dashboard.cashtransfer')}}">Cash Transfer</a></li>
                <li><a href="{{route('dashboard.citrustransfer')}}">Cirtus Payment</a></li>
                <li><a href="{{route('dashboard.stripetransfer')}}">Stripe Payment</a></li>
              </ul>
            </li>
              </ul>
            </li>
            <!--li><a href="#">Profile</a></li-->
            <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><i class="fa fa-user" aria-hidden="true"></i>
 Hi Admin<span class="caret"></span></a>
          <ul class="dropdown-menu">
              @if(Auth::check())
                    <li><a href="{{route('user.profile')}}">Profile</a></li>
                    <li role="separator" class="divider"></li>
                    <li><a href="{{route('user.logout')}}">Logout</a></li>
              @else
                    <li><a href="{{route('user.signup')}}">SignUp</a></li>
                    <li><a href="{{route('user.signin')}}">SignIn</a></li>
              @endif
           
            
          </ul>
        </li>
          </ul>
          
        </div>
      </div>
    </nav>