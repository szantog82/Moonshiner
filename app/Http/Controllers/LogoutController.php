<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LogoutController extends Controller
{
    public function logoutUser() {
        auth()->logout();
        return redirect()->to(route('home'));
    }
}
