<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\OrderItem;

class OrderItemController extends Controller
{
    public function getNeedPrep () {
        return OrderItem::where('status', 'W')->get();
    }

    public function claimDish(Request $request, $id) {
        $item = OrderItem::find($request->input('id'));
        $item->preparation_by=$id;
        $item->status = 'P';
        $item->save();
    }

    public function getDishesFromChef ($id) {
        return OrderItem::where('preparation_by', $id)
            ->where('status', 'P')->get();
    }

    public function getAllDishesFromChef ($id) {
        return OrderItem::where('preparation_by', $id)->get();
    }

    public function declareReady($id) {
        $item = OrderItem::find($id);
        $item->status = 'R';
        $item->save();
    }
}
