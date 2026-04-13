<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Category;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::all();
        return view('admin.categories.index', compact('categories'));
    }

    public function create()
    {
        return view('admin.categories.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'division_pj' => 'required|in:Sarpras,Tata Usaha,tefa',
        ], [
            'name.required' => 'The name field is required.',
            'division_pj.required' => 'The division pj field is required.',
        ]);

        Category::create($request->all());

        return redirect()->route('admin.categories.index')->with('success', 'Category added successfully.');
    }

    public function edit(Category $category)
    {
        return view('admin.categories.edit', compact('category'));
    }

    public function update(Request $request, Category $category)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'division_pj' => 'required|in:Sarpras,Tata Usaha,tefa',
        ], [
            'name.required' => 'The name field is required.',
            'division_pj.required' => 'The division pj field is required.',
        ]);

        $category->update($request->all());

        return redirect()->route('admin.categories.index')->with('success', 'Category updated successfully.');
    }
}
