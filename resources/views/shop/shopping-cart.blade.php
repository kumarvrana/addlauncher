@extends('layouts.master')

@section('title')
    Shop Cart | Add Launcher
@endsection

@section('content')
<div class="container">
	<div class="row cart-body">
		

        <div class="col-md-12 wrapper form-box">
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
                   			<td data-th="Number" class="sr">{{$loop->iteration}}</td>
							@PHP
								$key = array_search($product, $products);
								$imagefolder = explode('_', $key);
								$model = $imagefolder[0];
								if($imagefolder[1] == 'tricycle'){
									$priceValue = $product['item']['price'];
									$subTitle = ucfirst($imagefolder[1]);

								}elseif($model == 'airports'){
									$priceValue = $product['item']['optionprice'];
									$subTitle = ucfirst($imagefolder[1]);

								}elseif($model == 'metros'){
									$priceValue = $product['item']['totalprice'];
									$subTitle = ucfirst($imagefolder[1]);
								}elseif($model == 'newspaper'){
									$priceValue = $product['item']['total_price'];
									$subTitle = ucfirst(str_replace('_', ' ', substr($product['item']['price_key'], 6)));
								}elseif($model == 'magazine'){
									$priceValue = $product['item']['price_value'];
									$subTitle = ucfirst(str_replace('_', ' ', substr($product['item']['price_key'], 6)));
								}else{
									$priceKey = ($model == 'televisions') ? $product['item']['rate_key'] : $product['item']['price_key'];
									$priceValue = ($model == 'televisions') ? $product['item']['rate_value'] : $product['item']['price_value'];
									$substrNumber = ($model == 'televisions') ? 5 : 6;
									$subTitle = ucwords(str_replace('_', ' ', substr($priceKey, $substrNumber)));
									if($model == 'billboards') $model = 'outdooradvertising';
								}
								$newpaperUnits = ($model == 'newspaper') ? 'cm sq' : '';
								$newpaperAreaUnits = ($model == 'newspaper') ? '4 X 4 cm sq' : '';
								$folder = ($model == 'newspaper' || $model == 'magazine') ? 'newspapers' : $model;
							@ENDPHP
							<td data-th="Image" class="im">
									<img src="{{asset('images/'.$folder.'/'.$product['item']['image'])}}" alt="{{ $product['item']['title'] }} | {{$subTitle}}" class="img-responsive"/>
							</td>
							
                        	<td data-th="Product" class="pn">
								<div class="row">
									<div class="col-sm-12 c-title">
										<h4 class="nomargin">{{ $product['item']['title'] }} | {{$subTitle}}</h4>
									</div>
									<div class="col-sm-12 c-detail">
										<h5>Product Details : <small> {{substr (strip_tags($product['item']['description']), 0,100)}}</small></h5>
									</div>
								</div>
							</td>
							<td data-th="Price" class="pr">Rs.{{$priceValue}} {{$newpaperUnits}}</td>
							
							<td data-th="Subtotal" class="text-center subtotal-{{$i}}  tl" data-subtotal="{{$product['price']}}"><h4>Rs. {{$product['price']}} <br>{{$newpaperAreaUnits}}</h4></td>
							<td class="actions rm" data-th="">
							
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
							<td colspan="2" class="hidden-xs"></td>
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
				<div class="loader" style="display: none;"></div>
    				<thead>
						<tr>
							<th class="sr">#</th>
							<th class="pn">Product Name</th>
							
							<th class="qt">Quantity</th>
                            <th class="pr">Duration/Area/Length</th>
							<th class="tl">Total</th>
							<th class="rm">Remove</th>
						</tr>
					</thead>
					<tbody>
					@PHP
						$j = 1;
					@ENDPHP
                    @foreach($products as $product)
					 	@PHP
						$key = array_search($product, $products);
						$imagefolder = explode('_', $key);
						
						switch($imagefolder[0]){
							case 'cinemas':
							@ENDPHP
								@include('shop.cart.cinemas')
							@PHP
							break;
							case 'busstops':
							@ENDPHP
								@include('shop.cart.busstops')
							@PHP
							break;
							case 'buses':
							@ENDPHP
								@include('shop.cart.busstops')
							@PHP
							break;
							case 'cars':
							@ENDPHP
								@include('shop.cart.busstops')
							@PHP
							break;
							case 'shoppingmalls':
							@ENDPHP
								@include('shop.cart.busstops')
							@PHP
							break;
							case 'billboards':
							@ENDPHP
								@include('shop.cart.busstops')
							@PHP
							break;
							case 'televisions':
							@ENDPHP
								@include('shop.cart.televisions')
							@PHP
							break;
							case 'autos':
							@ENDPHP
								@include('shop.cart.autos')
							@PHP
							break;
							case 'airports':
							@ENDPHP
								@include('shop.cart.airports')
							@PHP
							break;
							case 'newspaper':
							@ENDPHP
								@include('shop.cart.newspapers')
							@PHP
							break;
							case 'magazine':
							@ENDPHP
								@include('shop.cart.magazines')
							@PHP
							break;

						}
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
