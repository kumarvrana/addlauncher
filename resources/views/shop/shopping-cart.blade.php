@extends('layouts.master')

@section('title')
    Shop Cart | Add Launcher
@endsection

@section('content')
<div class="container">
    <h1>Shopping Cart</h1><hr>
@if(Session::has('cart'))
    @if($products)
	<table id="cart" class="table table-hover table-condensed">
    				<thead>
						<tr>
							<th style="width:30%">Product</th>
							<th style="width:33%">Quantity</th>
                            <th style="width:5%">Unit Price</th>
							<th style="width:22%" class="text-center">Subtotal</th>
							<th style="width:10%"></th>
						</tr>
					</thead>
					<tbody>
                     @foreach( $products as $product)
						<tr>
                        @PHP
                            $key = array_search($product, $products);
                            $imagefolder = explode('_', $key);
                        @ENDPHP
							<td data-th="Product">
								<div class="row">
									<div class="col-sm-2 hidden-xs"><img src="{{asset('images/'.$imagefolder[0].'/'.$product['item']['image'])}}" alt="{{ $product['item']['title'] }} | {{ ucwords(str_replace('_', ' ', substr($product['item']['price_key'], 6)))}}" class="img-responsive"/></div>
									<div class="col-sm-10">
										<h4 class="nomargin">{{ $product['item']['title'] }} | {{ ucwords(str_replace('_', ' ', substr($product['item']['price_key'], 6)))}}</h4>
										<p>{{substr(strip_tags($product['item']['description']), 0,100)}}</p>
									</div>
								</div>
							</td>
							
							<td data-th="Quantity">
								<input type="number" class="form-control text-center" min="1" max="5" value="1">
							</td>
                            <td data-th="Price">Rs.{{$product['item']['price_value']}}</td>
							<td data-th="Subtotal" class="text-center">{{$product['item']['price_value']}}</td>
							<td class="actions" data-th="">
								<a href="#" class="btn btn-info btn-sm"><i class="fa fa-refresh"></i></a>
								<a href="{{route('Cart.removeItemCart', ['id' => $key])}}" class="btn btn-danger btn-sm"><i class="fa fa-trash-o"></i></a>								
							</td>
						</tr>
                        @endforeach
					</tbody>
					<tfoot>
						<tr class="visible-xs">
							<td class="text-center"><strong>Total Rs.{{ $totalPrice }}</strong></td>
						</tr>
						<tr>
							<td><a href="#" class="btn btn-warning"><i class="fa fa-angle-left"></i> Continue Shopping</a></td>
							<td colspan="2" class="hidden-xs"></td>
							<td class="hidden-xs text-center"><strong>Total Rs.{{ $totalPrice }}</strong></td>
							<td><a href="{{ route('checkout') }}" class="btn btn-success btn-block">Checkout <i class="fa fa-angle-right"></i></a></td>
						</tr>
					</tfoot>
				</table>
                @else
                    <div class="row">
                        <div class="col-md-8 col-md-offset-2 ">
                            <div class="alert alert-info" role="alert">Your cart is empty!</div>
                        </div>
                    </div>
                @endif
                 @else
                    <div class="row">
                        <div class="col-md-8 col-md-offset-2 ">
                            <div class="alert alert-info" role="alert">Your cart is empty!</div>
                        </div>
                    </div>
                @endif
</div>



@endsection
