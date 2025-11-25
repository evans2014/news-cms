@extends('layouts.admin')

@section('content')
    <div class="container mt-4">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h1>Постове</h1>
        </div>
        <div class="row mb-4">
            <div class="col-md-6">
                <form method="GET" action="{{ route('admin.news.index') }}">
                    <div class="input-group input-group-lg">
                        <input type="text" name="search" class="form-control"
                               placeholder="Търси по заглавие..."
                               value="{{ request('search') }}">
                        <button class="btn btn-primary" type="submit">
                            Търсене
                        </button>
                        @if(request('search'))
                            <a href="{{ route('admin.news.index') }}" class="btn btn-outline-secondary">
                                Всички
                            </a>
                        @endif
                    </div>
                </form>
            </div>
            <div class="col-md-6 text-end">
                <a href="{{ route('admin.news.create') }}" class="btn btn-success btn-lg">
                    + Нова новина
                </a>
            </div>
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
                        <td><img src="{{ $item->image }}" width="50" height="50" style="object-fit: cover;"></td>
                        <td>{{ Str::limit($item->title, 50) }}</td>

                        <td>
                            @if($item->category)
                                <span class="badge bg-primary fs-6">{{ $item->category->name }}</span>
                            @else
                                <span class="text-muted">Без категория</span>
                            @endif
                        </td>

                        <td>
                            <a href="{{ route('admin.news.show', $item) }}" class="btn btn-sm btn-info">Виж</a>
                            <a href="{{ route('admin.news.edit', $item) }}" class="btn btn-sm btn-warning">Редактирай</a>
                            <form action="{{ route('admin.news.destroy', $item) }}" method="POST" class="d-inline">
                                @csrf @method('DELETE')

                                <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#deleteModal"
                                        onclick="setDeleteForm('{{ route('admin.news.destroy', $item) }}')">
                                    <i class="bi bi-trash"></i> Изтрий
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="4" class="text-center">Няма постове.</td></tr>
                @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-5 d-flex justify-content-center">
            {{ $news->links() }}
        </div>
    </div>
    <!-- Delete Confirmation Modal -->
    <div class="modal fade" id="deleteModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title">
                        <i class="bi bi-exclamation-triangle"></i> Потвърждение за изтриване
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body text-center py-4">
                    <p class="lead">Сигурен ли си, че искаш да изтриеш този запис?</p>
                    <p class="text-muted">Това действие е необратимо!</p>
                </div>
                <div class="modal-footer justify-content-center">
                    <button type="button" class="btn btn-secondary px-4" data-bs-dismiss="modal">
                        Отказ
                    </button>
                    <form id="deleteForm" method="POST" style="display: inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger px-5">
                            Да, изтрий завинаги
                        </button>

                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
      function setDeleteForm(action) {
        document.getElementById('deleteForm').action = action;
      }
    </script>
@endsection