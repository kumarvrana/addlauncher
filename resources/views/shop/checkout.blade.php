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

                    <form action="{{ route('postpayment') }}" method="post" id="checkout-form" class="form-horizontal">
                        
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
                                                <h3>
                                                {{ $product['item']['title'] }} | {{ ucwords(str_replace('_', ' ', substr($product['item']['price_key'], 6)))}}
                                                </h3>
                                                <hr>
                                                </div>

                                                <div class="col-xs-12 c-quant">
                                                    <h4>Quantity :<small> 1</small></h4> 
                                                </div>
                                                <div class="col-xs-12 c-detail">
                                                <h4>Product Details : <small> {{ strip_tags($product['item']['description']) }}</small></h4></div>
                                            </div>
                                        </div>
                                        <div class="col-sm-3 col-xs-3 text-right c-price">
                                            <h4>Rs. {{$product['item']['price_value']}}</h4>
                                            <h5><a href="{{route('Cart.removeItemCart', ['id' => $key])}}" >Delete Product From Cart</a> </h5>
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
                        

                       
                            <div class="payment-methods">
                                <div class="panel panel-cart">
                                    <div class="panel-heading">
                                       Select Payment Method 
                                    </div>
                                </div>  
                                <div class="method">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <input type="radio" name="payment-method" checked="checked" data-paymentform="cash-transfer" value="Transfer Money" id="transfer" class="payment-method-btn cash-transfer input-hidden cart-rad" />
                                            <label for="transfer">
                                                <img  src="{{asset('images/logo/m-transfer.jpg')}}" alt="I'm sad" />
                                            </label>
                                        </div>

                                        <div class="col-md-4">
                                            <input  type="radio" name="payment-method" data-paymentform="stripe-payment-form" value="Stripe Payment"  id="stripe" class="payment-method-btn stripe input-hidden cart-rad" />
                                            <label for="stripe">
                                                <img  src="{{asset('images/logo/Stripe.png')}}" alt="I'm happy" />
                                            </label>
                                        </div>
                                        
                                        <div class="col-md-4">
                                           <input   type="radio" name="payment-method" data-paymentform="cirtus-payment-form" value="Cirtus Payment" id="citrus" class="payment-method-btn cirtus input-hidden cart-rad" />
                                            <label for="citrus">
                                                <img src="{{asset('images/logo/cirtus.jpg')}}" alt="I'm happy" />
                                            </label> 
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <hr/>
                            {{csrf_field()}}
                        <input type="submit" class="btn btn-primary pull-right" name="stepCheckout-1" value="Procced To Payment">
                        </br>
                    </form>  
                </div>
                 
            </div>
        </div>
       
@endsection

