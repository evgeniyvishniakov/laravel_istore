<?php

namespace App\Http\Controllers\admin\AttributeValue;

use App\Http\Controllers\Controller;
use App\Models\admin\attrіbute\Attribute;
use App\Models\admin\attrіbute\AttributeValue;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

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
            'name' => [
                'required',
                'max:40',
                Rule::unique('attribute_values')->where(fn($query) =>
                $query->where('attribute_id', $request->attribute_id)
                ),
            ],
            'slug' => [
                'nullable',
                Rule::unique('attribute_values')->where(fn($query) =>
                $query->where('attribute_id', $request->attribute_id)
                ),
            ],
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


        return redirect()->route('attribute.show', ['attribute' => $request->attribute_id])->with('success', 'Атрибут успішно доданий!');
    }

    public function edit($attribute_slug, $value_slug)
    {
        // Получаем атрибут по слагу
        $attribute = Attribute::where('slug', $attribute_slug)->firstOrFail();

        // Получаем значение атрибута по слагу значения
        $value = AttributeValue::where('slug', $value_slug)
            ->where('attribute_id', $attribute->id)
            ->firstOrFail();

        return view('admin.attributes_values.edit_values', compact('value', 'attribute'));
    }

    public function update(Request $request, $attribute_id, $value_id)
    {

        $value = AttributeValue::where('attribute_id', $attribute_id)->where('id', $value_id)->firstOrFail();

        $messages = [
            //'name.required' => 'Имя атрибута обязательно для заполнения.',
            'name.unique' => 'Ця назва вже існує',
            //'slug.required' => 'Slug обязателен для заполнения.',
            'slug.unique' => 'Этот slug уже используется.',
        ];

        // Валидация данных
        $validatedData = $request->validate([
            'name' => 'required|max:20|unique:attribute_values,name', // Проверка уникальности для поля name
            'slug' => 'nullable|unique:attribute_values,slug' . $value->id,         // Исключение текущей записи из проверки
        ], $messages);

        // Генерируем slug его из name
        if (!$validatedData['slug']) {
            $validatedData['slug'] = Str::slug($validatedData['name']); // Генерация slug
        }


        $value->update($validatedData);


        return redirect()->route('attribute.show', ['attribute' => $attribute_id])->with('success', 'Атрибут успішно змінений!');
    }

    public function destroy($attr, $val) // Удаление значения атрибута
    {

        // Находим конкретное значение атрибута и удаляем
        $value = AttributeValue::where('attribute_id', $attr)->where('id', $val)->firstOrFail();
        $value->delete();

        // Переадресация обратно к списку значений атрибута
        return redirect()->route('attribute.show', ['attribute' => $attr])->with('success', 'Значення атрибуту видалено!');
    }


}
