<?php

namespace App\Http\Controllers\shop\NovaPoshta;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Daaner\NovaPoshta\Facades\NovaPoshta;
use Illuminate\Support\Facades\Log;
use Daaner\NovaPoshta\Models\Address;

class NovaPoshtaController extends Controller
{

    public function getWarehousesBySettlement(Request $request)
    {
        $cityRef = $request->input('city_ref');

        if (!$cityRef) {
            return response()->json(['success' => false, 'message' => 'Город не указан'], 400);
        }

        $address = new Address();
        $warehouses = $address->getWarehouses($cityRef, false);

        return response()->json(['success' => true, 'result' => $warehouses]);
    }
}
