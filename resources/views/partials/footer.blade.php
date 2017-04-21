</div>

    <footer class="animated fadeInUp">
                <div class="pre-footer"></div>

                <div class="b-footer-body container">
                    <div class="row">
                        <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4">
                            <div class="footer-menu-item wow fadeInLeft">
                                <h6>Quick links</h6>
                                <ul class="list-unstyled">
                                    <li><a href="javascript:void(0);">Living & Dinning</a></li>
                                    <li><a href="javascript:void(0);">Bedroom Accessories</a></li>
                                    <li><a href="javascript:void(0);">Fresh Catalog</a></li>
                                    <li><a href="javascript:void(0);">Track Shipment</a></li>
                                    <li><a href="javascript:void(0);">Customer Service</a></li>
                                    <li><a href="javascript:void(0);">FAQ’s</a></li>
                                    <li><a href="javascript:void(0);">Returns & exchanges</a></li>
                                </ul>
                                <ul class="list-unstyled">
                                    <li><a href="javascript:void(0);">My Orders</a></li>
                                    <li><a href="javascript:void(0);">Delivery Information</a></li>
                                    <li><a href="javascript:void(0);">My Account</a></li>
                                    <li><a href="javascript:void(0);">Login or Register</a></li>
                                    <li><a href="javascript:void(0);">My Cart</a></li>
                                    <li><a href="javascript:void(0);">Wishlist</a></li>
                                </ul>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4 text-center wow fadeIn">
                            <div class="b-logo">
                                 <a href="{{env('APP_URL')}}"><img src="{{asset('images/logo/'.$general->logo)}}" title="Add Launcher" alt="Add Launcher"  style="width: 150px" /></a>
                            </div>
                            <div class="b-footer-contacts">
                                <div class="footer-contacts-list">
                                    <ul class="list-unstyled">
                                        <li>
                                           {{strip_tags($general->address)}}
                                        </li>
                                        
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="b-socials clearfix">
                                <ul class="list-inline">
                                    <li><a href="{{$general->twitter}}"><i class="fa fa-twitter fa-fw"></i></a></li>
                                    <li><a href="{{$general->facebook}}"><i class="fa fa-facebook fa-fw"></i></a></li>
                                    <li><a href="{{$general->linkedin}}"><i class="fa fa-linkedin fa-fw"></i></a></li>
                                    <li><a href="{{$general->instagram}}"><i class="fa fa-instagram fa-fw"></i></a></li>
                                    <li><a href="{{$general->rss}}"><i class="fa fa-rss fa-fw"></i></a></li>
                                    <li><a href="{{$general->google}}"><i class="fa fa-google-plus fa-fw"></i></a></li>
                                </ul>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
                            <div class="b-text text-right wow fadeInRight">
                                <h6>About us</h6>
                                <p>
                                    Lorem ipsum dolor sit amet consectetur
                                    <br>
                                    adipisicing elit sed do eiusmod tempor incididunt
                                    <br>
                                    ut labore et dolore magna aliqua. Ut enim ad
                                    <br>
                                    minim veniam quis nostrud exercitation ullamco
                                    <br>
                                    laboris nisi ut aliquip ex ea commodo consequat.
                                    <br>
                                    Duis aute irure dolor in reprehenderit.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="b-footer-add">
                    <div class="container">
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="clearfix">
                                    <div class="b-copy pull-left">
                                        <p>
                                            © Copyright {{ date('Y')}} <a href="{{env('APP_URL')}}">{{$general->sitename}}.</a> All Rights Reserved.
                                        </p>
                                    </div>
                                    <div class="b-payments pull-right">
                                        <ul class="list-inline">
                                            <li>
                                                <img src="http://html.templines.com/sokolcov/shopone/media/paycards/1.jpg" class="img-responsive" alt="/">
                                            </li>
                                            <li><img src="http://html.templines.com/sokolcov/shopone/media/paycards/2.jpg" class="img-responsive" alt="/"></li>
                                            <li><img src="http://html.templines.com/sokolcov/shopone/media/paycards/3.jpg" class="img-responsive" alt="/"></li>
                                            <li><img src="http://html.templines.com/sokolcov/shopone/media/paycards/4.jpg" class="img-responsive" alt="/"></li>
                                            <li><img src="http://html.templines.com/sokolcov/shopone/media/paycards/5.jpg" class="img-responsive" alt="/"></li>
                                            <li><img src="http://html.templines.com/sokolcov/shopone/media/paycards/6.jpg" class="img-responsive" alt="/"></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </footer>