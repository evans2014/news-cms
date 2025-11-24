@extends('layouts.app')

@section('title', $category->name)

@section('content')
<div class="container py-5">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Начало</a></li>
            <li class="breadcrumb-item"><a href="{{ route('categories.index') }}">Категории</a></li>
            <li class="breadcrumb-item active">{{ $category->name }}</li>
        </ol>
    </nav>

    <h1 class="display-5 mb-4">{{ $category->name }}</h1>
    @if($category->image)
        <img src="{{ $category->image }}" class="cat-img-top" style="height:auto;object-fit:cover;" alt="{{ $category->name }}">
    @endif
    <p class="text-muted mb-4">{{ $category->news_count }}</p>

    <div class="row g-4">
        @forelse($news as $item)
        <div class="col-lg-2 col-md-3 col-sm-4 col-xs-6 ">
            <div class="card h-100 shadow-sm">
                @if($item->image)
                    <img src="{{ asset('storage/' . $item->image) }}" class="card-img-top" style="height:200px; object-fit:cover;">
                @endif
                <div class="card-body d-flex flex-column">
                    <h5 class="card-title">{{ Str::limit($item->title, 50) }}</h5>
                    <!-- <p class="text-muted small">{{ $item->created_at->format('d.m.Y') }}</p> -->
                    <a href="{{ route('news.show', $item->id) }}" class="btn btn-outline-primary mt-auto">
                        Прочети
                    </a>
                </div>
            </div>
        </div>
        @empty
        <div class="col-12">
            <p class="text-muted text-center">Няма постове в тази категория.</p>
        </div>
        @endforelse
    </div>

    <div class="mt-5">
        {{ $news->links() }}
    </div>
</div>
@endsection