<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;

class UserOrdersController extends Controller
{

    public function index()
    {
        $data = Order::select("order.id", "item.name", "order.count", "order.created_at")->join("item", "order.item_id", "=", "item.id")->where("user_id", auth()->user()->id)->get();
        return view('my_orders', [
            "data" => $data
        ]);
    }
}
