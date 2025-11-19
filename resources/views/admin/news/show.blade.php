@extends('layouts.admin')

@section('content')
    <div class="container mt-4">
        <h1>{{ $news->title }}</h1>
        <img src="{{ asset('storage/' . $news->image) }}" class="img-fluid mb-3" style="max-height: 400px;">

        @if($news->categories->count())
            @foreach($news->categories as $category)
                <a href="{{ route('category.show', $category->slug) }}" class="badge bg-primary text-white text-decoration-none me-1 px-3 py-2 rounded-pill">
                    {{ $category->name }}
                </a>{{ !$loop->last ? '' : '' }}
            @endforeach
        @else
            <span class="text-muted small">Без категория</span>
        @endif
        <div>{!! nl2br(e($news->description)) !!}</div>
        <a href="{{ route('admin.news.index') }}" class="btn btn-secondary">Назад</a>
    </div>
@endsection