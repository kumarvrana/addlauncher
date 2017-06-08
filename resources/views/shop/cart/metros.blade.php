
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
        <input type="number" id="quantity-{{$j}}" data-index="{{$j}}" data-itemkey="{{$key}}" name="quantity" class="form-control text-center change-cart" min="1" max="{{$product['item']['unit']}}" value="{{$product['qty']}}"><span class="error quantity-error-{{$j}}" style="display:none;color:red;">Max Limit Is {{$product['item']['unit']}}</span>
        <input type="hidden" id="quantity-hidden-{{$j}}" name="quantity-hidden" value="{{$product['item']['unit']}}">
    </td>
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
    <td data-th="Subtotal" class="text-center subtotal-{{$j}}  tl" data-subtotal="{{$product['price']}}">
        <h4>Rs. {{$product['price']}}</h4>
    </td>
    <td class="actions rm" data-th="">
        <a href="{{route('Cart.removeItemCart', ['id' => $key])}}"><img src="{{asset('images/trash.png')}}" class="img-responsive trash-img"></i></a>
    </td>
</tr>

