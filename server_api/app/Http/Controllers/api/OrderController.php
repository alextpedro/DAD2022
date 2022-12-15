<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\User;
use App\Models\Order;

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
        $title = "Orders List";
        $orders = Order::paginate(10);
        return view('encomendas.index', compact('title', 'orders'));
    }
}
