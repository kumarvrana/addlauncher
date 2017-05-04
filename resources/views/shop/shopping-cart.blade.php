@extends('layouts.master')

@section('title')
    Shop Cart | Add Launcher
@endsection

@section('content')
<div class="container-fluid">
	<div class="row cart-body">
		

        <div class="col-md-8 col-md-offset-2 wrapper form-box">
            <div class="section-title">
                <h2>Shopping Cart</h2>
            </div>
               <form role="form" class="registration-form" action="javascript:void(0);">
               <fieldset>
                       
                        <div class="form-bottom">
                        
                            <div class="row">
                                
                       
                                
                            
			@if(Session::has('cart'))
   				@if(count($products) > 0)
				<table class="table table-cart">
    				<thead>
						<tr>
							<th class="sr">#</th>
							<th class="im">Image</th>
							<th class="pn">Product Name</th>
							
                            <th class="pr">Price</th>
							<th class="tl">Total</th>
							<th class="rm">Remove</th>
						</tr>
					</thead>
					<tbody>
					@PHP
						$i = 1;
						
					@ENDPHP
                     @foreach( $products as $product)
                     
						<tr >
                        @PHP
                            $key = array_search($product, $products);
                            $imagefolder = explode('_', $key);
							
                        @ENDPHP
						@if($imagefolder[1] === 'tricycle')
                        	<td data-th="Number" class="sr">{{$loop->iteration}}</td>
                        	<td data-th="Image" class="im">
                        		<img src="{{asset('images/'.$imagefolder[0].'/'.$product['item']['image'])}}" alt="{{ $product['item']['title'] }}" class="img-responsive"/>
                        	</td>
							<td data-th="Product" class="pn">
								<div class="row">
									
									<div class="col-sm-12 c-title">
										<h4 class="nomargin">{{ $product['item']['title'] }} {{$imagefolder[1]}} </h4>
									</div>
									<div class="col-sm-12 c-detail">
                                        <h5>Product Details : <small> {{substr (strip_tags($product['item']['description']), 0,100)}}</small></h5>
                                    </div>
								</div>
							</td>
							
							
							
                            <td data-th="Price" class="pr">Rs.{{$product['item']['price']}}</td>
							<td data-th="Subtotal" class="text-center subtotal-{{$i}}  tl" data-subtotal="{{$product['price']}}"><h4>Rs. {{$product['price']}}</h4></td>
							<td class="actions rm" data-th="">
								<!-- <a href="{{route('cart.shoppingCart')}}" class="btn btn-info btn-block"><i class="fa fa-refresh"></i></a> -->
								<a href="{{route('Cart.removeItemCart', ['id' => $key])}}"><img src="{{asset('images/trash.png')}}" class="img-responsive trash-img"></i></a>								
							</td>
						</tr>
						
						@else
							<td data-th="Number" class="sr">{{$loop->iteration}}</td>
                        	<td data-th="Image" class="im">
								@PHP
									if($imagefolder[0] == 'billboards') $imagefolder[0] = 'outdooradvertising';
								@ENDPHP
								
                        		<img src="{{asset('images/'.$imagefolder[0].'/'.$product['item']['image'])}}" alt="{{ $product['item']['title'] }} | {{ ucwords(str_replace('_', ' ', substr($product['item']['price_key'], 6)))}}" class="img-responsive"/>
                        	</td>
							<td data-th="Product" class="pn">
								<div class="row">
									
									<div class="col-sm-12 c-title">
										<h4 class="nomargin">{{ $product['item']['title'] }} | {{ ucwords(str_replace('_', ' ', substr($product['item']['price_key'], 6)))}}{{$imagefolder[1]}}</h4>
									</div>
									<div class="col-sm-12 c-detail">
                                        <h5>Product Details : <small> {{substr (strip_tags($product['item']['description']), 0,100)}}</small></h5>
                                    </div>
								</div>
							</td>
							
							
                            <td data-th="Price" class="pr">Rs.{{$product['item']['price_value']}}</td>
							<td data-th="Subtotal" class="text-center subtotal-{{$i}}  tl" data-subtotal="{{$product['price']}}"><h4>Rs. {{$product['price']}}</h4></td>
							<td class="actions rm" data-th="">
							
								<a href="{{route('Cart.removeItemCart', ['id' => $key])}}"><img src="{{asset('images/trash.png')}}" class="img-responsive trash-img"></i></a>								
							</td>
						</tr>
						@endif
						@PHP
							$i++;
						@ENDPHP
                        @endforeach
					</tbody>
					<tfoot>
						<tr class="visible-xs">
							<td class="text-center c-total"><h3><span>Total </span> <div class="cart-total">Rs.{{ $totalPrice }}</div></h3></td>
						</tr>
						<tr>
							<td><a href="{{route('product.mainCats')}}" class="btn btn-info btn-cart"><i class="fa fa-angle-left"></i> Continue Shopping</a></td>
							<td colspan="3" class="hidden-xs"></td>
							<td colspan="3">
								<div class="pr-chk">
									<div class="row">
										<div class="col-md-6">
											<h4>GRAND TOTAL</h4>
										</div>
										<div class="col-md-6">
											<h4 class="cart-total">Rs. {{ $totalPrice }}</h4>
										</div>
										<div class="col-md-12">
                            				<button type="button" class="btn btn-info btn-block btn-cart btn-next ">Next <i class="fa fa-angle-right"></i></button>

											
										</div>
									</div>
								</div>
							</td>
								
						</tr>
					</tfoot>
				</table>
                @else
                <div class="row">
                        <div class="col-md-8 col-md-offset-2 ">
                            <img src="{{asset('images/emptycart.jpg')}}" class="img-responsive">
                        </div>
                </div>
                @endif
                @else
                <div class="row">
                        <div class="col-md-8 col-md-offset-2 ">
                            <img src="{{asset('images/emptycart.jpg')}}" class="img-responsive">
                            
                        </div>
                </div>
            @endif
            </div>
                            
                            
                        </div>
                    </fieldset>



                    <!-- second option starts here -->


                    <fieldset>
                        
                        <div class="form-bottom">
                            
                            
                            @if(Session::has('cart'))
   				@if(count($products) > 0)   				
				<table id="adl-cart-table" class="table table-cart">

    				<thead>
						<tr>
							<th class="sr">#</th>
							<th class="pn">Product Name</th>
							
							<th class="qt">Quantity</th>
                            <th class="pr">Duration</th>
							<th class="tl">Total</th>
							<th class="rm">Remove</th>
						</tr>
					</thead>
					<tbody>
					@PHP
					

						$j = 1;
						
					@ENDPHP
                     @foreach( $products as $product)
						<tr >
                        @PHP
                            $key = array_search($product, $products);
                            $imagefolder = explode('_', $key);
							
                        @ENDPHP
						@if($imagefolder[1] === 'tricycle')
                        	<td data-th="Number" class="sr">{{$loop->iteration}}</td>
                        	
							<td data-th="Product" class="pn">
								<div class="row">
									
									<div class="col-sm-12 c-title">
										<h4 class="nomargin">{{ $product['item']['title'] }}</h4>
									</div>
									
								</div>
							</td>
							@if($imagefolder[0] == 'cinemas')
							<td data-th="length" class="qt">
							<select id="duration-{{$j}}" name="duration" data-index="{{$j}}" data-itemkey="{{$key}}" class="form-control">
                            	<option value="">Length</option>
                            	<option value="1">10 sec</option>
                            	<option value="2">20 sec</option>
                            	<option value="3">30 sec</option>
                            	<option value="4">40 sec</option>
                            	<option value="5">50 sec</option>
                            	<option value="5">60 sec</option>
                            </select>								
							</td>
							@else
									@if(($imagefolder[1] === 'tricycle'))
									
										<td data-th="Quantity" class="qt">
											<input type="number" id="quantity-{{$j}}" data-index="{{$j}}" data-itemkey="{{$key}}" name="quantity" class="form-control text-center change-cart" min="1" max="{{$product['item']['auto_number']}}" value="{{$product['qty']}}"><span class="error quantity-error-{{$j}}" style="display:none;color:red;">Max Limit Is {{$product['item']['auto_number']}}</span>
											<input type="hidden" id="quantity-hidden-{{$j}}" name="quantity-hidden" value="{{$product['item']['auto_number']}}">
										</td>
									@else
										<td data-th="Quantity" class="qt">
											<input type="number" id="quantity-{{$j}}" data-index="{{$j}}" data-itemkey="{{$key}}" name="quantity" class="form-control text-center change-cart" min="1" max="{{$product['item']['number_value']}}" value="{{$product['qty']}}"><span class="error quantity-error-{{$j}}" style="display:none;color:red;">Max Limit Is {{$product['item']['number_value']}}</span>
											<input type="hidden" id="quantity-hidden-{{$j}}" name="quantity-hidden" value="{{$product['item']['number_value']}}">
										</td>
									@endif
							
							
							@endif
							
							
							
                             <td data-th="duration" class="pr">
							 <select id="duration-{{$j}}" name="duration" data-itemkey="{{$key}}" data-index="{{$j}}" class="form-control change-cart">
                             <option value="" disabled>No of Days</option>
								@PHP	
									for($i=1;$i<=31;$i++) {
										if($i==1)
											echo "<option value=$i>$i Day</option>";
										else{
											if($i==$product['duration']){
												echo "<option  Selected value=$i>$i Days</option>";
											}else{
												echo "<option value=$i>$i Days</option>";
											} 
											
										}
									}

								@ENDPHP
                            </select></td>

                            

                           
							<td data-th="Subtotal" class="text-center subtotal-{{$j}}  tl" data-subtotal="{{$product['price']}}"><h4>Rs. {{$product['price']}}</h4></td>
							<td class="actions rm" data-th="">
								<a href="{{route('Cart.removeItemCart', ['id' => $key])}}"><img src="{{asset('images/trash.png')}}" class="img-responsive trash-img"></i></a>								
							</td>
						</tr>
						
						@else
							<td data-th="Number" class="sr">{{ $loop->iteration }}</td>
                        	
							<td data-th="Product" class="pn">
								<div class="row">
									
									<div class="col-sm-12 c-title">
										<h4 class="nomargin">{{ $product['item']['title'] }} | {{ ucwords(str_replace('_', ' ', substr($product['item']['price_key'], 6))) }}</h4>
									</div>
									
								</div>
							</td>
							@if($imagefolder[0] == 'cinemas')
							<td data-th="length" class="qt">
							<select id="duration-{{$j}}" name="duration" data-itemkey="{{$key}}" data-index="{{$j}}" class="form-control change-cart">
                            	<option value="">Length</option>
                            	<option value="1">10 sec</option>
                            	<option value="2">20 sec</option>
                            	<option value="3">30 sec</option>
                            	<option value="4">40 sec</option>
                            	<option value="5">50 sec</option>
                            	<option value="5">60 sec</option>
                            </select>							
							</td>
							@else
							<td data-th="Quantity" class="qt">
									<input type="number" id="quantity-{{$j}}" data-index="{{$j}}" data-itemkey="{{$key}}" name="quantity" class="form-control text-center change-cart" min="1" max="{{$product['item']['number_value']}}" value="{{$product['qty']}}"><span class="error quantity-error-{{$j}}" style="display:none;color:red;">Max Limit Is {{$product['item']['number_value']}}</span>
									<input type="hidden" id="quantity-hidden-{{$j}}" name="quantity-hidden" value="{{$product['item']['number_value']}}">
								</td>
					
							@endif

							@if($imagefolder[0] == 'newspapers' || $imagefolder[0] == 'televisions' || $imagefolder[0] == 'socialmedias' )
							<td data-th="duration" class="duration-hidden-{{$j}}">
									<select id="duration-{{$j}}" name="duration" data-itemkey="{{$key}}" data-index="{{$j}}" class="form-control change-cart">
									 <option value="" disabled>No of Days</option>
								@PHP	
									for($i=1;$i<=31;$i++) {
										if($i==1)
											echo "<option value=$i>$i Day</option>";
										else{
											if($i==$product['duration']){
												echo "<option  Selected value=$i>$i Days</option>";
											}else{
												echo "<option value=$i>$i Days</option>";
											} 
											
										}
									}

								@ENDPHP

                            	
                            </select>
								</td>
							
							@elseif($imagefolder[0] == 'cinemas')
							<td data-th="duration" class="duration-hidden-">
									<select id="duration-{{$j}}" data-itemkey="{{$key}}" data-index="{{$j}}" name="duration" class="form-control change-cart">
                            	 <option value="" disabled>No of Weeks</option>
								@PHP	
									for($i=1;$i<=5;$i++) {
										if($i==1)
											echo "<option value=$i>$i Week</option>";
										else{
											if($i==$product['duration']){
												echo "<option  Selected value=$i>$i Weeks</option>";
											}else{
												echo "<option value=$i>$i Weeks</option>";
											} 
											
										}
									}

								@ENDPHP
                            </select>
                            
								</td>
							@else
							<td data-th="duration" class="duration-hidden-">
									<select id="duration-{{$j}}" name="duration" data-itemkey="{{$key}}" data-index="{{$j}}" class="form-control change-cart">
                            	<option value="" disabled>No of Months</option>
								@PHP	
									for($i=1;$i<=12;$i++) {
										if($i==1)
											echo "<option value=$i>$i Month</option>";
										else{
											if($i==$product['duration']){
												echo "<option  Selected value=$i>$i Months</option>";
											}else{
												echo "<option value=$i>$i Months</option>";
											} 
											
										}
										
									}

								@ENDPHP
                            </select>


								</td>
					
							@endif
							
                            
							<td data-th="Subtotal" class="text-center subtotal-{{$j}}  tl" data-subtotal="{{$product['price']}}"><h4>Rs. {{$product['price']}}</h4></td>
							<td class="actions rm" data-th="">
								<a href="{{route('Cart.removeItemCart', ['id' => $key])}}"><img src="{{asset('images/trash.png')}}" class="img-responsive trash-img"></i></a>								
							</td>
						</tr>
						@endif
						@PHP
							$j++;
						@ENDPHP
                        @endforeach
					</tbody>
					<tfoot>
						<tr class="visible-xs">
							<td class="text-center c-total"><h3><span>Total </span> <div class="cart-total">Rs.{{ $totalPrice }}</div></h3></td>
						</tr>
						<tr>
							
							<td colspan="3" class="hidden-xs"></td>
							<td colspan="3">
								<div class="">
									<div class="row">
										<div class="col-md-6">
											<h4>GRAND TOTAL</h4>
										</div>
										<div class="col-md-6">
											<h4 class="cart-total">Rs. {{ $totalPrice }}</h4>
										</div>
										
									</div>
								</div>
							</td>
								
						</tr>
					</tfoot>
					
				</table>
                @else
                <div class="row">
                        <div class="col-md-8 col-md-offset-2 ">
                            <img src="{{asset('images/emptycart.jpg')}}" class="img-responsive">
                        </div>
                </div>
                @endif
                @else
                <div class="row">
                        <div class="col-md-8 col-md-offset-2 ">
                            <img src="{{asset('images/emptycart.jpg')}}" class="img-responsive">
                            
                        </div>
                </div>
            @endif
                            
                            <button type="button" class="btn btn-info btn-cart btn-previous">Previous</button>
                           <a href="{{ route('getpayment') }}" class="btn btn-info btn-cart pull-right">PROCEED TO CHECKOUT <i class="fa fa-angle-right"></i></a>
                        </div>
                    </fieldset>
                    </form>
        </div>        
    </div>
</div>









@endsection

@section('scripts')
<script>
    var updateCartUrl = "{{route('shoppingCart.UpdateCart')}}";
</script>
@endsection
