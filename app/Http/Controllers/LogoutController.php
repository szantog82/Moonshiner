<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LogoutController extends Controller
{

    public function logoutUser()
    {
        auth()->logout();
        session()->forget('order.items');
        session()->forget("promoCode");
        return redirect()->to(route('home'));
    }
}