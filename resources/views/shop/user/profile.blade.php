@extends('layouts/master')

@section('title')
    Profile
@endsection

@section('content')
<div class="container">
<div class="row">
    <div class="col-md-12">
        
            
        
        <h1>User Profile</h1>
        <hr/>
       
        <div class="profile-order">
        <div class="panel panel-default panel-cart">
        <div class="panel-heading">
          <h4 class="text-center">
            My Orders 
          </h4>
          
        </div>
        <table class="table table-fixed">

          <thead>
            <tr>
              <th class="col-xs-2">#</th><th class="col-xs-8">Name</th><th class="col-xs-2">Price</th>
            </tr>
          </thead>
          <tbody>
           @PHP $i=1; @ENDPHP
             @foreach( $orders as $order)
             @PHP $aa=$loop->iteration @ENDPHP
              @foreach( $order->cart->items as $item)
                <tr>
                    <td class="col-xs-2" style="background-color: #fee998;">{{$aa}}</td>
                    <td class="col-xs-8" style="background-color: #fee998;"><strong>{{ucwords($item['item']['title'])}}</strong>&emsp;Qty: {{$item['qty']}}</td>
                    <td class="col-xs-2" style="background-color: #fee998;">Rs.{{$item['price']}}</td>
                </tr>
                 @endforeach
                <tr>
                    <td style="text-align: right;border-bottom: 2px solid #767676" class="col-xs-10" colspan="2"><strong>Total Price</strong></td>
                    <td class="col-xs-2" style="color: red; border-bottom: 2px solid #767676"><strong>Rs.{{$order->cart->totalPrice}}</strong></td>
                </tr>
             
               
            @endforeach
@PHP $i++; @ENDPHP
          </tbody>
        </table>
      </div>
       
    </div>

   
    </div>
</div>
</div>
@endsection