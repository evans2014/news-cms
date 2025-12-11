@extends('layouts.app')
@section('title', $news->title . ' - Collection CMS')

@section('content')
    <div class="container py-5">
        <div class="row">
            <div class="card bg-white border-0">
                @include('partials.breadcrumbs')
            </div>
            <div class="col-lg-12 mx-auto p-0">

                <div class="card border-0 shadow-sm">
                    <div class="row ">

                        <div class="col-lg-2 mx-auto middle-button">
                            @if($previous)
                                <a href="{{ route('news.show', $previous->id) }}" class="btn btn-outline-secondary prev">
                                    ← Предишен
                                    <img
                                            src="{{ $previous->image }}"
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
                                <div style="display: flex;justify-content: center; align-items: center;"><img src="{{ $news->image}}" class="card-img-top" alt="{{ $news->title }}" style="max-width: 600px; text-align: center"></div>
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
                                            src="{{ $next->image }}"
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