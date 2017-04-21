<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title')</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <link rel="stylesheet" href="http://fontawesome.io/assets/font-awesome/css/font-awesome.css">
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700,900" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Lato:300,400,700,900" rel="stylesheet">
    <link rel="stylesheet" href="{{ URL::to( 'linearicons/font/style.css' ) }}">
    <link rel="stylesheet" href="{{ URL::to( 'css/shop.css' ) }}">
    <link rel="stylesheet" href="{{ URL::to( 'css/animate.css' ) }}">
    <link rel="stylesheet" href="{{ URL::to( 'css/owl.carousel.min.css' ) }}">
    <link rel="stylesheet" href="{{ URL::to( 'css/owl.transitions.css' ) }}">
    <link rel="stylesheet" href="{{ URL::to( 'css/owl.theme.default.min.css' ) }}">
     <!-- REVOLUTION STYLE SHEETS -->
    <link rel="stylesheet" type="text/css" href="{{ URL::to( 'revolution/css/settings.css' ) }}">
    <!-- REVOLUTION LAYERS STYLES -->
    <link rel="stylesheet" type="text/css" href="{{ URL::to( 'revolution/css/layers.css' ) }}">
    <!-- REVOLUTION NAVIGATION STYLES -->
    <link rel="stylesheet" type="text/css" href="{{ URL::to( 'revolution/css/navigation.css' ) }}">
    <link rel="stylesheet" type="text/css" href="{{ URL::to( 'css/jquery.fancybox.css' ) }}">
    @yield('styles')
    <link rel="icon"  href="{{asset('images/logo/addlogo3.png')}}">

</head>
<body>
    @include('partials.header')
    @include('partials.menu')
    
    @include('partials.searchform')
    <div class="container-fluid main-con">
        
        
        @yield('content')
        
        @include('partials.footer')

        <a href="#" class="scrollToTop"></a>
    </div>  

   <!-- model section start -->
<!--
    <div class="modal fade" tabindex="-1" role="dialog" id="register-model">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Sign Up</h4>
      </div>
      <div class="modal-body">
       <form class="form">
            <div class="error-div"></div>
            <div class="form-group">
                <div class="input-group">
                    <label class="input-group-addon" for="email"><i class="fa fa-envelope"></i></label>
                    <input type="email" id="cccemail" name="email" placeholder="example@exp.com" value="{{old('email')}}" class="form-control" required>
                    
                </div>
            </div>
            <div class="form-group">
                <div class="input-group">
                    <label class="input-group-addon" for="first_name"><i class="fa fa-user"></i></label>
                    <input type="text" id="first_name" name="first_name" placeholder="First Name" value="{{old('first_name')}}" class="form-control" required>
                    
                </div>
            </div>
             <div class="form-group">
                <div class="input-group">
                    <label class="input-group-addon" for="last_name"><i class="fa fa-user"></i></label>
                    <input type="text" id="last_name" name="last_name" placeholder="Last Name" value="{{old('last_name')}}" class="form-control" required>
                   
                </div>
            </div>
            <div class="form-group">
                 <div class="input-group">
                    <label class="input-group-addon" for="password"><i class="fa fa-lock" aria-hidden="true"></i></label>
                    <input type="password" id="password" name="password" class="form-control" value="{{old('password')}}" placeholder="password" required>
                    
                </div>
            </div>
            <div class="form-group">
                 <div class="input-group">
                    <label class="input-group-addon" for="password_confirmation"><i class="fa fa-lock" aria-hidden="true"></i></label>
                    <input type="password" id="password_confirmation" name="password_confirmation" value="{{old('password_confirmation')}}" class="form-control" placeholder="confirm password" required>
                    
                </div>
            </div>
            {{ csrf_field() }}
           
            
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary" id="submit-register-form">Sign Up</button>
      </div>
    </div>
  </div>
</div>
<div class="modal fade" tabindex="-1" role="dialog" id="login-model">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Sign In</h4>
      </div>
      <form class="form" id="submit-loginForm">
        <div class="modal-body">
            <div class="error-div alert alert-danger" style="display:none"></div>
            <div class="form-group">
                <div class="input-group">
                    <label class="input-group-addon" for="email"><i class="fa fa-envelope"></i></label>
                    <input type="email" id="gemail" name="email" placeholder="example@exp.com" class="form-control" required>
                </div>
            </div> 
            <div class="form-group">
                <div class="input-group">
                    <label class="input-group-addon" for="password"><i class="fa fa-lock" aria-hidden="true"></i></label>
                    <input type="password" id="gpassword" name="password" class="form-control"  placeholder="password" required>
                </div>
            </div>
            <div class="form-group">
                <div class="input-group">
                    <label class="input-group-addon" for="remember_me">Remember Me</label>
                    <input type="checkbox" id="remember_me" name="remember_me" class="form-control">
                </div>
            </div>
            
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <input type="submit" class="btn btn-primary" id="submit-login-form" value="Sign In">
      </div>
    </form>
    </div>
  </div>
