<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class PublicCategoryController extends Controller
{
   /* public function index(Request $request)
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
*/
    // app/Http/Controllers/PublicCategoryController.php
    public function index(Request $request)
    {
        $categories = Category::withCount('news')
            ->orderBy('name')
            ->paginate(20);

        return view('categories.index', compact('categories'));
        // ← увери се, че има return!
    }
   /* public function show($slug)
    {
        $category = \App\Models\Category::where('slug', $slug)
            ->with('news')           // или with('news.categories') ако искаш
            ->firstOrFail();

        // Ако искаш и подкатегории или нещо друго – тук

        return view('categories.show', compact('category'));
    }*/

    public function show($slug)
    {
        $category = Category::where('slug', $slug)
            ->withCount('news')     // ← това прави news_count
            ->with('news')          // ← това зарежда самите новини
            ->firstOrFail();
        $title       = $category->name . ' – новини';
        $description = "Всички новини от категория {$category->name} – актуално и точно.";
        return view('categories.show', compact('category', 'title', 'description'));
    }

    /*
    public function show($slug)
    {
        $category = Category::where('slug', $slug)->with('news')->firstOrFail();

        $news = $category->news()->latest()->paginate(9);

        return view('categories.show', compact('category', 'news'));
    }*/

}