<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LoginController extends Controller
{

    public function index()
    {
        return view("login");
    }

    public function loginUser()
    {
        if (! auth()->attempt(request([
            'name',
            'password'
        ]))) {
            return view("login", ["error_message" => "The email or password is incorrect!"]);
        }
        return redirect()->to(route('home'));
    }
}
