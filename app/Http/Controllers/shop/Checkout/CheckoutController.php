<?php

namespace App\Http\Controllers\shop\Checkout;

use App\Http\Controllers\Controller;
use Daaner\NovaPoshta\Facades\NovaPoshta;
use Daaner\NovaPoshta\Models\Address;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class CheckoutController extends Controller
{


    public function getWarehouses(Request $request)
    {
        $cityRef = $request->input('city_ref');

        if (!$cityRef) {
            return response()->json(['success' => false, 'error' => 'CityRef is required'], 400);
        }

        $adr = new Address();
        $warehouses = $adr->getWarehouses($cityRef, false);

        if (!empty($warehouses['result'])) {
            return response()->json(['success' => true, 'result' => $warehouses['result']]);
        } else {
            return response()->json(['success' => false, 'result' => [], 'error' => 'No warehouses found']);
        }
    }


    public function checkout()
    {
        $cart = session()->get('cart', []);
        $adr = new Address();
        $cities = $adr->getCities();

        if (!$cities || !isset($cities['result']) || !is_array($cities['result'])) {
            $cities = []; // Если ошибка, передаем пустой массив
        }

        return view('shop.checkout.checkout', compact('cities', 'cart'));
    }

    public function getCities()
    {
        $adr = new Address();
        return response()->json($adr->getCities());
    }



}
