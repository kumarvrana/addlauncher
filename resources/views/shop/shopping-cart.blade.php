@extends('layouts.master')

@section('title')
    Shop Cart | Add Launcher
@endsection

@section('content')
<div class="container-fluid">
	<div class="row cart-body">
		<div class="col-md-3">
                    @include('partials.sidebar-cart')
        </div>

        <div class="col-md-9 wrapper">
            <div class="section-title">
                <h2>Shopping Cart</h2>
            </div>

			@if(Session::has('cart'))
   				@if($products)
				<table id="cart" class="table table-cart">
    				<thead>
						<tr>
							<th class="sr">#</th>
							<th class="im">Image</th>
							<th class="pn">Product Name</th>
							
							<th class="qt">Quantity</th>
							<!--th style="width:18.5%">Duration(in months)</th-->
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
                        	<td data-th="Number" class="sr">@PHP echo	$i; @ENDPHP </td>
                        	<td data-th="Image" class="im">
                        		<img src="{{asset('images/'.$imagefolder[0].'/'.$product['item']['image'])}}" alt="{{ $product['item']['title'] }} | {{ ucwords(str_replace('_', ' ', substr($product['item']['price_key'], 6)))}}" class="img-responsive"/>
                        	</td>
							<td data-th="Product" class="pn">
								<div class="row">
									
									<div class="col-sm-12 c-title">
										<h4 class="nomargin">{{ $product['item']['title'] }} | {{ ucwords(str_replace('_', ' ', substr($product['item']['price_key'], 6)))}}</h4>
									</div>
									<div class="col-sm-12 c-detail">
                                        <h5>Product Details : <small> {{substr (strip_tags($product['item']['description']), 0,100)}}</small></h5>
                                    </div>
								</div>
							</td>
							@if($imagefolder[0] == 'cinemas')
							<td data-th="Quantity" class="qt">1								
							</td>
							@else
							<td data-th="Quantity" class="qt">
								<input type="number" id="quantity" data-index="{{$i}}" data-itemkey="{{$key}}" name="quantity" class="form-control text-center change-cart" min="1" max="{{$product['item']['number_value']}}" value="{{$product['qty']}}"><span class="error quantity-error-{{$i}}" style="display:none;color:red;">Max Limit Is {{$product['item']['number_value']}}</span>
								<input type="hidden" id="quantity-hidden-{{$i}}" name="quantity-hidden" value="{{$product['item']['number_value']}}">
							</td>
							@endif
							<!--td data-th="duration">
								<input type="number" id="duration" data-index="{{$i}}" data-itemkey="{{$key}}" name="duration" class="form-control text-center change-cart" min="1" max="{{$product['item']['duration_value']}}" value="1"><span class="error duration-error-{{$i}}" style="display:none;color:red;">Max Limit Is {{$product['item']['duration_value']}}</span>
								<input type="hidden" id="duration-hidden-{{$i}}" name="duration-hidden" value="{{$product['item']['duration_value']}}">
							</td-->
                            <td data-th="Price" class="pr">Rs.{{$product['item']['price_value']}}</td>
							<td data-th="Subtotal" class="text-center subtotal-{{$i}}  tl" data-subtotal="{{$product['price']}}"><h4>Rs. {{$product['price']}}</h4></td>
							<td class="actions rm" data-th="">
								<!-- <a href="{{route('cart.shoppingCart')}}" class="btn btn-info btn-block"><i class="fa fa-refresh"></i></a> -->
								<a href="{{route('Cart.removeItemCart', ['id' => $key])}}"><img src="{{asset('images/trash.png')}}" class="img-responsive trash-img"></i></a>								
							</td>
						</tr>
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
											<h4>Rs {{ $totalPrice }}</h4>
										</div>
										<div class="col-md-12">
											<a href="{{ route('getpayment') }}" class="btn btn-info btn-block btn-cart">PROCESS TO CHECKOUT <i class="fa fa-angle-right"></i></a>
										</div>
									</div>
								</div>
							</td>
								<!-- <td class="c-total"><h3><span>Total :</span></h3></td>
								<td class="hidden-xs text-center c-total"><h3><div class="cart-total">Rs {{ $totalPrice }}</div></h3></td>
								<td><a href="{{ route('getpayment') }}" class="btn btn-info btn-cart">Checkout <i class="fa fa-angle-right"></i></a></td> -->
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
</div>



@endsection

@section('scripts')
<script>
    var updateCartUrl = "{{route('shoppingCart.UpdateCart')}}";
</script>
@endsection
