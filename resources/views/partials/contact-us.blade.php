@extends('layouts.master')

@section('title')

    Contact Us

@endsection

@section('styles')
    <link rel="stylesheet" href="{{ URL::to( 'css/contact.css' ) }}" />
@stop

@section('content')



    <!-- Contact -->
                <section id="section8">
                    <div class="container">
                        <h2>Get In Touch With Us</h2>
                        <div class="row">
                            <div class="col-sm-5">
                                <h5>Contact Address</h5>
                                <ul class="list-icons list-unstyled">
                                    <li><i class="fa fa-map-marker"></i>1307, Best Sky Tower, F-5<br />Netaji Subhash Place, Pitampura,<br>New Delhi-110034</li>
                                    <li><i class="fa fa-phone"></i>Phone: 011-41557685 , 011-41558205</li>
                                    <li><i class="fa fa-envelope"></i>Email: <a href="mailto:example@gmail.com">example@gmail.com</a></li>
                                    <li><i class="fa fa-globe"></i>Website: <a href="">info@addlauncher.com</a></li>
                                </ul>
                                <div class="spacer"></div>
                                <div class="social-icons">
                                    <a href="" class="social-icon"><i class="fa fa-facebook"></i></a>
                                    <a href="" class="social-icon"><i class="fa fa-twitter"></i></a>
                                    <a href="" class="social-icon"><i class="fa fa-google-plus"></i></a>
                                    <a href="" class="social-icon"><i class="fa fa-behance"></i></a>
                                    <a href="" class="social-icon"><i class="fa fa-dribbble"></i></a>
                                </div> <!-- end .social-icons -->
                                <div class="spacer"></div>
                            </div>
                            <div class="col-sm-7">
                                <h5>Contact Form</h5>
                                <form  id="contact-form" method="post" class="form-horizontal contact-form">
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label">Name</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="contact-name" name="name" id="first-name" />
                                        </div> <!-- end .col-sm-10 -->
                                    </div> <!-- end .form-group -->
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label">Email</label>
                                        <div class="col-sm-10">
                                            <input type="email" class="contact-email" name="email" id="email" />
                                        </div> <!-- end .col-sm-10 -->
                                    </div> <!-- end .form-group -->
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label">Mobile</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="contact-mobile" name="phone" id="phone" />
                                        </div> <!-- end .col-sm-10 -->
                                    </div> <!-- end .form-group -->
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label">Message</label>
                                        <div class="col-sm-10">
                                            <textarea name="message" id="description" class="contact-message" rows="3"></textarea>
                                        </div> <!-- end .col-sm-10 -->
                                    </div> <!-- end .form-group -->
                                    <div class="form-group">
                                        <div class="col-sm-10 col-sm-offset-2">
                                            <button type="submit" name="submit" id="submitButton" class="button solid-button purple" title="Send Message">Send Message</button><span class="csc-spin"></span>
                                            
                                        </div> <!-- end .col-sm-10 -->
                                    </div> <!-- end .form-group -->
                                    
                                </form> <!-- end contact-form -->
                            </div>
                        </div>
                        <div class="map" id="map">
                            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2081.085116364972!2d77.14983966528474!3d28.69102175527781!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0xba20e6ac679af469!2sBest+Group+of+Companies!5e0!3m2!1sen!2sin!4v1491479541605" width="100%" height="350" frameborder="0" style="border:0" allowfullscreen></iframe>
                        </div>
                    </div> <!-- end .container -->
                </section> <!-- end #section1 --> 

@endsection
