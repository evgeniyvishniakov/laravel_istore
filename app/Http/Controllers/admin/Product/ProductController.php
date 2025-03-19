<?php

namespace App\Http\Controllers\admin\Product;

use App\Http\Controllers\Controller;
use App\Models\admin\attrіbute\Attribute;
use App\Models\admin\attrіbute\AttributeValue;
use App\Models\admin\category\Category;
use App\Models\admin\product\Product;
use App\Models\admin\product_gallery\ProductImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    public function show($id)
    {
        $product = Product::findOrFail($id); // Найти товар или вернуть 404
        return redirect()->route('admin.products.index')->with('success', 'Товар успешно обновлён');
    }

    public function index() //Вывод списка категорий
    {
        $products = Product::all();

        return view('admin.products.products', compact('products'));

    }

    public function create() //Откытие странициа создания товара
    {

          $categories = Category::all();
          $attributes = Attribute::all();



        return view('admin.products.create',
               compact('categories', 'attributes'));

    }


    public function store(Request $request) //Создаем
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
            'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
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

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('products', 'public');

                ProductImage::create([
                    'product_id' => $product->id,
                    'image_url' => $path,
                    'type' => 'gallery',
                ]);
            }
        }


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


    public function edit($id) // Редактируем
    {
        // Загружаем товар с атрибутами и их значениями
        $product = Product::with(['attributes' => function ($query) {
            $query->with('values');
        }])->findOrFail($id);

        // Получаем только те атрибуты, которые связаны с этим товаром
        $attributeIds = $product->attributes->pluck('id')->toArray();
        $attributes = Attribute::with('values')->whereIn('id', $attributeIds)->get();

        // Создаём массив [attribute_id => value_id] из pivot-таблицы
        $selectedValues = [];
        foreach ($product->attributes as $attribute) {
            $selectedValues[$attribute->id] = $attribute->pivot->attribute_value_id ?? null;
        }

        $categories = Category::all();
        $attributes_edit = Attribute::all();

        return view('admin.products.edit', compact('product', 'attributes', 'categories', 'attributes_edit', 'selectedValues'));
    }

    public function update(Request $request, $id) //обновляем
    {

        Log::info('Данные формы для обновления:', $request->all());

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
            'values' => 'nullable|array',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        // После того как товар был сохранен
        $product = Product::find($id);

// Привязка изображений (если они изменяются)
        if ($request->hasFile('images')) {
            // Удаление старых изображений (если необходимо)
            $product->images()->delete();

            // Сохранение новых изображений
            foreach ($request->file('images') as $image) {
                $path = $image->store('products', 'public');

                ProductImage::create([
                    'product_id' => $product->id,
                    'image_url' => $path,
                    'type' => 'gallery',
                ]);
            }
        }

        $imagePath = $product->image_url;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('product_images', 'public');
        }

        // Обновление данных товара
        $product->update([
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

        // Обработка дополнительных изображений (если они есть)
        if ($request->hasFile('images')) {
            // Удаляем старые изображения (если они были)
            $product->images()->delete();

            // Добавляем новые изображения
            foreach ($request->file('images') as $image) {
                $path = $image->store('product_images', 'public');

                ProductImage::create([
                    'product_id' => $product->id,
                    'image_url' => $path,
                    'type' => 'gallery',
                ]);
            }
        }

        // Логируем атрибуты и значения
        Log::info('Атрибуты: ', $request->input('attributes'));
        Log::info('Значения: ', $request->input('values'));

        // Обновляем атрибуты и их значения
        if ($request->has('attributes') && $request->has('values')) {
            // Сначала удаляем старые атрибуты
            $product->attributes()->detach();

            // Добавляем новые атрибуты
            foreach ($request->input('attributes') as $attributeId => $valueId) {
                if (!$attributeId || !$valueId) {
                    Log::warning("Отсутствует значение для атрибута ID: $attributeId");
                    continue;
                }

                $product->attributes()->attach($attributeId, ['attribute_value_id' => $valueId]);
            }

        }

        return redirect()->route('product.index')->with('success', 'Товар успешно обновлён');
    }

    public function destroy($id)
    {
        // Находим товар по ID
        $product = Product::findOrFail($id);

        // Удаляем все изображения товара
        foreach ($product->images as $image) {
            Storage::disk('public')->delete($image->image_url); // Удаляем файл из storage
            $image->delete(); // Удаляем запись из базы
        }

        // Удаляем связи атрибутов и значений для этого товара
        $product->attributes()->detach();  // Удаляем связи с атрибутами

        // Удаляем сам товар
        $product->delete();

        return redirect()->route('product.index')->with('success', 'Товар успешно удалён');
    }

    public function duplicate($productId)
    {
        // Находим оригинальный товар
        $originalProduct = Product::findOrFail($productId);

        // Создаем новый товар с такими же аттрибутами
        $newProduct = $originalProduct->replicate(); // Копируем товар
        $newProduct->name = $originalProduct->name . ' -copy'; // Добавляем суффикс -copy к названию
        $newProduct->slug = Str::slug($newProduct->name); // Генерируем новый slug на основе нового названия
        $newProduct->save(); // Сохраняем новый товар

        // Копируем изображения
        foreach ($originalProduct->images as $image) {
            // Прописываем путь к изображению для нового товара
            $newImagePath = $image->image_url;

            // Создаем новый объект для изображения
            ProductImage::create([
                'product_id' => $newProduct->id, // Связываем с новым товаром
                'image_url' => $newImagePath, // Путь к изображению
                'type' => $image->type, // Тип изображения (если нужно)
            ]);
        }

        // Копируем атрибуты и их значения для нового товара
        foreach ($originalProduct->attributes as $attribute) {
            $newProduct->attributes()->attach($attribute->pivot->attribute_id, [
                'attribute_value_id' => $attribute->pivot->attribute_value_id
            ]);
        }

        return redirect()->route('product.index')->with('success', 'Товар успешно скопирован');
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
