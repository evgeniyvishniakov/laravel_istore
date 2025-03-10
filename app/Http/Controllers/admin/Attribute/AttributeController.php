<?php

namespace App\Http\Controllers\admin\Attribute;

use App\Http\Controllers\Controller;
use App\Models\admin\attrіbute\Attribute;
use Illuminate\Http\Request;
use Illuminate\Support\Str;


class AttributeController extends Controller
{
//        public function show() //Показ конкретной категории
//        {
//
//            //Route::get('/post/{id}',
//        }
        public function index() //Вывод списка категорий
       {
           $attributes = Attribute::all();

           return view('admin.attributes.attributes', ['attributes' => $attributes]);
        }
        public function create() //Откытие странициа создания категории
        {
            return view('admin.attributes.create');
        }

        public function store(Request $request)
        {

            $messages = [
                //'name.required' => 'Имя атрибута обязательно для заполнения.',
                'name.unique' => 'Ця назва вже існує',
                //'slug.required' => 'Slug обязателен для заполнения.',
                'slug.unique' => 'Этот slug уже используется.',
            ];

            // Валидация данных
            $validatedData = $request->validate([
                'name' => 'required|max:255|unique:attributes,name', // Проверка уникальности для поля name
                'slug' => 'nullable|unique:attributes,slug',         // Проверка уникальности для поля slug
            ], $messages);

            // Генерируем slug его из name
            if (!$validatedData['slug']) {
                $validatedData['slug'] = Str::slug($validatedData['name']); // Генерация slug
            }

            Attribute::create([
                'name' => $validatedData['name'],
                'slug' => $validatedData['slug'],
            ]);


            return redirect()->route('attribute.index')->with('success', 'Атрибут успішно доданий!');
        }
        public function edit($slug) //Откытие страници редактирования категории
        {
            $attribute = Attribute::where('slug', $slug)->firstOrFail();

         return view('admin.attributes.edit', compact('attribute'));
        }
        public function update(Request $request, $slug) //Редактирование категорий

        {
            $attribute = Attribute::where('slug', $slug)->firstOrFail();

            $messages = [
                //'name.required' => 'Имя атрибута обязательно для заполнения.',
                'name.unique' => 'Ця назва вже існує',
                //'slug.required' => 'Slug обязателен для заполнения.',
                'slug.unique' => 'Этот slug уже используется.',
            ];

            // Валидация данных
            $validatedData = $request->validate([
                'name' => 'required|max:255|unique:attributes,name', // Проверка уникальности для поля name
                'slug' => 'nullable|unique:attributes,slug',         // Проверка уникальности для поля slug
            ], $messages);

            // Генерируем slug его из name
            if (!$validatedData['slug']) {
                $validatedData['slug'] = Str::slug($validatedData['name']); // Генерация slug
            }

            $attribute->update($validatedData);

            return redirect()->route('attribute.index')->with('success', 'Атрибут успішно оновлений!');


        }
        public function destroy($id) //Удаление категории1
        {

            $attribute = Attribute::findOrFail($id);
            $attribute->delete();

            return redirect()->route('attribute.index')->with('success', 'Атрибут видалений!');

        }
}
