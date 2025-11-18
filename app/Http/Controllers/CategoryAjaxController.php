<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryAjaxController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->get('search', '');

        $categories = Category::query()
            ->when($search, function ($q) use ($search) {
                $q->where('name', 'LIKE', "%{$search}%");
            })
            ->withCount('news')
            ->orderBy('name')
            ->paginate(24);

        $html = view('partials.categories-grid', compact('categories'))->render();

        return response()->json([
            'html' => $html,
            'pagination' => $categories->links('pagination::bootstrap-5')->render(),
        ]);
    }
}