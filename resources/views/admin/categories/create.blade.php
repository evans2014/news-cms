@extends('layouts.admin')

@section('content')
    <div class="container mt-4">
        <h1>Създай категория</h1>
        <form action="{{ route('admin.categories.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="mb-3">
                <label>Име</label>
                <input type="text" name="name" class="form-control" value="{{ old('name') }}">
            </div>
            <div class="mb-3">
                <label>Изображение (по избор)</label>
                <input type="file" name="image" class="form-control">
            </div>
            <button type="submit" class="btn btn-success">Създай</button>
        </form>
    </div>
@endsection