</div>
-->

 <!-- model section end -->
    <script src="https://code.jquery.com/jquery-1.12.4.min.js" integrity="sha256-ZosEbRLbNQzLpnKIkEdrPv7lOy9C27hHQ+Xp8a4MxAQ=" crossorigin="anonymous"></script>
    <script src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.13.1/jquery.validate.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.3.12/angular.min.js"></script>
	<!--script src="js/app.js"></script-->
    <script>
        //var registerURL = "{{ route('user.postsignup') }}";
       // var loginURL = "{{ route('user.postsignin') }}";
       var contactFormURL = "{{ route('Contact.PostContactForm') }}";
       var airportFilterURL = "{{ route('frontend.getFilterAirportAds')}}";
    </script>
    <script type="text/javascript">
        
       $(function(){
            $("#addClass").click(function () {
                $('#qnimate').addClass('popup-box-on');
            });
            
            $("#removeClass").click(function () {
                $('#qnimate').removeClass('popup-box-on');
            });
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
           
            /*let $login = $('#login');
            $login.on('click', function(event){
                event.preventDefault();
                $('#login-model').modal('show');
                let $loginForm = $('#submit-loginForm');
                $loginForm.submit(function(e){
                    e.preventDefault();
                    var postData = {
                        'email': $('#gemail').val(),
                        'password': $('#gpassword').val(),
                        'remember_me': $('input[name=remember_me]').is(':checked')
                    }
                    console.log(postData);
                    $.ajax({
                        method: 'POST',
                        url: loginURL,
                        data: postData,
                        success: function(response){
                            window.location.href = "/myshop/public"+response.redirect;
                        },
                        error: function(response){
                            $(".error-div").text(response.responseJSON.error);
                            $(".error-div").show();
                        }
                    });
                    
                });
            });*/
            let $contactFormID = $('#contact-form');
            $contactFormID.submit(function(event){
                event.preventDefault();
                $('#submitButton').attr('disabled', 'disabled');
                $('.loader').css('display', 'block');
                var postData = {
                        'email': $('#email').val(),
                        'name': $('#first-name').val(),
                        'phone': $('#phone').val(),
                        'message': $('#description').val()
                }
                $.ajax({
                        method: 'POST',
                        url: contactFormURL,
                        data: postData,
                        success: function(response){
                            $('#email').val('');
                            $('#first-name').val('');
                            $('#phone').val('');
                            $('#description').val('');
                            errorsHtml = '<div class="alert alert-success">';
                            errorsHtml += response.msg;
                            errorsHtml += '</div>';
                            $( '#form-errors' ).html( errorsHtml );
                            $('.loader').css('display', 'none');
                            setTimeout(function(){
                                $( '#form-errors' ).fadeOut();
                                }, 5000);
                            $('#submitButton').removeAttr('disabled');
                        },
                        error: function(response){
                            //debugger;
                            errorsHtml = '<div class="alert alert-danger"><ul>';
                            if (response.status == 422)
                            {
                                $.each(response.responseJSON, function (key, value) {
                                    errorsHtml += '<li>' + value[0] + '</li>';
                                });
                                 errorsHtml += '</ul></div>';
                                 $( '#form-errors' ).html( errorsHtml );
                                 $('.loader').css('display', 'none');
                                setTimeout(function(){
                                $( '#form-errors' ).fadeOut();
                                }, 5000);
                                $('#submitButton').removeAttr('disabled');
                            }
                        }
                });
            });

            //filter script starts
            let $mainElementFilter = $('.adfilter');
            let $loaderImage = $('.loader');
            let working = false;
            $mainElementFilter.on('click', function(){
                $loaderImage.show();
                let isChecked = $(this).is(':checked');
                
               // if(isChecked){
                if (working) {
                    xhr.abort();
                }

                working = true;

                xhr = $.ajax({

                url : airportFilterURL,
                method : "GET",
                async : true,
                data : $("#matchup-filter").serialize(),
                success : function(response) {
                    $("#table-results").html(response);
                    //console.log(response);
                    $loaderImage.hide();
                    working = false;
                    }
               }); 
               // }
            });

        });

  </script>  
    <script src="{{ URL::to( 'js/owl.carousel.min.js' ) }}"></script>
  
    <script type="text/javascript">
       var owl = $('.owl-carousel');
        owl.owlCarousel({
            items:1,
            loop:true,
            margin:10,
            autoplay:true,
            autoplayTimeout:4000,
            autoHeight:true,
            autoplayHoverPause:false
        });

        $(document).ready(function(){
    
    //Check to see if the window is top if not then display button
    $(window).scroll(function(){
        if ($(this).scrollTop() > 100) {
            $('.scrollToTop').fadeIn(500);
        } else {
            $('.scrollToTop').fadeOut(500);
        }
    });
    
    //Click event to scroll to top
    $('.scrollToTop').click(function(){
        $('html, body').animate({scrollTop : 0},800);
        return false;
    });
    
});
        
    </script>


    <script src="{{ URL::to( 'js/jquery.parallax-1.1.3.js') }}"></script>
    <script src="{{ URL::to( 'js/jquery.easing.js') }}"></script>
    <script src="{{ URL::to( 'js/SmoothScroll.js') }}"></script>
    <script src="{{ URL::to( 'js/jquery.fancybox.pack.js') }}"></script>
@yield('scripts')
    <script src="{{ URL::to( 'js/shop.js' ) }}"></script>

      

</body>
</html>