@extends('layouts.master')

@section('title')
    Checkout|Add Launcher 
@endsection

@section('content')
    
        <div class="container-fluid">
            <div class="row cart-body">
                <div class="col-md-3">
                    @include('partials.sidebar-cart')
                </div>
                <div class="col-md-9 wrapper">
                    <div class="section-title">
                        <h2>Checkout</h2>
                    </div>

                    <div id="charge-error" class="alert alert-danger {{ !Session::has('error') ? 'hidden' : '' }}">
                    {{ Session::get('error') }}
                    </div>

                    <div id="charge-error-payment"> </div>


                    <form action="{{route('postCheckout')}}" method="post" id="checkout-form" class="form-horizontal">
                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 col-md-push-6 col-sm-push-6">

                        <!--CREDIT CART PAYMENT-->
                            <div class="payment-nav" >
                                
                                <div class="online-payment">
                                    <div class="sub-content">
                                        <div class="panel panel-cart">
                                            <div class="panel-heading">
                                                Online Payment
                                            </div>
                                        </div>        
                                    
                                    <div class="description-cashpayment">
                                        <ul>
                                            <li>Mention your brand name in description section Cheque Payment</li>
                                            <li>Send us a scanned copy of the cheque to <a href="mailto:info@addlauncher.com">info@addlauncher.com</a></li>
                                            <li>Courier the cheque to: Adlauncher, Best Sky Tower, NSP, Pitampura - 110034 Phone No: +011-4557685</li>
                                        </ul>
                                        
                                    </div>
                                    <div class="bank-details">

                                    @PHP
                                        
                                        $Settings = unserialize($settings->payment_secret);
                                        
                                    @ENDPHP
                                        <table class="table table-bordered">
                                              <tr>
                                                <th>Bank Name</th>
                                                <td>{{$Settings['bankname']}}</td>
                                              </tr>
                                            
                                              <tr>
                                                <th>Account Name</th>
                                                <td>{{$Settings['accountname']}}</td>
                                              </tr>
                                              <tr>
                                                <th>Account Number</th>
                                                <td>{{$Settings['accountno']}}</td>
                                              </tr>
                                              <tr>
                                                <th>Account Type</th>
                                                <td>{{$Settings['accounttype']}}</td>
                                              </tr>
                                              <tr>
                                                <th>IFSC</th>
                                                <td>{{$Settings['ifsc']}}</td>
                                              </tr>
                                        </table>
                                       
                                    </div>
                                </div>

                                    {{csrf_field()}}
                                    
                                    <div class="form-group">
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                          
                                            <button type="button" class="btn btn-primary">Order Now</button>
                                            
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- end card mode -->
                            <!--REVIEW ORDER-->
                             @if($products)
                            <div class="panel panel-cart">
                                        <div class="panel-heading">
                                            Review Order <div class="pull-right"><small><a class="afix-1" href="{{route('cart.shoppingCart')}}"><span class="fa fa-edit"></span> Edit Cart</a></small></div>
                                        </div>
                                        <div class="panel-body">
                                           
                                            @foreach( $products as $product)
                                            @PHP
                                                $key = array_search($product, $products);
                                                $imagefolder = explode('_', $key);
                                            @ENDPHP
                                            <div class="form-group">
                                                <div class="col-sm-3 col-xs-3">
                                                    <img class="img-responsive cart-img" src="{{asset('images/'.$imagefolder[0].'/'.$product['item']['image'])}}" alt="{{ $product['item']['title'] }} | {{ ucwords(str_replace('_', ' ', substr($product['item']['price_key'], 6)))}}" />
                                                </div>
                                                <div class="col-sm-6 col-xs-6">
                                                    <div class="row">
                                                        <div class="col-xs-12 c-title">
                                                        <h5>
                                                        {{ $product['item']['title'] }} | {{ ucwords(str_replace('_', ' ', substr($product['item']['price_key'], 6)))}}
                                                        </h5>
                                                        <hr>
                                                        </div>

                                                        <div class="col-xs-12 c-quant">
                                                            <h5>Quantity :<small> 1</small></h5> 
                                                        </div>
                                                        
                                                    </div>
                                                </div>
                                                <div class="col-sm-3 col-xs-3 text-right c-price">
                                                    <h4>Rs. {{$product['item']['price_value']}}</h4>
                                                    
                                                </div>
                                                
                                            </div>
                                            <div class="form-group">
                                                <hr>
                                            </div>
                                            @endforeach

                                            <div class="form-group">
                                                <div class="col-xs-12">
                                                    <div class="pull-right c-total">
                                                       <h3> <span>Total :</span> Rs.{{ $total }} </h3>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                            @endif
                            <!--REVIEW ORDER END-->
                        </div>
                        <!--SHIPPING METHOD END-->
                         
                        <!-- cirtus method -->
                         <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 col-md-pull-6 col-sm-pull-6">
                            <!--SHIPPING METHOD-->
                            <input type="hidden" name="payMethod" value="{{$payMethod}}">
                            <div class="panel panel-cart">
                                <div class="panel-heading">Address</div>
                                <div class="panel-body">
                                   <div class="row">
                                        
                                        <div class="form-group">
                                            <div class="col-md-12">
                                                <label>Name:</label>

                                                <input type="text" id="firstName" name="firstName" class="form-control" required/>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-md-12"><strong>Phone Number:</strong></div>
                                            <div class="col-md-12"><input type="text" id="mobileNo" name="phoneNumber" class="form-control"  required/></div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-md-12"><strong>Email Address:</strong></div>
                                            <div class="col-md-12"><input type="text" id="email" name="email" class="form-control" required/></div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-md-12"><strong>Address:</strong></div>
                                            <div class="col-md-12">
                                                <input type="text" id="street1" name="addressStreet1" class="form-control" required/>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-md-12">
                                            <label>Country:</label>
                                                <input type="text" class="form-control" name="addressCountry" id="country" required/>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-md-12"><strong>City:</strong></div>
                                            <div class="col-md-12">
                                                <input type="text" id="city" name="addressCity" class="form-control" required/>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-md-12"><strong>State:</strong></div>
                                            <div class="col-md-12">
                                                <input type="text" id="state" name="addressState" class="form-control" required/>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-md-12"><strong>Zip / Postal Code:</strong></div>
                                            <div class="col-md-12">
                                                <input type="text" id="zip" name="addressZip" class="form-control" required/>
                                            </div>
                                        </div>
                                        
                                   </div>
                                </div>
                            </div>
                            <!--SHIPPING METHOD END-->
                           
                            
                            
                            <!--CREDIT CART PAYMENT END-->
                        </div>
                        
                             </div>
                             
                    </form>
                </div>
            </div>    
            




            <div class="row cart-footer">
        
            </div>
    </div>
  

       
@endsection

@section('scripts')
   
   
@endsection