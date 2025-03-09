<?php

namespace App\Http\Controllers\admin\Category;

use App\Http\Controllers\Controller;
use App\Models\admin\category\Category;
use Illuminate\Http\Request;



class CategoryController extends Controller
{

    public function index() //Вывод списка категорий
    {
        $categories = Category::all();
        //dump($categories);
        return view('admin.category.category', ['categories' => $categories]);

    }
    public function create() //Откытие странициа создания категории
    {
        return view('admin.category.edit');

    }

    public function store(Request $request) //Cоздание категорий
    {
        $timestamps = false;

        $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|string|max:255',
        ]);


        Category::create([
            'name' => $request->name,
            'slug' => $request->slug,
        ]);

        return redirect()->route('category.index')->with('success', 'Категорія успішно додана!');

    }
    public function edit() //Откытие страници редактирования категории
    {


    }
    public function update() //Редактирование категорий
    {

    }
    public function destroy($id) //Удаление категории1
    {

        $category = Category::findOrFail($id);
        $category->delete();

        return redirect()->route('category.index')->with('success', 'Категорія видалена!');

    }


}
