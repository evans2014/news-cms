@extends('layouts.app')
@section('title', $news->title . ' - Collection CMS')
@section('content')
    <div class="container py-5">
        <div class="row">
            <div class="col-lg-8 mx-auto">
                <article class="card border-0 shadow-sm">
                    @if($news->image)
                        <img src="{{ asset('storage/' . $news->image) }}" class="card-img-top" alt="{{ $news->title }}" style="max-height: 400px; object-fit: cover;">
                    @endif
                    <div class="card-body p-4">
                        <div class="d-flex flex-wrap gap-2">

                            @if($news->categories->count())
                                @foreach($news->categories as $category)
                                    <a href="{{ route('category.show', $category->slug) }}" class="badge bg-primary text-white text-decoration-none me-1 px-3 py-2 rounded-pill">
                                        {{ $category->name }}
                                    </a>{{ !$loop->last ? '' : '' }}
                                @endforeach
                            @else
                                <span class="text-muted small">Без категория</span>
                            @endif

                        </div>
                        <h1 class="card-title display-5 mb-4">{{ $news->title }}</h1>
                        <div class="lead">{!! nl2br(e($news->description)) !!}</div>
                    </div>
                    <div class="card-footer bg-white border-0 p-4">
                        <a href="{{ url()->previous() }}" class="btn btn-outline-secondary">
                            ← Назад
                        </a>
                    </div>
                </article>
            </div>
        </div>

        <div class="post-navigation mt-8">
            @if($previous)
                <a href="{{ route('news.show', $previous->id) }}" class="btn btn-outline-secondary prev">
                    ← Предишен: {{ $previous->title }}
                    <img
                            src="{{ asset('storage/' . $previous->image) }}"
                            alt="{{ $previous->title }}"
                            class="rounded"
                            style="width: 80px; height: 60px; object-fit: cover;"
                    >
                </a>
            @endif

            @if($next)
                <a href="{{ route('news.show', $next->id) }}" class="btn btn-outline-secondary next">
                    Следващ: {{ $next->title }} →
                    <img
                            src="{{ asset('storage/' . $next->image) }}"
                            alt="{{ $next->title }}"
                            class="rounded"
                            style="width: 80px; height: 60px; object-fit: cover;"
                    >
                </a>
            @endif
        </div>
    </div>
@endsection