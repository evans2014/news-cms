@extends('layouts.admin')

@section('content')
    <div class="container mt-4">
        <div class="d-flex justify-content-between mb-3">
            <h1>Страници</h1>
            <a href="{{ route('admin.pages.create') }}" class="btn btn-primary">+ Нова страница</a>
        </div>

        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                <tr>
                    <th>Заглавие</th>
                    <th>Slug</th>
                    <th>Действия</th>
                </tr>
                </thead>
                <tbody>
                @forelse($pages as $page)
                    <tr>
                        <td>{{ $page->title }}</td>
                        <td><code>{{ $page->slug }}</code></td>
                        <td>
                            <a href="{{ route('admin.pages.show', $page) }}" class="btn btn-sm btn-info">Виж</a>
                            <a href="{{ route('admin.pages.edit', $page) }}" class="btn btn-sm btn-warning">Редактирай</a>
                            <form action="{{ route('admin.pages.destroy', $page) }}" method="POST" class="d-inline">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Изтриване?')">Изтрий</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="3" class="text-center">Няма страници.</td></tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection