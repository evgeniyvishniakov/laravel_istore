<?php

namespace App\Http\Controllers\shop\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class RegisterController extends Controller
{
    public function add(Request $request)
    {
        $email = $request->input('email');
        $password = $request->input('password');
        $confirmation = $request->input('password_confirmation');
        $message = '';


        if (User::emailExists($email)) {

            return view('shop.auth.register', [
                'message_email' => 'Цей email вже використовується!' ,
                'email' => $email,
                'password' => $password,
            ]);
        }

        if ($request->isMethod('post')){
            if ($email != null && $password != null && $password === $confirmation) {

                User::addUsers($email, $password); // Добаляем пользователя

                return view('shop.auth.login', [
                    'message' => 'Реєстарція прошла успішно, будь ласка авторизуйтеся',
                ]);

            } else {
                $message = 'Паролі не співпадають або поля не заповнені';
            }
        }
        return view('shop.auth.register', [
            'message' => $message,
            'email' => $email,
            'password' => $password,
        ]);
    }
    private function emailExists($email)
    {
        return DB::table('users')->where('email', $email)->exists();
    }
}
