<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MenuItem;
use App\Models\Page;
use App\Models\Category;
use App\Models\News;
use Illuminate\Http\Request;

class MenuController extends Controller
{
    public function index()
    {
        $items = MenuItem::with('children')->whereNull('parent_id')->orderBy('order')->get();
        return view('admin.menu.index', compact('items'));
    }

    public function create()
    {
        $menuItems   = MenuItem::whereNull('parent_id')->with('children')->orderBy('order')->get();
        $pages       = \App\Models\Page::all();
        $categories  = \App\Models\Category::orderBy('name')->get();
        $recentNews  = \App\Models\News::latest()->take(50)->get();

        return view('admin.menu.create', compact('menuItems', 'pages', 'categories', 'recentNews'));
    }

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

        $data = [
            'title'     => $request->title,
            'type'      => $request->type,
            'target_id' => in_array($request->type, ['page', 'news', 'category']) ? $request->target_id : null,
            'url'       => in_array($request->type, ['external', 'internal']) ? $request->url : null,
            'parent_id' => $request->parent_id,
            'depth'     => $depth,
            'order'     => MenuItem::where('parent_id', $request->parent_id)->max('order') + 1,
        ];

        if ($request->type === 'internal' && $request->url) {
            $path = parse_url($request->url, PHP_URL_PATH) ?: $request->url;
            $data['url'] = match($request->type) {
                'internal', 'external' => $request->url,
                default => null
            };
        }

        $data['url'] = match($request->type) {
            'internal', 'external' => $request->url,
            default => null
        };

        $data['target_id'] = in_array($request->type, ['page', 'category', 'news']) ? $request->target_id : null;


        MenuItem::create($data);

        return redirect()->route('admin.menu.index')->with('success', 'Елементът е добавен успешно!');
    }

    public function edit(MenuItem $menuItem)
    {
        $menuItems = MenuItem::where('id', '!=', $menuItem->id)->get();
        $pages = Page::all();
        $categories = Category::orderBy('name')->get();
        $recentNews = News::latest()->take(50)->get();

        return view('admin.menu.edit', compact('menuItem', 'menuItems', 'pages', 'categories', 'recentNews'));
    }

    public function update(Request $request, MenuItem $menuItem)
    {
        $request->validate([
            'title'      => 'required|string|max:255',
            'type'       => 'required|in:page,news,category,external,internal',
            'target_id'  => 'required_if:type,page,news,category|nullable|integer',
            'url'        => 'required_if:type,external,internal|nullable|string|max:255',
            'parent_id'  => 'nullable|exists:menu_items,id',
        ]);

        $data = [
            'title'     => $request->title,
            'type'      => $request->type,
            'target_id' => in_array($request->type, ['page', 'news', 'category']) ? $request->target_id : null,
            'url'       => in_array($request->type, ['external', 'internal']) ? $request->url : null,
            'parent_id' => $request->parent_id,
        ];

        if ($request->type === 'internal' && $request->url) {
            $path = parse_url($request->url, PHP_URL_PATH) ?: $request->url;
            $data['url'] = match($request->type) {
                'internal', 'external' => $request->url,
                default => null
            };
        }
        $data['target_id'] = in_array($request->type, ['page', 'category', 'news']) ? $request->target_id : null;
        $menuItem->update($data);

        return redirect()->route('admin.menu.index')->with('success', 'Елементът е обновен!');
    }

    public function destroy(MenuItem $menuItem)
    {
        $menuItem->delete();
        return back()->with('success', 'Елементът е изтрит!');
    }
}