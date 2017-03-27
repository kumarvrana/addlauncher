@extends('layouts.master')

@section('title')
    Checkout|Add Launcher 
@endsection

@section('content')
    <style>
    #cardNumber,#cvv,#expiry{
        height:25px;
        border:1px solid black;
        border-radius:5px;
        margin:5px 0;
    }

    div.citrus-hosted-field-focused{
       border: 1px solid #a4d8ff!important;
       color:#414042!important;
   }
   div.citrus-hosted-field-invalid{
       border:1px solid red!important;
   }
   div.citrus-hosted-field-valid{
       border:1px solid green!important;
   }
   div.citrus-hosted-field-focused.citrus-hosted-field-valid{
       border:1px solid green!important;
   }
</style>


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

                        @PHP 

                            $setting = unserialize($settings->payment_secret);
                        
                            $secret_key = $setting['secretkey']; 
                            $access_key = $setting['accesskey'];
                            $vanityUrl = $setting['vanityurl'];
                            $txnID = uniqid();
                            $currency = "INR";
                            $data = "merchantAccessKey=$access_key&transactionId=$txnID&amount=1";
                            
                            $returnURL = "{{route('paymentBycirtus')}}";
                            $notifyUrl = "{{route('paymentBycirtus')}}";
                            $signature = hash_hmac('sha1', $data, $secret_key);
                                
                       @ENDPHP
                        <!--CREDIT CART PAYMENT-->
                            <div class="payment-nav" >
                                <div class="panel panel-cart">
                                    <div class="panel-heading"><span><i class="glyphicon glyphicon-lock"></i></span> Choose Payment Option</div>

                                    <div class="panel-body">
                                    <a onclick="selectedPG('card-panel')" class="btn btn-primary">
                                    Card Payment
                                    </a>
                                    <a onclick="selectedPG('netbanking-panel')" class="btn btn-primary">
                                        Net Banking
                                    </a>
                                    </div>
                                </div>    
                                
                                
                            </div>
                            <!-- card mode -->
                            <div class="panel panel-cart pg" id="card-panel" style="display:none;">
                                <div class="panel-heading"><span><i class="glyphicon glyphicon-lock"></i></span> Secure Payment</div>
                                <div class="panel-body">
                                <div class="form-group">
                                        <div class="col-md-12"><strong>Card Holder Name:</strong></div>
                                        <div class="col-md-12"><input type="text" id="cardHolderName" name="cardHolderName" class="form-control" required/></div>
                                    </div>
                                <div id="cardNumber"></div>
                                <div id="expiry"> </div>
                                <div id="cvv"></div>
                              

                                    {{csrf_field()}}
                                    <input type="hidden" readonly id="vanityUrl" name="vanityUrl" value="{{$vanityUrl}}" />
                                    <input type="hidden" readonly id="amount" name="orderAmount" value="1" />
                                    <input type="hidden" readonly id="currency" name="currency" value="{{$currency}}" />
                                    <input type="hidden" readonly id="merchantAccessKey" name="merchantAccessKey" value="{{$access_key}}" />
                                    <input type="hidden" readonly id="merchantTxnId" name="merchantTxnId" value="{{$txnID}}" />
                                    <input type="hidden" readonly id="requestSignature" name="secSignature" value="{{$signature}}" />
                                    <input type="hidden" readonly id="returnUrl" name="returnUrl" value="{{route('paymentBycirtus')}}" />
                                    <input type="hidden" readonly id="notifyUrl" value="{{route('paymentBycirtus')}}" />
                                    <div class="form-group">
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                          
                                            <button type="button" class="btn btn-primary" id="cardPayButton">Pay Now</button>
                                            
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- end card mode -->
                            <!-- netbanking mode -->
                            <div class="panel panel-cart pg" id="netbanking-panel" style="display:none;">
                                <div class="panel-heading"><span><i class="glyphicon glyphicon-lock"></i></span> Secure Payment</div>
                                <div class="panel-body">
                             <select class="form-control select-another" id="netbankingBanks">
                                    <option value="">Select Another Bank</option>
                                    </select>
                                <button type="button" class="btn btn-primary" id="netbankingButton">Pay Now</button>
                                </div>
                            </div>
                            
                             <!-- end netbanking mode -->
                            <!--CREDIT CART PAYMENT END-->


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
                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 col-md-pull-6 col-sm-pull-6" id="cirtus-payment-form">
                            <!--SHIPPING METHOD-->
                            <input type="hidden" name="payMethod" value="{{$payMethod}}">
                            <div class="panel panel-cart">
                                <div class="panel-heading">Address</div>
                                <div class="panel-body">
                                   
                                    
                                    <div class="form-group">
                                        <div class="col-md-12">
                                            <strong>Name:</strong>
                                        </div>
                                        <div class="col-md-12">
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
                                        <div class="col-md-12"><strong>Country:</strong></div>
                                        <div class="col-md-12">
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
                            <!--SHIPPING METHOD END-->
                           
                            
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
   
    <script src="https://mocha.citruspay.com/js/lib/citrus.min.js"> </script>
    <script src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.13.1/jquery.validate.js"></script>
    <script type="text/javascript" src="{{ URL::to('/js/checkout-cirtus.js') }}"></script>
@endsection