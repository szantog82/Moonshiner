<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;
use App\Models\HoodiePriceComputer;
use App\Models\Order;
use Illuminate\Support\Facades\Log;

class OrderController extends Controller
{

    public function index()
    {
        return view('order', [
            "items" => Item::all()
        ]);
    }

    private static function isFirstOrdering()
    {
        if (! auth()->check()) {
            return 0;
        }
        $user_id = auth()->user()->id;
        return (Order::where("user_id", $user_id)->count() > 0) ? 0 : 1;
    }

    public function checkCart()
    {
        try {
            return HoodiePriceComputer::calculatePrice(session('order.items'), self::isFirstOrdering(), session("promoCode"));
        } catch (\Exception $e) {
            return [];
        }
    }

    public function addItemToCart(Request $request)
    {
        if (! $request->session('order.items')) {
            $request->session()->put('order.items', []);
        }
        $item_id = $request->input("item_id");
        $count = $request->input("count");
        if (Item::find($item_id)->count() > 0 && $count >= 1 && $count <= 10) {
            for ($i = 0; $i < $count; $i ++) {
                session()->push('order.items', $item_id);
            }
            return HoodiePriceComputer::calculatePrice(session('order.items'), self::isFirstOrdering(), session("promoCode"));
        } else {
            return;
        }
    }

    public function changeItemCountInCart(Request $request)
    {
        $item_id = $request->input("item_id");
        $count = $request->input("count");
        $items = session('order.items');
        session()->forget('order.items');
        session()->put('order.items', array_filter($items, fn ($a) => $a != $item_id));
        if (Item::find($item_id)->count() > 0 && $count >= 0 && $count <= 10) {
            for ($i = 0; $i < $count; $i ++) {
                session()->push('order.items', $item_id);
            }
            return HoodiePriceComputer::calculatePrice(session('order.items'), self::isFirstOrdering(), session("promoCode"));
        } else {
            return;
        }
    }

    public function setPromoCode(Request $request)
    {
        $promo_code = $request->input("promoCode");
        session()->put("promoCode", $promo_code);
        if ($promo_code === HoodiePriceComputer::getActivePromoCode() && HoodiePriceComputer::getActivePromoCode() != - 1) { // -1: promo code not active
            return 1;
        } else {
            return 0;
        }
    }

    public function storeOrder(Request $request)
    {
        if (auth()->check()) {
            try {
                $items = HoodiePriceComputer::convertProductListToArray(session('order.items'));
                $order_id = Order::max("id") + 1;
                foreach ($items as $key => $value) {
                    $order = new Order();
                    $order->id = $order_id;
                    $order->item_id = $key;
                    $order->user_id = auth()->user()->id;
                    $order->count = $value;
                    $order->saveOrFail();
                }
                session()->forget('order.items');
                session()->forget("promoCode");
                return 1;
            } catch (\Exception $e) {
                log::error("Error in storing order%");
                log::error($e);
                return $e;
                return 0;
            }
        } else {
            return;
        }
    }
}
