<?php

namespace App\Http\Controllers\Catalog;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CatalogController extends Controller
{
    public function show()
    {

        return view('shop.catalog');
    }
}
