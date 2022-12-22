<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\User;
use App\Models\Order;

use Carbon\Carbon;

class OrderController extends Controller
{
    public function getOrdersOfUser($userId) {
        $orders = Order::where('customer_id', $userId)->get();
        return $orders;
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
            'ticket_number'=>'required|numeric',
            'customer_id'=>'required|numeric',
            'total_price'=>'required|numeric',
		    'total_paid'=>'required|numeric',
		    'total_paid_with_points'=>'required|numeric',
		    'points_gained'=>'required|numeric',
		    'points_used_to_pay'=>'required|numeric',
		    'payment_type'=>'required|in:"visa", "paypal", "mbway"',
		    'payment_reference'=>'required|string|max:255',
        ]);

        $ticket_orders = Order::where('ticket_number','=', $request->input('ticket_number'))
                                    ->where('status','NOT LIKE','D')
                                    ->where('status','NOT LIKE','C')
                                    ->get();

        if (count($ticket_orders) === 0)
            {
                $order = new Order([
                    'ticket_number'=>$request->input('ticket_number'),
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
            }
        else {
            return response()->json(['message' => 'Ticket number is already being served.'], 400);
        }
		
		$order->save();

        return response()->json(['message' => 'success']);
    
    }
}
