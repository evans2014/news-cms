<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class PublicCategoryController extends Controller
{

    public function index(Request $request)
    {
        $categories = Category::withCount('news')
            ->orderBy('name')
            ->paginate(20);

        return view('categories.index', compact('categories'));

    }


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


}