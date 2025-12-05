<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index(Request $request)
    {
        $query = Category::query()->withCount('news');

        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        $categories = $query->paginate(12);
        $categories->appends($request->all());

        // УВЕРИ СЕ, ЧЕ slug Е В SELECT!
        // Ако имаш $fillable или hidden – провери

        if ($request->ajax()) {
            return response()->json([
                'html' => view('partials.categories-grid', compact('categories'))->render(),
                'pagination' => $categories->links('partials.pagination')->render()
            ]);
        }

        return view('categories.index', compact('categories'));
    }

    public function show($slug)
    {
        $category = Category::where('slug', $slug)->with('news')->firstOrFail();

        $news = $category->news()->latest()->paginate(12);

        return view('categories.show', compact('category', 'news'));
    }
}