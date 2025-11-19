@extends('layouts.app')
@section('title', $news->title . ' - Collection CMS')
@section('content')
    <div class="container py-5">
        <div class="row">

            <div class="col-lg-8 mx-auto">
                <div class="card card border-0 shadow-sm">
                    <div class="row g-0">
                        <div class="card-footer bg-white border-0 p-4">
                            <a href="{{ url()->previous() }}" class="btn btn-outline-secondary">
                                ← Назад
                            </a>
                        </div>
                        <div class="col-lg-2 mx-auto middle-button p-3">
                            @if($previous)
                                <a href="{{ route('news.show', $previous->id) }}" class="btn btn-outline-secondary prev">
                                    ← Предишен
                                    <img
                                            src="{{ asset('storage/' . $previous->image) }}"
                                            alt="{{ $previous->title }}"
                                            class="rounded"
                                            style="width: 100px; height: auto; object-fit: cover;"
                                    >
                                </a>
                            @endif
                        </div>
                        <div class="col-md-8 text-center">
                            <h1 class="card-title display-5 text-center">{{ $news->title }}</h1>

                            @if($news->image)
                                <div style="display: flex;justify-content: center; align-items: center;"><img src="{{ asset('storage/' . $news->image) }}" class="card-img-top" alt="{{ $news->title }}" style="max-width: 600px; text-align: center"></div>
                            @endif
                            @if($news->categories->count())
                                @foreach($news->categories as $category)
                                    <a href="{{ route('category.show', $category->slug) }}" class="badge text-center bg-primary text-white ">
                                        {{ $category->name }}
                                    </a>{{ !$loop->last ? '' : '' }}
                                @endforeach
                            @else
                                <span class="text-muted small text-center">Без категория</span>
                            @endif
                            <div class="lead text-center p-5">{!! nl2br(e($news->description)) !!}</div>

                        </div>
                        <div class="col-lg-2 mx-auto middle-button p-3">
                            @if($next)
                                <a href="{{ route('news.show', $next->id) }}" class="btn btn-outline-secondary next ">
                                    Следващ →
                                    <img
                                            src="{{ asset('storage/' . $next->image) }}"
                                            alt="{{ $next->title }}"
                                            class="rounded"
                                            style="width: 100px; height: auto; object-fit: cover;"
                                    >
                                </a>
                            @endif
                        </div>

                    </div>
                </div>

        </div>


        <div class="post-navigation mt-8">



        </div>
    </div>
@endsection