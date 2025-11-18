@extends('layouts.admin')

@section('content')
    <div class="container mt-4">
        <h1>Редактирай категория</h1>
        <form action="{{ route('admin.categories.update', $category) }}" method="POST" enctype="multipart/form-data">
            @csrf @method('PUT')
            <div class="mb-3">
                <label>Име</label>
                <input type="text" name="name" class="form-control" value="{{ $category->name }}">
            </div>
            <div class="mb-3">
                @if($category->image)
                    <img src="{{ asset('storage/' . $category->image) }}" width="100" class="mb-2"><br>
                @endif
                <label>Ново изображение</label>
                <input type="file" name="image" class="form-control">
            </div>
            <button type="submit" class="btn btn-success">Обнови</button>
        </form>
    </div>
@endsection