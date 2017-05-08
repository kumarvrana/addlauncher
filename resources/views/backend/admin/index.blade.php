@extends('backend.layouts.backend-master')

@section('title')
   Admin Panel
@endsection

@section('content')
   <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
          <h1 class="well text-center">Dashboard</h1>
        <div class="panel panel-primary">
        <!-- Default panel contents -->
        <div class="panel-heading">Recent 10 orders</div>
       
        <!-- Table -->
        <table class="table table-hover table-striped">
            <tr>
                <th>#</th>
                <th>Order ID</th>
                <th>Order Name|Quantity</th>
                <th>Order items Prices</th>
                <th>Order Total</th>
                <th>Order Category</th>
                <th>Ordering User</th>
                <th>Order Address</th>
                <th>Payment method</th>
            </tr>
           
            @foreach($orders as $order)
            <tr>
                <td>{{$loop->iteration}}</td>
                <td>{{$order['id']}}</td>
                <td><ul>
                 @foreach( $order->cart->items as $item)
                    @PHP
                        $key = array_search($item, $order->cart->items);
                        $category = explode('_', $key);
                    @ENDPHP
                    @if($category[1] == 'tricycle')
                    <li>{{$item['item']['title']}}|<b> Tricycle </b>|{{$item['qty']}}</li>
                    @else
                         @if($category[0] == 'televisions')
                            <li>{{$item['item']['title']}}|<b>{{ucwords(str_replace('_', ' ', substr($item['item']['rate_key'],5)))}}</b>|{{$item['qty']}}</li>
                         @else
                            <li>{{$item['item']['title']}}|<b>{{ucwords(str_replace('_', ' ', substr($item['item']['price_key'],6)))}}</b>|{{$item['qty']}}</li>
                        @endif
                    @endif
                 @endforeach
                 </ul></td>
                 <td><ul>
                 @foreach( $order->cart->items as $item)
                    <li>Rs.{{$item['item']['price']}}</li>
                 @endforeach
                 </ul></td>
                 <td>{{$order->cart->totalPrice}}</td>
                  
                <td><ul>
                 @foreach( $order->cart->items as $item)
                    @PHP
                        $key = array_search($item, $order->cart->items);
                        $category = explode('_', $key);
                    @ENDPHP
                    <li>{{ucfirst($category[0])}}</li>
                 @endforeach
                 </ul></td>
                <td>{{$order->user['email']}}</td>
                <td>{{$order['address']}}</td>
                <td>{{$order['payment_method']}}</td>
            </tr>
            @endforeach
        </table>
        </div>
        
      
    </div><!-- /.modal -->
@endsection