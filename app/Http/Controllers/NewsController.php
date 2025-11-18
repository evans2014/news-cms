<?php

namespace App\Http\Controllers;

use App\Models\News;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class NewsController extends Controller
{
    public function show($id)
    {
        $news = News::with('category')->findOrFail($id);

        /*$similar = News::where('created_at', $news->created_at)->count();
        dd([
            'current_id' => $news->id,
            'created_at' => $news->created_at,
            'same_created_at_count' => $similar,
            'total' => News::count(),
        ]);*/
       /* $previous = News::where(function ($query) use ($news) {
            $query->where('created_at', '<', $news->created_at)
                ->orWhere(function ($q) use ($news) {
                    $q->where('created_at', $news->created_at)
                        ->where('id', '<', $news->id);
                });
        })
            ->orderBy('created_at', 'desc')
            ->orderBy('id', 'desc')
            ->first();

        // Следващ: по-късен по created_at ИЛИ същият created_at, но по-голям id
        $next = News::where(function ($query) use ($news) {
            $query->where('created_at', '>', $news->created_at)
                ->orWhere(function ($q) use ($news) {
                    $q->where('created_at', $news->created_at)
                        ->where('id', '>', $news->id);
                });
        })
            ->orderBy('created_at', 'asc')
            ->orderBy('id', 'asc')
            ->first();*/

        $title       = $news->title;
        $description = Str::limit(strip_tags($news->description), 160);
        $ogImage     = $news->image ? asset('storage/'.$news->image) : asset('images/og-default.jpg');
        $previous = News::where('id', '<', $news->id)->orderBy('id', 'desc')->select('id', 'title', 'image')->first();
        $next = News::where('id', '>', $news->id)->orderBy('id', 'asc')->select('id', 'title', 'image')->first();

        return view('news.show', compact('news', 'previous', 'next','title', 'description', 'ogImage'));
    }


}