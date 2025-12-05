<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use App\Models\News;
use App\Models\Category;


class NewsController extends Controller
{

    public function index(Request $request)
    {
        $search = $request->get('search');

        $news = News::latest()
            ->when($search, function($query) use ($search) {
                $query->where('title', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%");
            })
            ->paginate(10)
            ->appends(['search' => $search]);

        return view('admin.news.index', compact('news'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('admin.news.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'required',
            'image'       => 'nullable|string',
            'category_id' => 'required|exists:categories,id',
        ]);
        
        $news = News::create([
            'title' => $request->title,
            'description' => $request->description,
            'image' => $request->image,
            'category_id' => $request->category_id, // <-- записва в news
        ]);

        $news->categories()->attach($request->category_id);

        return redirect()->route('admin.news.index')
            ->with('success', 'Новината е създадена успешно!');
    }

    public function update(Request $request, News $news)
    {
        $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'required',
            'image'       => 'nullable|string',
            'category_id' => 'required|exists:categories,id',
        ]);

        $news->update([
            'title' => $request->title,
            'description' => $request->description,
            'image' => $request->image,
            'category_id' => $request->category_id,
        ]);

        $news->categories()->sync($request->category_id);


        return back()->with('success', 'Новината е обновена успешно!');
    }

    public function show(News $news)
    {
        return view('admin.news.show', compact('news'));
    }

    public function edit(News $news)
    {
        $categories = Category::all();
        return view('admin.news.edit', compact('news', 'categories'));
    }

     public function destroy(News $news)
    {
        $news->delete();
        return redirect()->route('admin.news.index')->with('success', 'Новината е изтрита!');
    }

}