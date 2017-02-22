@extends('layouts.master')

@section('title')
    Checkout|Add Launcher 
@endsection

@section('content')
        <div class="container wrapper">
            <div class="row cart-head">
                <h1>Checkout</h1></hr>
            </div>    
            <div class="row cart-body">
                 <div id="charge-error" class="alert alert-danger {{ !Session::has('error') ? 'hidden' : '' }}">
                    {{ Session::get('error') }}
                </div>
                <form action="{{ route('checkout') }}" method="post" id="checkout-form" class="form-horizontal">
                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 col-md-push-6 col-sm-push-6">
                    <!--REVIEW ORDER-->
                     @if($products)
                    <div class="panel panel-info">
                        <div class="panel-heading">
                            Review Order <div class="pull-right"><small><a class="afix-1" href="#">Edit Cart</a></small></div>
                        </div>
                        <div class="panel-body">
                            
                            <div class="form-group"><hr /></div>
                            @foreach( $products as $product)
                            @PHP
                                $key = array_search($product, $products);
                                $imagefolder = explode('_', $key);
                            @ENDPHP
                            <div class="form-group">
                                <div class="col-sm-3 col-xs-3">
                                    <img class="img-responsive" src="{{asset('images/'.$imagefolder[0].'/'.$product['item']['image'])}}" alt="{{ $product['item']['title'] }} | {{ ucwords(str_replace('_', ' ', substr($product['item']['price_key'], 6)))}}" />
                                </div>
                                <div class="col-sm-6 col-xs-6">
                                    <div class="col-xs-12">{{ $product['item']['title'] }} | {{ ucwords(str_replace('_', ' ', substr($product['item']['price_key'], 6)))}}</div>
                                    <div class="col-xs-12"><small>Quantity:<span>1</span></small></div>
                                </div>
                                <div class="col-sm-3 col-xs-3 text-right">
                                    <h6><span>Rs.</span>{{$product['item']['price_value']}}</h6>
                                </div>
                            </div>
                            @endforeach
                            <div class="form-group"><hr /></div>
                            <!--div class="form-group">
                                <div class="col-xs-12">
                                    <strong>Subtotal</strong>
                                    <div class="pull-right"><span>$</span><span>200.00</span></div>
                                </div>
                                <div class="col-xs-12">
                                    <small>Shipping</small>
                                    <div class="pull-right"><span>-</span></div>
                                </div>
                            </div-->
                            <div class="form-group"><hr /></div>
                            <div class="form-group">
                                <div class="col-xs-12">
                                    <strong>Order Total</strong>
                                    <div class="pull-right"><span>Rs.</span><span>{{ $total }}</span></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif
                    <!--REVIEW ORDER END-->
                </div>
                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 col-md-pull-6 col-sm-pull-6">
                    <!--SHIPPING METHOD-->
                    <div class="panel panel-info">
                        <div class="panel-heading">Address</div>
                        <div class="panel-body">
                           
                            <div class="form-group">
                                <div class="col-md-12"><strong>Country:</strong></div>
                                <div class="col-md-12">
                                    <input type="text" class="form-control" name="country" required/>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-md-12">
                                    <strong>Name:</strong>
                                </div>
                                <div class="col-md-12">
                                    <input type="text" id="name" name="name" class="form-control" required/>
                                </div>
                                
                            </div>
                            <div class="form-group">
                                <div class="col-md-12"><strong>Address:</strong></div>
                                <div class="col-md-12">
                                    <input type="text" id="address" name="address" class="form-control" required/>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-md-12"><strong>City:</strong></div>
                                <div class="col-md-12">
                                    <input type="text" id="city" name="city" class="form-control" required/>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-md-12"><strong>State:</strong></div>
                                <div class="col-md-12">
                                    <input type="text" id="state" name="state" class="form-control" required/>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-md-12"><strong>Zip / Postal Code:</strong></div>
                                <div class="col-md-12">
                                    <input type="text" id="zip_code" name="zip_code" class="form-control" required/>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-md-12"><strong>Phone Number:</strong></div>
                                <div class="col-md-12"><input type="text" id="phone_number" name="phone_number" class="form-control"  required/></div>
                            </div>
                            <div class="form-group">
                                <div class="col-md-12"><strong>Email Address:</strong></div>
                                <div class="col-md-12"><input type="text" id="email_address" name="email_address" class="form-control" required/></div>
                            </div>
                        </div>
                    </div>
                    <!--SHIPPING METHOD END-->
                    <!--CREDIT CART PAYMENT-->
                    <div class="panel panel-info">
                        <div class="panel-heading"><span><i class="glyphicon glyphicon-lock"></i></span> Secure Payment</div>
                        <div class="panel-body">
                           <div class="form-group">
                                <div class="col-md-12"><strong>Card Holder Name:</strong></div>
                                <div class="col-md-12"><input type="text" id="card-name" class="form-control" name="card_name" required/></div>
                            </div>
                            <div class="form-group">
                                <div class="col-md-12"><strong>Card Number:</strong></div>
                                <div class="col-md-12"><input type="text" class="form-control" id="card-number" name="card_number" required /></div>
                            </div>
                            <div class="form-group">
                                <div class="col-md-12"><strong>Card CVV:</strong></div>
                                <div class="col-md-12"><input type="password" id="card-cvc" class="form-control" name="card-cvc" required /></div>
                            </div>
                            <div class="form-group">
                                <div class="col-md-12">
                                    <strong>Expiration Date</strong>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                    <select id="card-expiry-month" class="form-control" name="card-expiry-month" required>
                                        <option value="">Month</option>
                                        <option value="01">01</option>
                                        <option value="02">02</option>
                                        <option value="03">03</option>
                                        <option value="04">04</option>
                                        <option value="05">05</option>
                                        <option value="06">06</option>
                                        <option value="07">07</option>
                                        <option value="08">08</option>
                                        <option value="09">09</option>
                                        <option value="10">10</option>
                                        <option value="11">11</option>
                                        <option value="12">12</option>
                                </select>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                    <select id="card-expiry-year" class="form-control" name="card-expiry-year" required>
                                        <option value="">Year</option>
                                        @PHP
                                            $currentYear = date('Y');
                                        @ENDPHP
                                        @for($i=0; $i<=15; $i++)
                                             <option value="{{$currentYear + $i}}">{{$currentYear + $i}}</option>
                                        @endfor
                                        
                                </select>
                                </div>
                            </div>
                         
                            <div class="form-group">
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    {{csrf_field()}}
                                    <button type="submit" class="btn btn-primary btn-submit-fix">Buy Now</button>
                                    
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--CREDIT CART PAYMENT END-->
                </div>
                
                </form>
            </div>
            <div class="row cart-footer">
        
            </div>
    </div>
  <form align="center" method="post">
<input type="hidden" id="merchantTxnId" name="merchantTxnId" value="<%=merchantTxnId%>" />
<input type="hidden" id="amount" name="orderAmount" value="<%=orderAmount%>" />
<input type="hidden" id="currency" name="currency" value="INR" />
<input type="text" name="email" value="testmerchant@mailnator.com" />
<input type="text" name="mobile" value="8527395492" />
<input type="hidden" id="securitySignature" name="secSignature" value="<%=securitySignature%>" />
</form>
<input type="Submit" value="Pay Now" id="launchICP"/>
       
@endsection

@section('scripts')
    <script type="text/javascript" src="https://js.stripe.com/v2/"></script>
    <script type="text/javascript" src="{{ URL::to('/js/checkout.js') }}"></script>
@endsection