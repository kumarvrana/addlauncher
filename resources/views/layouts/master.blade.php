<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title')</title>
    <link rel="stylesheet" href="http://fontawesome.io/assets/font-awesome/css/font-awesome.css">
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700,900" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Lato:300,400,700,900" rel="stylesheet">
    <link rel="stylesheet" href="{{ URL::to( 'linearicons/font/style.css' ) }}">
    <link rel="stylesheet" href="{{ URL::to( 'css/master.css' ) }}">
    <!-- REVOLUTION STYLE SHEETS -->
    <link rel="stylesheet" type="text/css" href="{{ URL::to( 'revolution/css/settings.css' ) }}">
    <link rel="stylesheet" type="text/css" href="{{ URL::to( 'revolution/css/layers.css' ) }}">
    <link rel="stylesheet" type="text/css" href="{{ URL::to( 'revolution/css/navigation.css' ) }}">
    @yield('styles')
    <link rel="icon" href="{{asset('images/logo/'.$general->favicon)}}">

</head>

<body>
    @include('partials.header') 
    @include('partials.menu')
    <div class="container-fluid main-con">

    @yield('content') 
    @include('partials.footer')

    <a href="#" class="scrollToTop"></a>
    </div>

    <script src="{{ URL::to( 'js/jquery.min.js' ) }}"></script>
    <script src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.13.1/jquery.validate.js"></script>
    <script src="{{ URL::to( 'js/bootstrap.min.js' ) }}"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.3.12/angular.min.js"></script>
    <script src="{{ URL::to( 'js/owl.carousel.min.js' ) }}"></script>
    <script src="{{ URL::to( 'js/filter.js' ) }}"></script>
    <script src="{{ URL::to( 'js/jquery.parallax-1.1.3.js') }}"></script>
    <script src="{{ URL::to( 'js/jquery.easing.js') }}"></script>
    <script src="{{ URL::to( 'js/SmoothScroll.js') }}"></script>
    <script src="{{ URL::to( 'js/jquery.fancybox.pack.js') }}"></script>
    <!--script src="js/app.js"></script-->
    <script type="text/javascript">
        var contactFormURL = "{{ route('Contact.PostContactForm') }}";
        var airportFilterURL = "{{ route('frontend.getFilterAirportAds')}}";
        var autoFilterURL = "{{ route('frontend.getFilterAutoAds')}}";
        var busstopFilterURL = "{{ route('frontend.getFilterBusstopAds')}}";
        var carFilterURL = "{{ route('frontend.getFilterCarAds')}}";
    </script>
    <script src="{{ URL::to( 'js/common.js' ) }}"></script>

    @yield('scripts')
    <script src="{{ URL::to( 'js/shop.js' ) }}"></script>
</body>

</html>