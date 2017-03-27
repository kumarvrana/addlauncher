@extends('backend.layouts.backend-master')

@section('title')
   Order|Ad Launcher
@endsection

@section('content')
   <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
          <div class="row">
        <div class="col-md-12">
        	<div class="invoice-title">
            @PHP
                $cartt = (array)unserialize($orders['cart']);
                $addressFormat = explode(' ', $orders['address']);
				$order_id = $orders['id']
            @ENDPHP
    			<h2>Order #{{$orders['id']}}</h2>
				<div class="pull-right">
				<div class="form-group">
					<label for="orderstatus">Order Status</label>
					<div class="editstatus1">{{$orders['order_status']}}<i class="fa fa-pencil edit" onclick="showStatusOptions(1, {{$order_id}})" aria-hidden="true"></i></div>
					<select class="form-control selectform1" style="display:none">
                    @foreach($orderStatus as $key => $value)
                    <option value="{{$key}}" @PHP if($orders['order_status'] === $key){ echo "selected=selected"; } @ENDPHP>{{$value}}</option>
                    @endforeach
                </select>
				</div>
                <div class="form-group">
					<label for="paymentstatus">Payment Status</label>
					<div class="editstatus2">{{$orders['payment_status']}}<i class="fa fa-pencil edit" onclick="showStatusOptions(2, {{$order_id}})" aria-hidden="true"></i></div>
				
					<select class="form-control selectform2" style="display:none">
						@foreach($paymentStatus as $key => $value)
						<option value="{{$key}}" @PHP if($orders['payment_status'] === $key){ echo "selected=selected"; } @ENDPHP>{{$value}}</option>
						@endforeach
					</select>
				</div>
            </div>	
    		<hr>
            
    		</div>
    		<div class="row">
    			<div class="col-xs-6">
    				<address>
    				<strong>Billed To:</strong><br>
                        {{$orders['name']}}<br>
    					{{$addressFormat[0]}} {{$addressFormat[1]}}<br>
    					{{$addressFormat[2]}} {{$addressFormat[3]}}
    					
    				</address>
    			</div>
    			<div class="col-xs-6 text-right">
    				<address>
        			<strong>Shipped To:</strong><br>
    					{{$orders['name']}}<br>
    					{{$addressFormat[0]}} {{$addressFormat[1]}}<br>
    					{{$addressFormat[2]}} {{$addressFormat[3]}}
    				</address>
    			</div>
    		</div>
    		
    	</div>
    </div>
    
    <div class="row">
    	<div class="col-md-12">
    		<div class="panel panel-default">
    			<div class="panel-heading">
    				<h3 class="panel-title"><strong>Order placed on {{$orders['updated_at']}}</strong></h3>
    			</div>
    			<div class="panel-body">
    				<div class="table-responsive">
    					<table class="table table-condensed">
    						<thead>
                                <tr>
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
    								<td class="col-md-3">
    								    <div class="media">
    								         <a class="thumbnail pull-left" href="#"> <img class="media-object" src="{{asset('images/'.$category[0].'/'.$cart['item']['image'])}}" style="width: 72px; height: 72px;"> </a>
    								         <div class="media-body">
    								             <h4 class="media-heading"> {{$cart['item']['title']}}|{{ucwords(str_replace('_', ' ', substr($cart['item']['price_key'],6)))}}</h4>
    								             <h5 class="media-heading"> {{$key}}</h5>
    								         </div>
    								    </div>
    								</td>
    								<td class="text-center">Rs.{{$cart['price']}}</td>
    								<td class="text-center">{{$cart['qty']}}</td>
    								<td>
    								  <div class="col-md-13">
        								  <div class="progress">
        								       <div class="progress-bar" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: 60%;">
        								           <span class="sr-only">60% Complete</span>
        								        </div>
        								        <span class="progress-type">Packaging</span>
        								        <span class="progress-completed">61%</span>
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
    
    <div class="row">
         <div class="col-md-12">
            <div class="col-md-4">
            	<h3 class="text-center">Order Summary</h3><hr>
            	<!--div class="pull-left"><h4>Subtotal</h4> </div>
            	<div class="pull-right"><h4 class="text-right">$11.99</h4></div>
            	<div class="clearfix"></div>
            	<div class="pull-left"><h4>Tax</h4> </div>
            	<div class="pull-right"><h4 class="text-right">$1.99</h4></div>
            	<div class="clearfix"></div-->
            	<div class="pull-left"><h4>Order Total</h4> </div>
            	<div class="pull-right"><h4 class="text-right">Rs.{{money_format($cartt['totalPrice'])}} </h4></div>
            	<div class="clearfix"></div>
        	</div>
        	<div class="col-md-4 offset-md-1">
            	<h3 class="text-center">Payment Type</h3><hr>
            	<div class="text-center">
            	    <strong>Paid by {{ucfirst($orders['payment_method'])}}</strong><br>
            	 </div>
        	</div>
        	<div class="col-md-4 offset-md-2">
            	<h3 class="text-center">Other Info</h3><hr>
            	<address>
            	    <strong>Billed To:</strong><br>
            	    {{$orders['name']}}<br>
    				{{$addressFormat[0]}} {{$addressFormat[1]}}<br>
    				{{$addressFormat[2]}} {{$addressFormat[3]}}
            	 </address>
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

