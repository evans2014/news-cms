@extends('layouts.admin')

@section('content')
    <div class="container mt-4">
        <h1>{{ $category->name }}</h1>
        @if($category->image)
            <img src="{{ asset('storage/' . $category->image) }}" class="img-fluid mb-3" style="max-height: 300px;">
        @else
            <p><em>Няма изображение</em></p>
        @endif
        <p><strong>Създадена на:</strong> {{ $category->created_at->format('d.m.Y H:i') }}</p>
        <a href="{{ route('admin.categories.index') }}" class="btn btn-secondary">Назад</a>
    </div>
@endsection