<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MenuItem;
use App\Models\Page;
use App\Models\News;
use App\Models\Category;
use Illuminate\Http\Request;

class MenuController extends Controller
{
    public function index()
    {
        $items = MenuItem::orderBy('order')->get();
        return view('admin.menu.index', compact('items'));
    }

    public function create()
    {
        $pages = Page::pluck('title', 'id');
        $news = News::pluck('title', 'id');
        $categories = Category::pluck('name', 'id');
        return view('admin.menu.create', compact('pages', 'news', 'categories'));
    }

   /* public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'type' => 'required|in:page,news,category,external,internal',
            'target_id' => 'required_if:type,page,news,category',
            'url' => 'required_if:type,external',
            'parent_id' => 'nullable|exists:menu_items,id'
        ]);

        $parent = $request->parent_id ? MenuItem::find($request->parent_id) : null;
        $depth = $parent ? $parent->depth + 1 : 0;

        $data = $request->only('title', 'type', 'target_id', 'url', 'parent_id');
        $data['depth'] = $depth;
        $data['order'] = MenuItem::where('parent_id', $request->parent_id)->max('order') + 1;

        MenuItem::create($data);

        return redirect()->route('admin.menu.index')->with('success', 'Елементът е добавен!');
    }*/
    public function store(Request $request)
    {
        $request->validate([
            'title'      => 'required|string|max:255',
            'type'       => 'required|in:page,news,category,external,internal',
            'target_id'  => 'required_if:type,page,news,category|nullable|integer',
            'url'        => 'required_if:type,external,internal|nullable|string|max:255',
            'parent_id'  => 'nullable|exists:menu_items,id',
        ]);

        $parent = $request->parent_id ? MenuItem::find($request->parent_id) : null;
        $depth  = $parent ? $parent->depth + 1 : 0;

        $data = $request->only('title', 'type', 'target_id', 'url', 'parent_id');
        $data['depth'] = $depth;
        $data['order'] = MenuItem::where('parent_id', $request->parent_id)->max('order') + 1;

        // КЛЮЧЪТ: за internal линк – запазваме само пътя с водеща /
        if ($request->type === 'internal') {
            $cleanPath = '/' . ltrim(parse_url($request->url, PHP_URL_PATH) ?: $request->url, '/');
            $cleanPath = strtok($cleanPath, '?'); // премахва query string
            $data['url'] = $cleanPath;
        }

        MenuItem::create($data);

        return redirect()->route('admin.menu.index')
            ->with('success', 'Елементът е добавен успешно!');
    }


    public function edit(MenuItem $menuItem)
    {
        $pages = \App\Models\Page::all();
        $news = \App\Models\News::latest()->take(50)->get();
        $categories = \App\Models\Category::all();
        $menuItems = \App\Models\MenuItem::where('id', '!=', $menuItem->id)->get();

        return view('admin.menu.edit', compact(
            'menuItem', 'pages', 'news', 'categories', 'menuItems'
        ));
    }

    public function update(Request $request, MenuItem $menuItem)
    {
        $request->validate([
            'title'     => 'required|string|max:255',
            'type'      => 'required|in:external,page,news,category,internal',
            'url'       => 'required_if:type,external|nullable|url',
            'target_id' => 'required_if:type,page,news,category|nullable|integer',
            'parent_id' => 'nullable|exists:menu_items,id',
        ]);

        $data = $request->only(['title', 'type', 'url', 'target_id', 'parent_id']);

        // Изчисляваме depth
        $parent = $request->parent_id ? MenuItem::find($request->parent_id) : null;
        $data['depth'] = $parent ? $parent->depth + 1 : 0;

        if ($request->type === 'internal' && $request->filled('url')) {
            $cleanPath = '/' . ltrim(parse_url($request->url, PHP_URL_PATH) ?: $request->url, '/');
            $cleanPath = strtok($cleanPath, '?');
            $data['url'] = $cleanPath;
        }

        $menuItem->update($data);

        return redirect()->route('admin.menu.index')->with('success', 'Елементът е обновен!');
    }

    public function destroy(MenuItem $menuItem)
    {
        // Изтриваме и децата (ако има)
        $menuItem->children()->delete();
        $menuItem->delete();

        return redirect()->route('admin.menu.index')->with('success', 'Елементът е изтрит!');
    }

    /*public function reorder(Request $request)
    {
        $order = $request->order;
        foreach ($order as $index => $id) {
            MenuItem::where('id', $id)->update(['order' => $index + 1]);
        }
        return response()->json(['success' => true]);
    }*/
    public function reorder(Request $request)
    {
        $order = $request->order;
        foreach ($order as $index => $item) {
            $menuItem = MenuItem::find($item['id']);
            if ($menuItem) {
                $menuItem->order = $index + 1;
                $menuItem->parent_id = $item['parent_id'];
                $menuItem->save();
            }
        }
        return response()->json(['success' => true]);
    }
}