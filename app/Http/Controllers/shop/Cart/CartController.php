<?php

namespace App\Http\Controllers\shop\Cart;

use App\Models\admin\product\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;

class CartController extends Controller
{
    public function addToCart(Request $request)
    {
        $productId = $request->input('product_id');
        $quantity = $request->input('quantity', 1);

        $product = Product::find($productId);

        if ($product) {
            $cart = session()->get('cart', []);

            if (isset($cart[$productId])) {
                $cart[$productId]['quantity'] += $quantity;
            } else {
                // Добавляем товар в корзину с нужными данными
                $cart[$productId] = [
                    'product_id' => $productId,
                    'name' => $product->name,
                    'price' => $product->price,
                    'quantity' => $quantity,
                    'image_url' => $product->image_url,
                ];
            }

            session()->put('cart', $cart);
            return redirect()->back()->with('success', 'Товар добавлен в корзину!');
        } else {
            return redirect()->back()->with('error', 'Товар не найден!');
        }
    }

    public function showCart()
    {
        // Получаем корзину из сессии
        $cart = session()->get('cart', []);
        // Возвращаем вид с корзиной и передаем данные
        return view('shop.cart.cart', compact('cart'));
    }

    public function update(Request $request)
    {
        $productId = $request->input('product_id');
        $action = $request->input('action');

        $cart = session()->get('cart', []);

        if (isset($cart[$productId])) {
            if ($action === 'increase') {
                $cart[$productId]['quantity']++;
            } elseif ($action === 'decrease' && $cart[$productId]['quantity'] > 1) {
                $cart[$productId]['quantity']--;
            }

            // Обновляем корзину в сессии
            session()->put('cart', $cart);
        }

        // Возвращаем обновленные данные
        $totalPrice = 0;
        foreach ($cart as $item) {
            $totalPrice += $item['price'] * $item['quantity'];
        }

        return response()->json([
            'success' => true,
            'newQuantity' => $cart[$productId]['quantity'],
            'totalPrice' => $totalPrice
        ]);
    }
    public function remove(Request $request)
    {
        $productId = $request->input('product_id');

        $cart = session()->get('cart', []);

        // Удаляем товар из корзины
        if (isset($cart[$productId])) {
            unset($cart[$productId]);
        }

        // Обновляем корзину в сессии
        session()->put('cart', $cart);

        // Пересчитываем итоговую цену
        $totalPrice = 0;
        foreach ($cart as $item) {
            $totalPrice += $item['price'] * $item['quantity'];
        }

        return response()->json([
            'success' => true,
            'totalPrice' => $totalPrice
        ]);
    }
}
