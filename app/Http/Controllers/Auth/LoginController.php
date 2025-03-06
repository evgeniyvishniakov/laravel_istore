<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;

class LoginController extends Controller
{
    public function login(){
        return view('shop.auth.login');
    }

}
