@extends('layouts.master')

@section('title')
    Thank You|Add Launcher 
@endsection

@section('content')
        <div class="container wrapper">
            <div class="section-title">
                <h2>Thank You For Ordering With Us!</h2></hr>
            </div> 
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
                                    <td>{{$item['item']['title']}}</td>
                                    <td>{{$orders['order_status']}}</td>
                                    <td>{{$item['qty']}}</td>
                                    <td>Rs. {{$item['item']['price_value']}}</td>
                                    <td>Rs. {{$item['price']}}</td>
                                </tr>
                                @endif
                                @endforeach
                                
                                <tr>
                                    
                                    <td>
                                    
                                    <strong>Billing Address :</strong><br>
                                    {{$orders['address']}}
                                    
                                    </td> 
                                    <td colspan="2" class="hidden-xs"></td>
                                    <!-- <td></td>
                                    <td></td> -->
                                    <td colspan="4"><div class="pr-chk">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <h4>GRAND TOTAL</h4>
                                        </div>
                                        <div class="col-md-6">
                                            <h4 class="cart-total">Rs. {{$cart->totalPrice}}</h4>
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
            <!-- <div class="online-payment">
                <div class="sub-content">
                <h3>Online Payment</h3>
                <div class="description-cashpayment">
                    - Mention your brand name in description section Cheque Payment
                    - Send us a scanned copy of the cheque to info@addlauncher.com and courier the cheque to:
                    Adlauncher, Best Sky Tower, NSP, Pitampura - 110034 phone no: +011-4557685
                </div>
                <div class="bank-details">
                    Bank Name   HDFC Bank
                    Account Name    Adlauncher
                    Account Number  account-number
                    Account Type    Current Account
                    IFSC    ifsc-code
                </div>
            </div>
        </div> -->

@endsection
