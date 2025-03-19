<?php

namespace App\Http\Controllers\shop\Home;

use App\Http\Controllers\Controller;
use App\Models\admin\product\Product;
use Illuminate\Http\Request;

class HomeController extends Controller
{

    public function show()
    {

        $products = Product::all();


        return view('shop.home.home', compact('products'));
    }


}
