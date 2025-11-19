<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\News;
use Illuminate\Http\Request;


class NewsController extends Controller
{
    public function index()
    {
        $news = News::with('category')->latest()->paginate(10);
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
            'title' => 'required|max:255',
            'description' => 'required',
            'image' => 'required|image|max:2048',
            'category_id' => 'required|exists:categories,id',
        ]);

        $image = $request->file('image')->store('news', 'public');

        $news = News::create([
            'title' => $request->title,
            'description' => $request->description,
            'image' => $image,
            'category_id' => $request->category_id,
        ]);
        $news->categories()->sync($request->categories);
        return redirect()->route('admin.news.index')->with('success', 'Новината е създадена!');
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

    public function update(Request $request, News $news)
    {
        $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'required',
            'image'       => 'nullable|image|max:2048',
            'categories'  => 'required|array|min:1',
            'categories.*'=> 'exists:categories,id',
        ]);

        $data = $request->only(['title', 'description']);

        if ($request->hasFile('image')) {
            // по желание: изтрий старата снимка
            // Storage::disk('public')->delete($news->image);
            $data['image'] = $request->file('image')->store('news', 'public');
        }

        $news->update($data);

        $news->categories()->sync($request->categories);   // ← записва всички избрани

        return redirect()->route('admin.news.index')
            ->with('success', 'Новината е обновена успешно!');
    }

    public function destroy(News $news)
    {
        $news->delete();
        return redirect()->route('admin.news.index')->with('success', 'Новината е изтрита!');
    }

}