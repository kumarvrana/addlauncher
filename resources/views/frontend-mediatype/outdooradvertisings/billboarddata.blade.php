   <?php $pos=1; ?>
	@foreach($billboards as $billboard)	

								<div class="col-lg-3 col-md-4 col-sm-6 col-xs-12"> 
									<div class="pro-item"> 
										<div class=" cat-opt-img "> <img src="{{asset('images/outdooradvertising/'.$billboard->image)}}"> </div>
										<p class="font-1">{{$billboard->title}}</p>
										<p class="font-2">{{$billboard->landmark}} <br> <span class="cityfont">{{$billboard->city}} </span>
										</p>
										<hr>
										<div class="row">
											<div class="col-md-6">
												<p class="font-3">1 Ad Per Month<br>
												<span><span class="text-danger">Size: </span>{{$billboard->area}} Sq.ft.</span>
											</div>
											<div class="col-md-6">
												<p class="font-4"><del class="lighter">Rs {{$billboard->price}} <br></del>Rs {{$billboard->discount_price}} </p>
											</div>
										</div>
										
										@PHP
											$session_key = 'outdooradvertising'.'_'.$billboard->category_type.'_'.$billboard->id;
											$printsession = (array) Session::get('cart');														
										@ENDPHP
										<div class="clearfix"> 
											<a class="glass" href="{{route('billboard.addtocart', ['id' => $billboard->id])}}">
											
										 @if(count($printsession) > 0)
											 @if(array_key_exists($session_key, $printsession['items'])) 
												<span class="fa fa-minus-circle"></span> Remove From Cart 
											 @else
												<span class="fa fa-star"></span> Add to Cart 
											 @endif
										 @else
											<span class="fa fa-star"></span> Add to Cart
										 @endif
											
										</a> 
										</div>
									</div>
								</div>
								

<?php $pos++; ?>
			@endforeach	
			<?php  $pos; ?>









						
							