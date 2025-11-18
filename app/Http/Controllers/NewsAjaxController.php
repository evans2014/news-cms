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


    /*public function ajax(Request $request)
    {
        $search = $request->get('search', '');
        $query = News::with('category')->latest();

        if ($search) {
            $query->where('title', 'like', "%{$search}%")
                ->orWhere('description', 'like', "%{$search}%");
        }

        $news = $query->paginate(9);

        $html = view('partials.news-grid', compact('news'))->render();
        $pagination = $news->appends(['search' => $search])->links('pagination::bootstrap-5')->render();

        return response()->json([
            'html' => $html,
            'pagination' => $pagination
        ]);
    }*/

   /* public function ajax(Request $request)
    {
        $search = trim($request->get('search', ''));

        $query = News::with('categories')->latest();

        if ($search !== '') {
            // Правим търсенето 100% case-insensitive и за кирилица
            $like = "%%%s%%"; // %search%

            // SQLite няма вградена unicode case-insensitive колация → правим го ръчно
            $searchLower = mb_strtolower($search, 'UTF-8');
            $searchUpper = mb_strtoupper($search, 'UTF-8');

            $query->where(function ($q) use ($searchLower, $searchUpper, $like) {
                $q->whereRaw('LOWER(title) LIKE ?', [sprintf($like, $searchLower)])
                    ->orWhereRaw('UPPER(title) LIKE ?', [sprintf($like, $searchUpper)])
                    ->orWhereRaw('LOWER(description) LIKE ?', [sprintf($like, $searchLower)])
                    ->orWhereRaw('UPPER(description) LIKE ?', [sprintf($like, $searchUpper)]);
            });
        }

        $news = $query->paginate(9);

        $html       = view('partials.news-grid', compact('news'))->render();
        $pagination = $news->appends(['search' => $search])
            ->links('pagination::bootstrap-5')
            ->render();

        return response()->json([
            'html'       => $html,
            'pagination' => $pagination,
        ]);
    }*/
    // NewsAjaxController.php
   /* public function ajax(Request $request)
    {
        $search = trim($request->get('search', ''));

        $query = News::with('categories')->latest();

        if ($search !== '') {
            $query->where('title', 'LIKE', "%{$search}%")
                ->orWhere('description', 'LIKE', "%{$search}%");
        }


        $news = $query->paginate(9);

        $html = view('partials.news-grid', compact('news'))->render();
        $pagination = $news->appends(['search' => $search])
            ->links('pagination::bootstrap-5')
            ->render();

        return response()->json([
            'html'       => $html,
            'pagination' => $pagination,
        ]);
    }*/
   /* public function ajax(Request $request)
    {
        $search = trim($request->get('search', ''));

        $query = News::with('categories')->latest();

        if ($search !== '') {
            $query->where('title', 'LIKE', "%{$search}%")
                ->orWhere('description', 'LIKE', "%{$search}%");
        }

        $news = $query->paginate(12);

        $html = view('partials.news-grid', compact('news'))->render();

        $pagination = $news->appends(['search' => $search])
            ->links('pagination::bootstrap-5')
            ->render();

        return response()->json([
            'html'       => $html,
            'pagination' => $pagination,
            'success'    => true
        ]);
    }*/
    // app/Http/Controllers/NewsAjaxController.php
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