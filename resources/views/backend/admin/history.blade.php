@extends('backend.layouts.backend-master')

@section('title')
   Orders Lists|Ad Launcher
@endsection

@section('content')
   <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
          <h1 class="well text-center">User Order History</h1>
        <div class="panel panel-primary">
        <!-- Default panel contents -->
        <div class="panel-heading">Recent 10 orders</div>


        <!-- Table -->
        <table class="table table-hover table-bordered table-striped">
        <thead>
            <tr>
                <th>#</th>
                <th>Order ID</th>
                <th>Status</th>
                
                <th>Order Name</th>
                <th>Quantity</th>
                <th>Price</th>
                <th>OTotal</th>
                <th>Category</th>
                <th>User Name</th>
                <th>Address</th>
                <th>Payment method</th>
                <th>Action</th>
            </tr>
           </thead>
            @if(Session::has('message'))
            <div class="alert alert-success">
                <p>{{Session::get('message')}}</p>
            </div>
            @endif
            @foreach($orders as $order)
                <?php
                    switch($order['order_status']){
                        case 'Pending':
                            $differciatingClass = 'bg-warning';
                        break;
                        case 'Completed':
                            $differciatingClass = 'bg-success';
                        break;
                        case 'Processing':
                            $differciatingClass = 'bg-primary';
                        break;
                        case 'Cancelled':
                            $differciatingClass = 'bg-danger';
                        break;
                    };
                ?>
            <tr>
                <td>{{$loop->iteration}}</td>

                <td tip-left" data-toggle="myToolTip" data-placement="top"  title="{{$order['order_status']}}">{{$order['id']}}</td>
                <td class="{{$differciatingClass}}">{{$order['order_status']}}</a></td>
                
                <td><ul>
                 @foreach( $order->cart->items as $item)
                    <li><a href="{{route('dashboard.viewOrder', ['id' => $order['id']])}}">{{$item['item']['title']}}|<b>{{ucwords(str_replace('_', ' ', substr($item['item']['price_key'],6)))}}</b>|</a></li>
                 @endforeach
                 </ul></td>
                <td>{{$item['qty']}}</a></td>
                 <td><ul>
                 @foreach( $order->cart->items as $item)
                    <li>Rs.{{$item['price']}}</li>
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
                <td><a href="{{route('dashboard.deleteOrder', ['id' => $order['id']])}}" onclick="return ConfirmDelete()"><img src="{{asset('images/trash.png')}}" class="img-responsive trash-img" style="width: 20px"></a></td>
            </tr>
            @endforeach
        </table>
        </div>
        {{$orders->links()}}
      
    </div><!-- /.modal -->
@endsection