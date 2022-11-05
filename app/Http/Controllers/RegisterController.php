<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class RegisterController extends Controller
{

    public function index()
    {
        return view("register");
    }

    public function storeUser(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required'
        ]);
        try {
            $user = new User([
                "name" => $request['name'],
                "email" => $request['email'],
                "password" => bcrypt($request['password']),
                "is_valid" => 1
            ]);
            $user->save();

            auth()->login($user);

            return redirect()->to(route('home'));
        } catch (\Illuminate\Database\QueryException $e) {
            if (str_contains($e, "Integrity constraint violation")) {
                $message = "Error registering user! This e-mail address has already been registered!";
            } else {
                $message = "Error registering user (unknown error)!";
            }
            return view("register", ["error_message" => $message]);
        }
    }
}
