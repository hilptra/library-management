<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    // Menampilkan daftar kategori
    public function index() {
        $categories = Category::latest()->get();
        return view('admin.category.index', compact('categories'));
    }

    // Menyimpan kategori baru
    public function store(Request $request) {
        $request->validate([
            'name'=> 'required|string|max:255|unique:categories,name',
        ]);

        Category::create([
            'name' => $request->name,
        ]);

        return redirect()->back()->with('success', 'Kategori berhasil ditambahkan');
    }

    // Memperbarui kategori 
    public function update(Request $request, Category $category) {
        $request->validate([
            'name' => 'required|string|max:255|unique:categories,name,'. $category->id,
        ]);

        $category->update([
            'name' => $request->name,
        ]);

        return redirect()->back()->with('success', 'Kategori berhasil diperbarui');
    }

    // Menghapus kategori
    public function destroy(Category $category) {
        $category->delete();

        return redirect()->back()->with('success', 'Kategori berhasil dihapus');
    }

}
