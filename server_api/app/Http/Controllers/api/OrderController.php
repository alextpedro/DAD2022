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
}
