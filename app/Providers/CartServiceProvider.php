<?php

namespace App\Providers;

use App\Models\admin\product\Product;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Session;


class CartServiceProvider extends ServiceProvider
{
    public function boot()
    {
        View::composer('shop.components.header', function ($view) {
            $cart = session()->get('cart', []); // Получаем корзину из сессии
            $cartData = [];

            if (!empty($cart)) {
                foreach ($cart as $productId => $item) {
                    $product = Product::find($productId);
                    if ($product) {
                        $cartData[] = [
                            'id' => $product->id,
                            'name' => $product->name,
                            'price' => $product->price,
                            'image_url' => $product->image_url,
                            'quantity' => $item['quantity'],
                        ];
                    }
                }
            }

            $view->with('cartData', $cartData); // Передаём данные корзины в представление
        });
    }
}
