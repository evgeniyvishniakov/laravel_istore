<?php

namespace App\Http\Controllers\admin\Product;

use App\Http\Controllers\Controller;
use App\Models\admin\attrіbute\Attribute;
use App\Models\admin\attrіbute\AttributeValue;
use App\Models\admin\category\Category;
use App\Models\admin\product\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ProductController extends Controller
{

    public function index() //Вывод списка категорий
    {
        $products = Product::all();

        return view('admin.products.products', compact('products'));

    }
    public function create() //Откытие странициа создания категории
    {

          $categories = Category::all();
          $attributes = Attribute::all();
          //$attribute_values = AttributeValue::all();


        return view('admin.products.create',
               compact('categories', 'attributes'));

    }


    public function store(Request $request)
    {


        // Логируем все данные, отправленные в запросе
        Log::info('Данные формы:', $request->all());

        // Валидация данных
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'sku' => 'nullable|string|max:255',
            'desc' => 'nullable|string',
            'price' => 'nullable|numeric',
            'sale' => 'nullable|numeric',
            'qnt' => 'nullable|integer',
            'slug' => 'nullable|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'short_desc' => 'nullable|string',
            'visible' => 'nullable|boolean',
            'attributes' => 'nullable|array',
            'values' => 'nullable|array'
        ]);

        // Обработка изображения
        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('product_images', 'public');
        }

        // Создание товара
        $product = Product::create([
            'name' => $validated['name'],
            'sku' => $validated['sku'],
            'description' => $validated['desc'],
            'price' => $validated['price'],
            'sale' => $validated['sale'],
            'quantity' => $validated['qnt'],
            'slug' => $validated['slug'],
            'category_id' => $validated['category_id'],
            'image_url' => $imagePath,
            'short_desc' => $validated['short_desc'],
            'visible' => $validated['visible'] ?? 0,
        ]);

        // Логируем атрибуты и значения
        Log::info('Атрибуты: ', $request->input('attributes'));
        Log::info('Значения: ', $request->input('values'));

        if ($request->has('attributes') && $request->has('values')) {
            foreach ($request->input('attributes') as $index => $attributeId) {
                $valueId = $request->input('values')[$index];

                if ($attributeId && $valueId) {
                    Log::info("Добавляем атрибут: $attributeId с значением: $valueId");

                    // Записываем данные в промежуточную таблицу
                    $product->attributes()->attach($attributeId, ['attribute_value_id' => $valueId]);
                }
            }
        }

        return redirect()->route('product.index')->with('success', 'Товар успешно создан');
    }


    public function getAttributeValues($attribute_id)
    {
        // Проверяем, существует ли атрибут
        $attribute = Attribute::find($attribute_id);

        if (!$attribute) {
            return response()->json(['message' => 'Атрибут не найден'], 404);
        }

        // Получаем все значения атрибута с данным attribute_id
        $values = AttributeValue::where('attribute_id', $attribute_id)->get();

        // Проверяем, есть ли значения
        if ($values->isEmpty()) {
            return response()->json(['message' => 'Нет значений для данного атрибута'], 404);
        }

        // Возвращаем данные в формате JSON
        return response()->json($values);
    }
}
