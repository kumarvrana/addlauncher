
 <nav class="navbar navbar-inverse navbar-fixed-top">
      <div class="container-fluid">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="{{route('product.mainCats')}}">Ad Launcher</a>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
          <ul class="nav navbar-nav navbar-right">
            <li><a href="{{route('dashboard')}}">Dashboard</a></li>
            <li><a href="#">Settings</a></li>
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
          <form class="navbar-form navbar-right">
            <input type="text" class="form-control" placeholder="Search...">
          </form>
        </div>
      </div>
    </nav>