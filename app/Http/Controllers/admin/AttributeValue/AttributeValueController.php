<?php

namespace App\Http\Controllers\admin\AttributeValue;

use App\Http\Controllers\Controller;
use App\Models\admin\attrіbute\AttributeValue;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AttributeValueController extends Controller
{


    public function store(Request $request) //Cоздание категорий
    {

        $messages = [
            //'name.required' => 'Имя атрибута обязательно для заполнения.',
            'name.unique' => 'Ця назва вже існує',
            //'slug.required' => 'Slug обязателен для заполнения.',
            'slug.unique' => 'Этот slug уже используется.',
        ];

        // Валидация данных
        $validatedData = $request->validate([
            'name' => 'required|max:20|unique:attribute_values,name', // Проверка уникальности для поля name
            'slug' => 'nullable|unique:attribute_values,slug',         // Проверка уникальности для поля slug
        ], $messages);

        // Генерируем slug его из name
        if (!$validatedData['slug']) {
            $validatedData['slug'] = Str::slug($validatedData['name']); // Генерация slug
        }

        AttributeValue::create([
            'attribute_id' => $request->attribute_id,
            'name' => $validatedData['name'],
            'slug' => $validatedData['slug'],
        ]);


        return redirect()->route('attribute.show', array('attribute' => $request->attribute_id))->with('success', 'Атрибут успішно доданий!');
    }
}
