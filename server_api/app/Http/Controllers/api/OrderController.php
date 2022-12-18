<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\User;
use App\Models\Order;

use Carbon\Carbon;

class OrderController extends Controller
{
    public function getOrdersOfUser(User $user) {
        return $user->orders;
    }

    public function getItemsOfOrder (Order $order) {
        return $order->items;
    }

    public function index(Request $request)
    {
        $orders = Order::paginate(50);
        return $orders;
    }

    public function getOrdersReady(Request $request) 
    {
        $orders = Order::where('status', 'R')->get();
        return $orders;
    }

    public function store(Request $request)
    {
        $request->validate([
        ]);
 
        $order = new Order([
            'ticket_number'=>'1',
            'status'=>'p',
            'customer_id'=>$request->input('customer_id'),
            'total_price'=>$request->input('total_price'),
		    'total_paid'=>$request->input('total_paid'),
		    'total_paid_with_points'=>$request->input('customer_id'),
		    'points_gained'=>$request->input('points_gained'),
		    'points_used_to_pay'=>$request->input('points_used_to_pay'),
		    'payment_type'=>$request->input('payment_type'),
		    'payment_reference'=>$request->input('payment_reference'),
		    'date'=>Carbon::now(),
		]);
		
		$order->save();

        return response()->json(['message' => 'success']);
    
    }
}
