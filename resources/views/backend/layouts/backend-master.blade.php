<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>@yield('title')</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <link rel="stylesheet" href="http://fontawesome.io/assets/font-awesome/css/font-awesome.css">
    <!--link rel="stylesheet" href="{{ URL::to( 'css/admin-panel.css' ) }}"-->
     <link rel="stylesheet" href="{{ URL::to( 'css/dashboard/dashboard.css' ) }}">
    @yield('styles')
    <script src="//cdn.tinymce.com/4/tinymce.min.js"></script>
    <script>tinymce.init({ selector:'textarea', plugins: 'code link' });</script>

</head>
<body>
    @include('backend.partials.header')
    
    <!--div class="container"-->
   <div class="container-fluid">
        <div class="row">
        @include('backend.partials.sidebar')
        @yield('content')
        </div>
    </div>
       
    <script
			  src="https://code.jquery.com/jquery-1.12.4.min.js"
			  integrity="sha256-ZosEbRLbNQzLpnKIkEdrPv7lOy9C27hHQ+Xp8a4MxAQ="
			  crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
    
@yield('scripts')
<script src="{{ URL::to( 'js/admin-panel.js' ) }}"></script>
</body>
</html>