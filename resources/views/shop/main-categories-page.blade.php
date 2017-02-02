@extends('layouts.master')

@section('title')
        Add Launcher
@endsection

@section('content')
    
        <section id="download" class="call-to-area" data-stellar-background-ratio="0.6" style="background-position: 0% -34.65px;">
        <div class="container">
            <div class="row">
                <div class="col-md-7">
                    <div class="call-to-area-text">
                        <h2>we can help you to grow up your online business</h2>
                        <p>We offer a wide range of procedures to help you get the perfect smile</p>
                        <a class="smoth-scroll" href="#appoinment">contact us</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="sec-cat-box">
        <div class="container-fluid">
            
        
        <div class="row">
        <div class="col-sm-12">
            <div class="section-title">
                <h2>What Are You Looking For?</h2>
                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore. et dolore magna aliqua. </p>
            </div>
        </div>
        </div>
        </div>

            <div class="package-tabs-section">
        <div class="container-fluid">
            <div class="row">
                
            

            @foreach($mediacats as $mediacat)  

            <div class="col-md-3">
                    <div class="package-box width-439-226">
                        <div class="destination-box">
                            <a href="{{route('frontend.adProductsByName', ['catName' => $mediacat->slug])}}" class="similar-destination">
                              <img  alt="" class="img-responsive" src="{{asset('images/'.$mediacat->image)}}" style="display: block;">
                                <div class="description">
                                    <h2 class="destination-name">{{$mediacat->title}}</h2>
                                    <div class="show-box">
                                        <!-- <p><small>Coming Soon</small></p> -->
                                        <p class="text-center">
                                          <span class="view-more">Coming Soon</span>
                                        </p>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
               

         @endforeach
         
         
         </div>
         </div>
         </div>
    </section> 
    <!--   end of section sec-cat-box -->

    

@endsection