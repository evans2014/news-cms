<?php

namespace App\Http\Controllers;

use App\Models\News;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class NewsAjaxController extends Controller
{
    public function index()
    {
        return view('home');
    }

    public function ajax(Request $request)
    {
        $search = $request->query('search', '');

        $query = News::with('categories')->latest();

        if ($search !== '') {
            $query->where(function($q) use ($search) {
                $q->where('title', 'LIKE', "%{$search}%")
                    ->orWhere('description', 'LIKE', "%{$search}%");
            });
        }

        $news = $query->paginate(12);

        $html = view('partials.news-grid', compact('news'))->render();
        $pagination = $news->appends(['search' => $search])
            ->links('pagination::bootstrap-5')
            ->render();

        return response()->json([
            'html'       => $html,
            'pagination' => $pagination,
        ]);
    }

}