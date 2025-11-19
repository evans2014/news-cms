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


        $title       = $news->title;
        $description = Str::limit(strip_tags($news->description), 160);
        $ogImage     = $news->image ? asset('storage/'.$news->image) : asset('images/og-default.jpg');
        $previous = News::where('id', '<', $news->id)->orderBy('id', 'desc')->select('id', 'title', 'image')->first();
        $next = News::where('id', '>', $news->id)->orderBy('id', 'asc')->select('id', 'title', 'image')->first();

        return view('news.show', compact('news', 'previous', 'next','title', 'description', 'ogImage'));
    }


}