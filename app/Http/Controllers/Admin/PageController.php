<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Page;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PageController extends Controller
{
    public function index()
    {
        $pages = Page::latest()->paginate(10);
        return view('admin.pages.index', compact('pages'));
    }

    public function create()
    {
        return view('admin.pages.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title'   => 'required|string|max:255',
            'slug'    => 'required|string|unique:pages,slug',
            'content' => 'required|string',   // ← задължително!
        ]);

        Page::create($validated);   // ← всичко (вкл. content) се записва автоматично

        return redirect()->route('admin.pages.index')->with('success', 'Страницата е създадена!');
    }

    public function update(Request $request, Page $page)
    {
        $validated = $request->validate([
            'title'   => 'required|string|max:255',
            'slug'    => 'required|string|unique:pages,slug,' . $page->id,
            'content' => 'required|string',
        ]);

        $page->update($validated);

        return back()->with('success', 'Страницата е обновена!');
    }

    public function edit(Page $page)
    {
        return view('admin.pages.edit', compact('page'));
    }

    public function show(Page $page)
    {
        return view('admin.pages.show', compact('page'));
    }


    public function upload(Request $request)
    {
        $request->validate([
            'file' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $path = $request->file('file')->store('pages', 'public');

        return response()->json([
            'location' => asset('storage/' . $path)
        ]);
    }

    public function destroy(Page $page)
    {
        $page->delete();
        return redirect()->route('admin.pages.index')->with('success', 'Страницата е изтрита!');
    }
}