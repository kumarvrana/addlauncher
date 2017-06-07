<tr>
    <td data-th="Number" class="sr">{{$loop->iteration}}</td>
        <td data-th="Product" class="pn">
            <div class="row">
                <div class="col-sm-12 c-title">
                    <h4 class="nomargin">{{ $product['item']['title'] }} | {{ ucwords(str_replace('_', ' ', substr($product['item']['price_key'], 6))) }}</h4>
                </div>
        </div>
    </td>
    <td data-th="Quantity" class="qt">
        <label> Number of inserts </label>
        <input type="number" id="quantity-{{$j}}" data-index="{{$j}}" data-itemkey="{{$key}}" name="quantity" class="form-control text-center change-cart-newspaper" min="1" max="30" value="{{$product['qty']}}"><span class="error quantity-error-{{$j}}" style="display:none;color:red;">Max Limit Is 30</span>
        <input type="hidden" id="quantity-hidden-{{$j}}" name="quantity-hidden" value="30">
    </td>
    <td data-th="duration" class="duration-hidden-">
        <label> W: </label>
        <select id="width-{{$j}}" name="width" data-itemkey="{{$key}}" data-index="{{$j}}" class="form-control change-cart-newspaper">
            <option value="" disabled>--Width--</option>
            @PHP	
                for($w=4;$w<=33;$w += 4) {
                    if($w==32) $w = $w+1;
                    if($w==$product['width']){
                        echo "<option  Selected value=$w>$w cm</option>";
                    }else{
                        echo "<option value=$w>$w cm</option>";
                    } 
                }

            @ENDPHP
        </select>
        <label> H: </label>
        <select id="height-{{$j}}" name="height" data-itemkey="{{$key}}" data-index="{{$j}}" class="form-control change-cart-newspaper">
            <option value="" disabled>--Height--</option>
            @PHP	
                for($h=4;$h<=52;$h++) {
                    if($h==$product['height']){
                        echo "<option  Selected value=$h>$h cm</option>";
                    }else{
                        echo "<option value=$h>$h cm</option>";
                    } 
                }

            @ENDPHP
        </select>
    </td>
    <td data-th="Subtotal" class="text-center subtotal-{{$j}}  tl" data-subtotal="{{$product['price']}}">
        <h4>Rs. {{$product['price']}}</h4>
    </td>
    <td class="actions rm" data-th="">
        <a href="{{route('Cart.removeItemCart', ['id' => $key])}}"><img src="{{asset('images/trash.png')}}" class="img-responsive trash-img"></i></a>
    </td>
</tr>

