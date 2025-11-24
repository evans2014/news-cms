<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryGridController extends Controller
{
    public function index()
    {
        return view('admin.categories.grid');
    }

    public function search(Request $request)
    {
        $query = Category::query();

        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        $categories = $query->withCount('news')->paginate(24);
        $categories->appends($request->all());

        return response()->json([
            'html' => view('admin.categories.grid-items', compact('categories'))->render(),
            'pagination' => $categories->links('admin.partials.pagination')->render()
        ]);
    }

    public function show($id)
    {
        $category = Category::with('news')->withCount('news')->findOrFail($id);
        return response()->json([
            'name' => $category->name,
            'news_count' => $category->news_count,
            'news' => $category->news->map(function ($news) {
                return [
                    'title' => $news->title,
                    'image' => $news->image ? asset('storage/' . $news->image) : null,
                    'created_at' => $news->created_at->format('d.m.Y'),
                    'url' => route('news.show', $news->id)
                ];
            })
        ]);
    }
}