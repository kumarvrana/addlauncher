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
        <label> Number of Inserts </label>
        <input type="number" id="quantity-{{$j}}" data-index="{{$j}}" data-itemkey="{{$key}}" name="quantity" class="form-control text-center change-cart" min="1" max="12" value="{{$product['qty']}}"><span class="error quantity-error-{{$j}}" style="display:none;color:red;">Max Limit Is 12</span>
        <input type="hidden" id="quantity-hidden-{{$j}}" name="quantity-hidden" value="12">
    </td>
    <td data-th="duration" class="duration-hidden-">
        <label> Edition For Month </label>
        <select id="duration-{{$j}}" name="duration" data-itemkey="{{$key}}" data-index="{{$j}}" class="form-control change-cart">
            <option value="" disabled>--Edition Month--</option>
            @PHP
           
                for($i=1,$ym=1;$i<=12,$ym<=12;$i++,$ym++) {
                    if($i==$product['duration']){
                        echo "<option  Selected value=".date('n', strtotime("+$ym month")).">".date('Y F', strtotime("+$ym month"))."</option>";
                    }else{
                        echo "<option value=".date('n', strtotime("+$ym month")).">".date('Y F', strtotime("+$ym month"))."</option>";
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

