<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CategoryController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->get('search');

        $categories = Category::latest()
            ->when($search, function($query) use ($search) {
                $query->where('name', 'like', "%{$search}%");
            })
            ->paginate(10)
            ->appends(['search' => $search]);

       // return view('admin.categories.index', compact('categories'));
        return response()
            ->view('admin.categories.index', compact('categories'))
            ->header('Cache-Control', 'no-cache, no-store, must-revalidate')
            ->header('Pragma', 'no-cache')
            ->header('Expires', '0');
    }

    public function create()
    {
        return view('admin.categories.create');
    }

    public function show(Category $category)
    {
        return view('admin.categories.show', compact('category'));
    }

    public function edit(Category $category)
    {
        return view('admin.categories.edit', compact('category'));
    }

    public function store(Request $request)
    {
        $data = $request->only(['name', 'image']); // взимаме само тези две

        Category::create($data);

        return redirect()->route('admin.categories.index')
            ->with('success', 'Категорията е създадена успешно!');
    }

    public function update(Request $request, Category $category)
    {
        $data = $request->only(['name', 'image']);

        $category->update($data);

        return back()->with('success', 'Категорията е обновена!');
    }

    public function destroy(Category $category)
    {
        if ($category->image) {
            Storage::disk('public')->delete($category->image);
        }
        $category->delete();

        return redirect()->route('admin.categories.index')->with('success', 'Категорията е изтрита!');
    }
}