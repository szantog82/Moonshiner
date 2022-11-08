<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;

class OrderController extends Controller
{
    public function index() {
        return view('order', ["items" => Item::all()]);
    }
}
