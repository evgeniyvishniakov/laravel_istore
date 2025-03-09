<?php

namespace App\Http\Controllers\admin\Home;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function show()
    {
        return view('admin.home');
    }
}
