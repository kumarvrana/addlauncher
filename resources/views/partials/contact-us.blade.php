@extends('layouts.master')

@section('title')

    Contact Us

@endsection


@section('content')


    <!-- Contact -->
                <section id="section-contact">
                    <div class="container">
                        <h2>Get In Touch With Us</h2>
                        <div class="row">
                            <div class="col-sm-5">
                                <h5>Contact Address</h5>
                                <ul class="list-icons list-unstyled">
                                    <li><i class="fa fa-map-marker"></i>{{strip_tags($general->address)}}</li>
                                    <li><i class="fa fa-phone"></i>Phone: {{$general->firstphone}} , {{$general->secondphone}}</li>
                                    <li><i class="fa fa-envelope"></i>Email: <a href="mailto:{{$general->firstemail}}">{{$general->firstemail}}</a></li>
                                    <li><i class="fa fa-envelope"></i>Email: <a href="mailto:{{$general->secondemail}}">{{$general->secondemail}}</a></li>
                                </ul>
                                <div class="spacer"></div>
                                <div class="social-icons">
                                    <a href="{{$general->facebook}}" class="social-icon"><i class="fa fa-facebook"></i></a>
                                    <a href="{{$general->twitter}}" class="social-icon"><i class="fa fa-twitter"></i></a>
                                    <a href="{{$general->google}}" class="social-icon"><i class="fa fa-google-plus"></i></a>
                                    <a href="{{$general->instagram}}" class="social-icon"><i class="fa fa-instagram"></i></a>
                                    <a href="{{$general->youtube}}" class="social-icon"><i class="fa fa-youtube"></i></a>
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
                                            <button type="submit" name="submit" id="submitButton" class="button solid-button purple" title="Send Message">Send Message</button>
                <div class="loader" style="display:none"></div>
                                            
                                            
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
