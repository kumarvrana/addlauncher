@extends('layouts.master')

@section('title')
    Thank You|Add Launcher 
@endsection

@section('content')
        <div class="container wrapper">
        <div class="thank-bg">
            <div class="row">
                <div class="col-md-12">
                    <div class="thank-title">
                        <h3>Thank You For Ordering With Us!</h3></hr>
                    </div> 
                </div>

                @if($orders['payment_method']=='cash transfer')

                   <div class="col-md-12">
                       <div class="payment-nav" >
                                
                                <div class="online-payment">
                                    <div class="sub-content">
                                        <div class="panel panel-cart">
                                            <div class="panel-heading text-center">
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
                                    
                                   
                                </div>
                            </div>
                   </div>
                   <hr>
                @endif    

                <div class="col-md-12">
                <div class="panel panel-cart">
                                            <div class="panel-heading text-center">
                                                Order Summary
                                            </div>
                                        </div> 
                    <div class="row">

                        <div class="col-md-6">
                            <h3 class="text-info"><small>Order ID</small>  #{{$orders['id']}}</h3>
                            
                        </div>

                        <div class="col-md-6" style="text-align: right;">
                            
                            <h4>Payment By- <strong>{{ucfirst($orders['payment_method'])}}</strong></h4>

                            
                        </div>

                    </div>
                </div>
            </div>
            <hr>
            <!-- <div class="order-info"> -->

           
               @if($orders)
               @PHP
                    $cart = unserialize($orders['cart']);
                    $items = $cart->items;
               @ENDPHP
                        
                           <table id="cart" class="table">
                            <thead>
                                <tr> 
                                     <th class="im"></th>
                                     <th class="pn">Product</th>
                                      <th>Order Status</th>
                                      <th>Quantity</th>
                                      <th>Price</th>
                                      <th>Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($items as $item)
                                @PHP
                                    $key = array_search($item, $items);
                                    $imagefolder = explode('_', $key);
                                    //$totalPrice += $item['price']

                                @ENDPHP

                                @if($imagefolder[1]==='tricycle')
                                <tr>
                                    <td><img src="{{asset('images/'.$imagefolder[0].'/'.$item['item']['image'])}}" class="img-responsive"/></td>
                                    <td>{{$item['item']['title']}}</td>
                                    <td>{{$orders['order_status']}}</td>
                                    <td>{{$item['qty']}}</td>
                                    <td>Rs. {{$item['price']}}</td>
                                    <td>Rs. {{$item['price']}}</td>
                                </tr>
                                @else
                                
                                <tr>
                                @PHP
                                    if($imagefolder[0] == 'billboards') $imagefolder[0] = 'outdooradvertising';
                                @ENDPHP
                                    <td><img src="{{asset('images/'.$imagefolder[0].'/'.$item['item']['image'])}}" class="img-responsive"/></td>
                                    <td><strong style="color: navy">{{$item['item']['title']}}</strong></td>
                                    <td>{{$orders['order_status']}}</td>
                                    <td>{{$item['qty']}}</td>
                                    @if($imagefolder[0] == 'televisions')
                                    <td>Rs. {{$item['item']['rate_value']}}</td>
                                    @elseif($imagefolder[0] == 'airports')
                                    <td>Rs. {{$item['item']['optionprice']}}</td>
                                    @elseif($imagefolder[0] == 'metros')
                                    <td>Rs. {{$item['item']['totalprice']}}</td>
                                    @else
                                    <td>Rs. {{$item['item']['price_value']}}</td>
                                    @endif
                                    <td>Rs. {{$item['price']}}</td>
                                </tr>
                                @endif
                                @endforeach
                                
                                <tr>
                                    
                                    <td>
                                    
                                    <h4>Billing Address :</h4><br>
                                    {{$orders['address']}}
                                    
                                    </td> 
                                    <td colspan="2" class="hidden-xs"></td>
                                    <!-- <td></td>
                                    <td></td> -->
                                    <td colspan="4"><div class="">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <h4>GRAND TOTAL</h4>
                                        </div>
                                        <div class="col-md-6">
                                            <h4 class="cart-total"><strong class="text-danger">Rs. {{number_format($cart->totalPrice,2)}}</strong></h4>
                                        </div>
                                       
                                    </div>
                                </div></td>
                                    
                                </tr>

                                </tbody>

                            </table>
                           
                    <!-- </div> -->
                <!-- </div> -->
                @endif
            </div>
          </div>

@endsection
