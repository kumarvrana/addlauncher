@extends('layouts.master')

@section('title')
    Checkout|Add Launcher 
@endsection

@section('content')

<section class="sec-banner">
    <div class="jumbotron jumbo-1 text-center">
        <h1> Checkout</h1>
    </div>
</section>    

        <div class="container-fluid">
            <div class="row cart-body">
                

                <div class="col-md-8 col-md-offset-2 wrapper">
                
                    <div id="charge-error" class="alert alert-danger {{ !Session::has('error') ? 'hidden' : '' }}">
                        {{ Session::get('error') }}
                    </div>

                   
                               
                   

                    <!-- ==================checkout-content========== -->
        <section id="checkout-content">
         <form action="{{route('postCheckout')}}" method="post" id="checkout-form" class="form-horizontal">
        
            <div class="container">
                <div class="row">
                    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 left-checkout" style="padding-left:0px;">
                        <div class="section-title">
                            <h2>billing details</h2>
                        </div>
                        <div id="charge-error" class="alert alert-danger {{ !Session::has('message') ? 'hidden' : '' }}">
                            {{ Session::get('message') }}
                        </div>
                        <div class="row">
                            <div class="col-lg-6" style="padding-left:0px;">
                                <label>First Name <span>*</span></label>
                                <input type="text" placeholder="First Name" value="{{old('first-name')}}" name="first-name" required>
                            </div>
                            <div class="col-lg-6 left_position_fix">
                                <label>Last Name <span>*</span></label>
                                <input type="text" placeholder="Last Name" value="{{old('last-name')}}" name="last-name" required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12" style="padding-left:0px;">
                                <label>Company Name</label>
                                <input type="text" placeholder="Company Name" value="{{old('company-name')}}" name="company-name" required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12" style="padding-left:0px;">
                                <label>Address <span>*</span></label>
                                <input type="text" placeholder="Street address" name="street" required>
                                <input type="text" placeholder="Apartment, Suit unit etc (optional)" name="address" required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12" style="padding-left:0px;">
                                <label>Town / City <span>*</span></label>
                                <input type="text" placeholder="Town / City" name="city" required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-6" style="padding-left:0px;">
                                <label>State / Country <span>*</span></label>
                                <input type="text" placeholder="State / Country" name="country" required>
                            </div>
                            <div class="col-lg-6 left_position_fix">
                                <label>Postcode / Zip <span>*</span></label>
                                <input type="text" placeholder="Postcode / Zip" name="zip-code" required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-6" style="padding-left:0px;">
                                <label>Email Address <span>*</span></label>
                                <input type="email" placeholder="Email Address" name="email" required>
                            </div>
                            <div class="col-lg-6 left_position_fix">
                                <label>Phone <span>*</span></label>
                                <input type="text" placeholder="Phone" name="phone" required>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-lg-12" style="padding-left:0px;">
                                <label>Order Notes</label>
                                <textarea placeholder="Note about your order. e.g. special note for delivery"></textarea>
                            </div>
                        </div>
                        
                    </div>
                    <div class="col-lg-5 col-md-5 col-sm-12 col-xs-12 col-lg-offset-1 col-md-offset-1 col-sm-offset-0 col-xs-offset-0">
                        <div class="section-title">
                            <h2>your order</h2>
                        </div>
                        <div class="row">
                            <div class="col-lg-12 order-box">
                                <ul>
                                <li><strong>PRODUCT <span>TOTAL</span></strong></li>
                                @if($products)
                                    @foreach( $products as $product)
                                        @PHP
                                            $key = array_search($product, $products);
                                            $imagefolder = explode('_', $key);
                                        @ENDPHP

                                        @if($imagefolder[1] == 'tricycle')
                                        <li><strong>{{ $product['item']['title'] }}</strong> <span><i class="fa fa-inr"></i> {{$product['item']['price']}}</span></li>
                                        @else

                                        @PHP
                                        if($imagefolder[0] == 'billboards') $imagefolder[0] = 'outdooradvertising';
                                        @ENDPHP
                                            
                                        @if($imagefolder[0] == 'televisions')    
                                            <li><strong>{{ $product['item']['title'] }} | {{ ucwords(str_replace('_', ' ', substr($product['item']['rate_key'], 5)))}}</strong> <span><i class="fa fa-inr"></i> {{$product['item']['rate_value']}}</span></li>
                                        @elseif($imagefolder[0] == 'airports')
                                            <li><strong>{{ $product['item']['title'] }} | {{ $product['item']['displayoption']}}</strong> <span><i class="fa fa-inr"></i> {{$product['item']['optionprice']}}</span></li>
                                        @elseif($imagefolder[0] == 'metros')
                                            <li><strong>{{ $product['item']['title'] }} | {{ $product['item']['price_key']}}</strong> <span><i class="fa fa-inr"></i> {{$product['item']['totalprice']}}</span></li>
                                        @else
                                            <li><strong>{{ $product['item']['title'] }} | {{ ucwords(str_replace('_', ' ', substr($product['item']['price_key'], 6)))}}</strong> <span><i class="fa fa-inr"></i> {{$product['item']['price_value']}}</span></li>
                                        @endif
                                        @endif
                                    @endforeach
                                    <li class="total">TOTAL <span class="bold"><i class="fa fa-inr"></i> {{ $total }}</span></li>
                                         
                                @endif
                                    <li><input type="radio" name="adl-payment" id="bank-button" value="cash-transfer"> <label for="bank-button">Direct Bank Payment</label>
                                        <div class="note">
                                            <div class="i fa fa-caret-up"></div>
                                            Make your payment directly into our bank account. Please use your Order ID as the payment reference. Your order won’t be shipped until the funds have cleared in our account.
                                        </div>
                                    </li>
                                 
                                    <li><input type="radio" name="adl-payment" value="stripe-payment" id="stripe-button"> <label for="stripe-button">Stripe</label> <img src="{{asset('images/stripepayment.png')}}" alt="image" style="margin-left:12px; width: 120px;"> <a href="#"><span>What is Stripe?</span></a></li>
                                    {{csrf_field()}}
                                    <hr>
                                    <li><input type="submit" id="adl-place-order" class="btn btn-primary place-order fa fa-arrow-circle-right" value="Place Order"></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
             </form>  
        </section>
                </div>
                 
            </div>
        </div>
       
@endsection
<script src="https://checkout.stripe.com/checkout.js"></script>
@section('scripts')
<script>
var handler = StripeCheckout.configure({
  key: 'pk_test_eNjlkOTxW9sl5bwZQLcjLrav',
  image: "<?= asset('images/logo/'.$general->logo) ?>",
  locale: 'auto',
  currency: 'INR',
  token: function(token) {
        $("#checkout-form").append("<input type='hidden' name='stripeToken' value='" + token.id + "' />");
  }
});

document.getElementById('stripe-button').addEventListener('click', function(e) {
  
  handler.open({
    name: 'addlauncher.com',
    description: 'Book your space for ad!',
    amount: "<?= $total * 100?>"
  });
  //e.preventDefault();
});
$(".ModalContainer").on('click', '.Header-navClose', function(){
    alert('343');
    $("#stripe-button").prop('checked', false);
});
// Close Checkout on page navigation:
window.addEventListener('popstate', function() {
    
    handler.close();
});
</script>
@endsection