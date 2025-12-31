<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;

class CategoryController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:100|unique:categories,name'
        ]);

        Category::create($request->only('name'));

        return back()->with('success', 'Kategori berhasil ditambahkan');
    }

    public function update(Request $request, Category $category)
    {
        $request->validate([
            'name' => 'required|string|max:100|unique:categories,name,' . $category->id
        ]);

        $category->update($request->only('name'));

        return back()->with('success', 'Kategori berhasil diperbarui');
    }

    public function destroy(Category $category)
    {
        if ($category->foods_count > 0) {
            return back()->with('error', 'Kategori masih digunakan oleh makanan');
        }

        $category->delete();

        return back()->with('success', 'Kategori berhasil dihapus');
    }
}
