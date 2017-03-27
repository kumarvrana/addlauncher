@extends('backend.layouts.backend-master')

@section('title')
   Admin Panel
@endsection

@section('content')
   <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
          <h1 class="page-header">Dashboard</h1>
        <div class="panel panel-default">
        <!-- Default panel contents -->
        <div class="panel-heading">Orders</div>
        <div class="panel-body">
            <p>Recent 10 orders</p>
        </div>

        <!-- Table -->
        <table class="table">
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
                    <li>{{$item['item']['title']}}|<b>{{ucwords(str_replace('_', ' ', substr($item['item']['price_key'],6)))}}</b>|{{$item['qty']}}</li>
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