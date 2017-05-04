<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Order;
use App\lib\EnumOrder;
               
class OrderController extends Controller
{

    public function __construct()
    {
        $this->middleware('admin', ['only' => ['getOrders', 'viewOrder']]);
    }

    public function getOrders()
    {
        $orders = Order::latest()->paginate(10);
        $orders->transform(function($order, $key){
            $order->cart = unserialize($order->cart);
            return $order;
        });
        return view("backend.admin.orders", ['orders' => $orders]);
    }

    public function viewOrder($id)
    {
        $orders = Order::find($id)->toArray();
        $enumorder_status = EnumOrder::getEnumValues('orders','order_status');
        $enumpayment_status = EnumOrder::getEnumValues('orders','payment_status');
        
        return view("backend.admin.orderSingle", ['orders' => $orders, 'orderStatus' => $enumorder_status, 'paymentStatus' => $enumpayment_status]);
    }

    //delete order by id

    public function deleteOrder($id)
    {
        $order = Order::where('id', $id)->first();
        $order->delete();
        
        return redirect()->back()->with(['message' => 'Order is Sccessfully Deleted']);;
    }
    
    public function getChangeStatus()
    {
        
        $orders = Order::find($_REQUEST["id"]);
        if($_REQUEST["columnName"] === 'order_status')
        $orders->order_status = $_REQUEST["status"];
        
        if($_REQUEST["columnName"] === 'payment_status')
        $orders->payment_status = $_REQUEST["status"];
        $orders->update();
        return response()->json(['response' => 'updated order!' ], 200);
    }
}
