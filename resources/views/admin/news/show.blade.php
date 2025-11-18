@extends('layouts.admin')

@section('content')
    <div class="container mt-4">
        <h1>{{ $news->title }}</h1>
        <img src="{{ asset('storage/' . $news->image) }}" class="img-fluid mb-3" style="max-height: 400px;">
        <p><strong>Категория:</strong> {{ $news->category->name }}</p>
        <div>{!! nl2br(e($news->description)) !!}</div>
        <a href="{{ route('admin.news.index') }}" class="btn btn-secondary">Назад</a>
    </div>
@endsection