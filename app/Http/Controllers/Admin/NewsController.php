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
   /* public function store(Request $request)
    {
        $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'required',
            'image'       => 'required|image|max:2048',
            'categories'  => 'required|array',                    // ← задължително
            'categories.*'=> 'exists:categories,id',
        ]);

        $imagePath = $request->file('image')->store('news', 'public');

        $news = News::create([
            'title'       => $request->title,
            'description' => $request->description,
            'image'       => $imagePath,
        ]);

        // ← ТОВА Е КЛЮЧЪТ – sync() винаги трябва да се изпълнява
        $news->categories()->sync($request->categories);

        return redirect()->route('admin.news.index')
            ->with('success', 'Новината е създадена успешно!');
    }
*/
    public function show(News $news)
    {
        return view('admin.news.show', compact('news'));
    }

    public function edit(News $news)
    {
        $categories = Category::all();
        return view('admin.news.edit', compact('news', 'categories'));
    }

   /* public function update(Request $request, News $news)
    {
        $request->validate([
            'title' => 'required|max:255',
            'description' => 'required',
            'image' => 'nullable|image|max:2048',
            'category_id' => 'required|exists:categories,id',
        ]);

        if ($request->file('image')) {
            $image = $request->file('image')->store('news', 'public');
            $news->image = $image;
        }
        $news->update($news);

        $news->categories()->sync($request->categories);

        //$news->update($request->only('title', 'description', 'category_id'));

        return redirect()->route('admin.news.index')->with('success', 'Новината е обновена!');
    }*/
    /*public function update(Request $request, News $news)
    {
        $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'required',
            'image'       => 'nullable|image|max:2048',  // nullable, защото може да не се качва нова
            'categories'  => 'required|array|min:1',
            'categories.*'=> 'exists:categories,id',
        ]);

        // ← ТУК СЪЗДАВАМЕ $data
        $data = [
            'title'       => $request->title,
            'description' => $request->description,
        ];

        // Ако има нова снимка – добавяме я
        if ($request->hasFile('image')) {
            // по желание: изтрий старата
            // Storage::disk('public')->delete($news->image);

            $data['image'] = $request->file('image')->store('news', 'public');
        }

        // ← Сега вече можем да ползваме $data
        $news->update($data);

        // ← Записваме категориите (много към много)
        $news->categories()->sync($request->categories);

        return redirect()->route('admin.news.index')
            ->with('success', 'Новината е обновена успешно!');
    }*/
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
   /* public function update(Request $request, News $news)
    {
        $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'required',
            'image'       => 'nullable|image|max:2048',
            'categories'  => 'required|array',
            'categories.*'=> 'exists:categories,id',
        ]);

        $data = [
            'title'       => $request->title,
            'description' => $request->description,
        ];

        if ($request->hasFile('image')) {
            // изтрий старата снимка ако искаш
            $data['image'] = $request->file('image')->store('news', 'public');
        }

        $news->update($data);

        // ← И ТУК sync() задължително
        $news->categories()->sync($request->categories);

        return redirect()->route('admin.news.index')
            ->with('success', 'Новината е обновена!');
    }*/


}