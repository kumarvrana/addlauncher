 @extends('layouts.master')

 @section('title')
    404 - Page Not Found
 @endsection

 @section('content')

 <section class="error-page">
     <div class="container">
         <div class="row">
             <div class="col-md-6">
                <div class="e404">
                
                    <div class="row">
                        <div class="col-md-6">
                            <div>
                                <strong>404</strong>
                            </div>
                            <h2>ERROR</h2> 
                        </div>
                        <div class="col-md-6">
                            <i class="fa fa-file-text-o"></i>
                        </div>
                        
                    </div>
                </div>
             </div>
             <div class="col-md-6">
                <div id="e404-side">
                            <h3>Hey! Page not found.</h3>
                            
                            <p><br/><br/>Sorry, but the page you requested could not be found. This page may have been moved, deleted or maybe you have mistyped the URL.</p>
                            
                            <p>Please, try again and make sure you have typed the URL correctly.</p>
                            
                            <p class="center"><br/><a href="{{route('product.mainCats')}}" class="btn thb-fill-style">Go to Homepage</a></p>
                </div>
             </div>
         </div>
     </div>
 </section>



 @endsection
