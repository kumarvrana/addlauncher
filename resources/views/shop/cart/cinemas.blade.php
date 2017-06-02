
<tr>

    <td data-th="Number" class="sr">{{$loop->iteration}}</td>
        <td data-th="Product" class="pn">
            <div class="row">
                <div class="col-sm-12 c-title">
                    <h4 class="nomargin">{{ $product['item']['title'] }} | {{ ucwords(str_replace('_', ' ', substr($product['item']['price_key'], 6))) }}</h4>
                </div>
        </div>
    </td>
    <?php
        switch($product['item']['price_key']){
            case 'price_video_ad':
            ?>
                <td data-th="length" class="qt">
                    <select id="length-{{$j}}" name="length" data-itemkey="{{$key}}" data-index="{{$j}}" class="form-control change-cart">
                        <option value="" disabled>Length</option>
                        <?php	
                        for($i=1,$s=10;$i<=6;$i++) {
                            $step = $i * $s;
                            if($i==1)
                                echo "<option value=$i>$step sec</option>";
                            else{
                                if($i==$product['qty']){
                                    echo "<option  Selected value=$i>$step sec</option>";
                                }else{
                                    echo "<option value=$i>$step sec</option>";
                                } 
                                
                            }
                        }
                        ?>
                       
                    </select>							
                </td>
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
            <?php
            break;
            case 'price_trailor_ad':
            ?>
                <td data-th="length" class="qt">
                    <select id="length-{{$j}}" name="length" data-itemkey="{{$key}}" data-index="{{$j}}" class="form-control change-cart">
                        <option value="" disabled>Length</option>
                         <?php	
                        for($i=1,$s=60; $i<=3; $i+=0.5) {
                            $step = $i * $s;
                            if($i==1)
                                echo "<option value=$i>$step sec</option>";
                            else{
                                if($i==$product['qty']){
                                    echo "<option  Selected value=$i>$step sec</option>";
                                }else{
                                    echo "<option value=$i>$step sec</option>";
                                } 
                                
                            }
                        }
                        ?>
                       
                    </select>							
                </td>
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
                
            <?php
            break;
            case 'price_mute_slide_ad':
            ?>
                <td data-th="length" class="qt">
                    <select id="length-{{$j}}" name="length" data-itemkey="{{$key}}" data-index="{{$j}}" class="form-control change-cart">
                        <option value="" disabled>Length</option>
                        <?php	
                        for($i=1,$s=10;$i<=6;$i++) {
                            $step = $i * $s;
                            if($i==1)
                                echo "<option value=$i>$step sec</option>";
                            else{
                                if($i==$product['qty']){
                                    echo "<option  Selected value=$i>$step sec</option>";
                                }else{
                                    echo "<option value=$i>$step sec</option>";
                                } 
                                
                            }
                        }
                        ?>
                    </select>							
                </td>
               <td data-th="duration" class="duration-hidden-">
                    <select id="duration-{{$j}}" data-itemkey="{{$key}}" data-index="{{$j}}" name="duration" class="form-control change-cart">
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
            <?php
            break;
            case 'price_ticket_jackets':
            ?>
                <td data-th="Quantity" class="qt">
                    <input type="number" id="quantity-{{$j}}" data-index="{{$j}}" data-itemkey="{{$key}}" name="quantity" class="form-control text-center change-cart" min="1" value="{{$product['qty']}}">
                </td>
                <td>Rs. {{$product['item']['price_value']}} per unit</td>
            <?php
            break;
            case 'price_seat_branding':
            ?>
                <td data-th="Quantity" class="qt">
                    <input type="number" id="quantity-{{$j}}" data-index="{{$j}}" data-itemkey="{{$key}}" name="quantity" class="form-control text-center change-cart" min="1" max="{{$product['item']['audiseats']}}" value="{{$product['qty']}}">
                </td>
                <td>Rs. {{$product['item']['price_value']}} per audi</td>
            <?php
            break;
            case 'price_audi_door_branding':
            ?>
                <td data-th="Quantity" class="qt">
                    <input type="number" id="quantity-{{$j}}" data-index="{{$j}}" data-itemkey="{{$key}}" name="quantity" class="form-control text-center change-cart" min="1" max="{{$product['item']['audinumber']}}" value="{{$product['qty']}}">
                </td>
                <td>Rs. {{$product['item']['price_value']}}  per audi door</td>
            <?php
            break;
            case 'price_popcorn_tub_branding':
            ?>
                <td data-th="Quantity" class="qt">
                    <input type="number" id="quantity-{{$j}}" data-index="{{$j}}" data-itemkey="{{$key}}" name="quantity" class="form-control text-center change-cart" min="1" value="{{$product['qty']}}">
                </td>
                <td>Rs. {{$product['item']['price_value']}} per Tub</td>
            <?php
            break;
            case 'price_coffee_tree_branding':
            ?>
                <td data-th="Quantity" class="qt">
                   Coffee Tree Branding
                </td>
                <td>{{$product['item']['duration_value']}}</td>
            <?php
            break;
            case 'price_washroom_branding':
            ?>
                <td data-th="Quantity" class="qt">
                    washroom branding
                </td>
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
            <?php
            break;
            case 'price_women_frisking_cell':
            ?>
                <td data-th="Quantity" class="qt">
                    women frisking cell
                </td>
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
            <?php
            break;
        }
        
    ?>
   
    <td data-th="Subtotal" class="text-center subtotal-{{$j}}  tl" data-subtotal="{{$product['price']}}">
        <h4>Rs. {{$product['price']}}</h4>
    </td>
    <td class="actions rm" data-th="">
        <a href="{{route('Cart.removeItemCart', ['id' => $key])}}"><img src="{{asset('images/trash.png')}}" class="img-responsive trash-img"></i></a>
    </td>
</tr>

