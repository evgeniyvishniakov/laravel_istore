<?php

namespace App\Http\Controllers\shop\Catalog;
use App\Http\Controllers\Controller;

class CatalogController extends Controller
{
    public function show()
    {

        return view('shop.catalog');
    }
}
