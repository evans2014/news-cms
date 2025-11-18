@extends('layouts.admin')

@section('content')
    <div class="container mt-4">
        <div class="d-flex justify-content-between mb-3">
            <h1>Категории</h1>
            <a href="{{ route('admin.categories.create') }}" class="btn btn-primary">+ Нова категория</a>
        </div>

        <table class="table table-striped">
            <thead>
            <tr>
                <th>Име</th>
                <th>Изображение</th>
                <th>Действия</th>
            </tr>
            </thead>
            <tbody>
            @forelse($categories as $cat)
                <tr>
                    <td>{{ $cat->name }}</td>
                    <td>
                        @if($cat->image)
                            <img src="{{ asset('storage/' . $cat->image) }}" width="50">
                        @else
                            <em>няма</em>
                        @endif
                    </td>
                    <td> <a href="{{ route('admin.categories.show', $cat) }}" class="btn btn-sm btn-info">Виж</a>
                        <a href="{{ route('admin.categories.edit', $cat) }}" class="btn btn-sm btn-warning">Редактирай</a>
                        <form action="{{ route('admin.categories.destroy', $cat) }}" method="POST" class="d-inline">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Изтриване?')">Изтрий</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="3">Няма категории.</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
@endsection