@extends('backend.layouts.backend-master')

@section('title')
   Order|Ad Launcher
@endsection

@section('content')
   <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">

   <div class="row">
       <div class="col-md-12">
           <div class="page-header">
            @PHP
                $cartt = (array)unserialize($orders['cart']);
                $addressFormat = explode(' ', $orders['address']);
                $order_id = $orders['id']
            @ENDPHP
            <h2>Order #{{$orders['id']}}</h2>
           </div>
       </div>

       <div class="col-sm-9">
            <div class="row">
                <div class="col-md-12">
                    <div class="panel panel-primary">
                        <div class="panel-heading" style="text-align: right;">
                            <strong>Date:</strong>&emsp;{{$orders['updated_at']}}
                        </div>
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table table-bordered responsive">
                                    <thead>
                                        <tr>
                                        <td><strong>Image</strong></td>
                                            <td><strong>Product</strong></td>
                                            <td class="text-center"><strong>Price</strong></td>
                                            <td class="text-center"><strong>Quantity</strong></td>
                                            <td class="text-center"><strong>Order Status</strong></td>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($cartt['items'] as $cart)
                                         @PHP
                                            $key = array_search($cart, $cartt['items']);
                                            $category = explode('_', $key);
                                         @ENDPHP
                                        <tr>
                                        <td><img class="" src="{{asset('images/'.$category[0].'/'.$cart['item']['image'])}}" style="width: 72px; height: 72px;"></td>
                                            <td>
                                                <div class="">
                                                      
                                                     <div class="">
                                                         <h4 class=""> {{$cart['item']['title']}}|{{ucwords(str_replace('_', ' ', substr($cart['item']['price_key'],6)))}}</h4>
                                                         <h5 class=""> {{$key}}</h5>
                                                     </div>
                                                </div>
                                            </td>
                                            <td class="text-center">Rs.{{$cart['price']}}</td>
                                            <td class="text-center">{{$cart['qty']}}</td>
                                            <td>
                                                <div>

                                                <?php
                                                    switch($orders['order_status']){
                                                        case 'Pending':
                                                            $progress = '50';
                                                            $color='orange';
                                                        break;
                                                        case 'Completed':
                                                            $progress = '100';
                                                            $color='green';
                                                        break;
                                                        case 'Processing':
                                                            $progress = '30';
                                                            $color='yellow';
                                                        break;
                                                        case 'Cancelled':
                                                            $progress = '100';
                                                            $color='red';
                                                        break;
                                                    };
                                                ?>
                                                  <div class="progress">
                                                       <div class="progress-bar" role="progressbar" aria-valuenow="{{$progress}}" aria-valuemin="0" aria-valuemax="100" style="width: {{$progress}}%; background-color: {{$color}}">
                                                        
                                                        </div>
                                                        
                                                  </div>
                                                </div>  
                                                
                                            </td>
                                        </tr>
                                       
                                      @endforeach
                                        
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
       </div>

       <div class="col-md-3">
            <div class="address">
                <div class="row">
                    <div class="col-md-12">
                        <div class="panel panel-primary">
                            <div class="panel-heading">
                                <strong>Billing Address:</strong>
                            </div>
                            <div class="panel-body">
                                <br>
                               <strong>Name: </strong><br>{{strtoupper($orders['name'])}}<br>
                               <hr>
                               <address>
                                <strong>Address:</strong><br> {{$addressFormat[0]}} {{$addressFormat[1]}}<br>
                                {{$addressFormat[2]}} {{$addressFormat[3]}}<br>
                                </address>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


            <div class="payment-summary">
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        <strong>Payment Summary:</strong>
                    </div>
                    <div class="panel-body">
                        <br>
                        <strong>Order Total: </strong>Rs.{{money_format($cartt['totalPrice'])}}<br>
                        <address>
                        <strong>Paid By:</strong>  {{ucfirst($orders['payment_method'])}}<br>
                        </address>
                    </div>
                </div>
            </div>

            <div class="status">
                <div class="row">
                    <div class="col-md-12">
                        <div class="panel panel-primary">
                            <div class="panel-heading">
                                <strong>Change Status:</strong>
                            </div>

                            <?php
                                switch($orders['order_status']){
                                    case 'Pending':
                                        $fonticon = 'fa-clock-o';
                                    break;
                                    case 'Completed':
                                        $fonticon = 'fa-check-square';
                                    break;
                                    case 'Processing':
                                        $fonticon = ' fa-hourglass-start';
                                    break;
                                    case 'Cancelled':
                                        $fonticon = 'fa-close';
                                    break;
                                };
                            ?>

                            <div class="panel-body">
                                <div class="form-group">
                                    <label for="orderstatus">Order Status</label>
                                    <div class="editstatus1" onclick="showStatusOptions(1, {{$order_id}})"><i class="fa {{$fonticon}} edit"  aria-hidden="true"></i> {{$orders['order_status']}}</div>
                                    <select class="form-control selectform1" style="display:none">
                                    @foreach($orderStatus as $key => $value)
                                    <option value="{{$key}}" @PHP if($orders['order_status'] === $key){ echo "selected=selected"; } @ENDPHP>{{$value}}</option>
                                    @endforeach
                                </select>
                                </div>
                                <hr>
                                <div class="form-group">
                                    <label for="paymentstatus">Payment Status</label>
                                    <div class="editstatus2" onclick="showStatusOptions(2, {{$order_id}})"><i class="fa fa-clock-o edit"  aria-hidden="true"></i> {{$orders['payment_status']}}</div>
                                    <select class="form-control selectform2" style="display:none">
                                        @foreach($paymentStatus as $key => $value)
                                        <option value="{{$key}}" @PHP if($orders['payment_status'] === $key){ echo "selected=selected"; } @ENDPHP>{{$value}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
       </div>
   </div>

      
    </div>
@endsection
@section('scripts')
	<script>
	let OrderStatusURL = "{{route('order.statusChange')}}";
	</script>
@endsection

