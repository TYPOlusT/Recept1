<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::all();
        return view('categories.categories')->with(['categories' => $categories]);
    }

    public function create()
    {
        return view('categories.create');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255|unique:categories,name',
        ]);

        if ($validator->fails()) {
            return redirect()->route('category.create')->withErrors($validator)->withInput();
        }

        Category::create($validator->validated());
        return redirect()->route('category.index')->with('success', 'Категория добавлена');
    }

    public function edit($id)
    {
        $category = Category::findOrFail($id);
        return view('categories.edit')->with(['category' => $category]);
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255|unique:categories,name,' . $id,
        ]);

        if ($validator->fails()) {
            return redirect()->route('category.edit', $id)->withErrors($validator)->withInput();
        }

        $category = Category::findOrFail($id);
        $category->update($validator->validated());
        return redirect()->route('category.index')->with('success', 'Категория обновлена');
    }

    public function destroy($id)
    {
        $category = Category::findOrFail($id);
        $category->delete();
        return redirect()->route('category.index')->with('success', 'Категория удалена');
    }
}
