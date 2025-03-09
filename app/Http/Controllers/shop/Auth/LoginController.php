<?php

namespace App\Http\Controllers\shop\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function login(Request $request){

        $email = $request->input('email');
        $password = $request->input('password');
        $error = '';

        if (Auth::check()) {
            return redirect()->route('account');
        }

        $credentials = $request->only('email', 'password');


        if ($request->isMethod('post')){
            if (!User::emailExists($email)) {

                return view('shop.auth.login', [
                    'error_email' => 'Не ввірний email',
                    'email' => $email,
                ]);

            }

            if (Auth::attempt($credentials)) {

                return redirect()->route('account');

                // Успешная авторизация
            }else{
                return view('shop.auth.login', [
                    'error_pass' => 'Не ввірний пароль' ,
                    'email' => $email,
                ]);
            }

        }

        return view('shop.auth.login');

    }
}
