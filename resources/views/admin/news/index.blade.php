@extends('layouts.admin')

@section('content')
    <div class="container mt-4">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h1>Новини</h1>
            <a href="{{ route('admin.news.create') }}" class="btn btn-primary">+ Нова новина</a>
        </div>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                <tr>
                    <th>Изображение</th>
                    <th>Заглавие</th>
                    <th>Категория</th>
                    <th>Действия</th>
                </tr>
                </thead>
                <tbody>
                @forelse($news as $item)
                    <tr>
                        <td><img src="{{ asset('storage/' . $item->image) }}" width="50" height="50" style="object-fit: cover;"></td>
                        <td>{{ Str::limit($item->title, 50) }}</td>
                        <td>@forelse($item->categories as $cat)
                                <span class="badge bg-primary me-1">{{ $cat->name }}</span>
                            @empty
                                <span class="text-muted small">Без категория</span>
                            @endforelse</td>
                        <td>
                            <a href="{{ route('admin.news.show', $item) }}" class="btn btn-sm btn-info">Виж</a>
                            <a href="{{ route('admin.news.edit', $item) }}" class="btn btn-sm btn-warning">Редактирай</a>
                            <form action="{{ route('admin.news.destroy', $item) }}" method="POST" class="d-inline">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Сигурни ли сте?')">Изтрий</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="4" class="text-center">Няма новини.</td></tr>
                @endforelse
                </tbody>
            </table>
        </div>

        {{ $news->links() }}
    </div>
@endsection