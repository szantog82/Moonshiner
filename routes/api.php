<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OrderController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::post("/check_cart", [OrderController::class, "checkCart"])->name("item.check.cart");
Route::post("/add_to_cart", [OrderController::class, "addItemToCart"])->name("item.add.cart");
Route::post("/upload_promocode", [OrderController::class, "setPromoCode"])->name("order.upload.promocode");
Route::post("/change_item_count_cart", [OrderController::class, "changeItemCountInCart"])->name("item.changecount.cart");
Route::post("/remove_from_cart", [OrderController::class, "removeItemFromCart"])->name("item.remove.fromcart");

Route::post('/store_order', [OrderController::class, "storeOrder"])->name("store.order");