<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    // halaman manajemen kategori
    public function index()
    {
        $categories = Category::all();
        return view('dashboard.admin.categories', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:categories,name',
        ]);

        Category::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
        ]);

        return redirect()->back()->with('success', 'Category created successfully.');
    }

    public function destroy($id)
    {
        $category = Category::findOrFail($id)
                ->delete();

        return redirect()->back()->with('success', 'Category deleted successfully.');
    }

}
