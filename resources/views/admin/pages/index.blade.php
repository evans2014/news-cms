@extends('layouts.admin')

@section('content')
    <div class="container mt-4">
        <div class="row mb-4">
        <div class="col-md-6 mb-3">
            <h1>Страници</h1>

        </div>
        <div class="col-md-6 text-end">
            <a href="{{ route('admin.pages.trash') }}" class="btn btn-warning">🗑 Trash</a>
            <a href="{{ route('admin.pages.create') }}" class="btn btn-primary">+ Нова страница</a>
        </div>
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
                                <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#deleteModal"
                                        onclick="setDeleteForm('{{ route('admin.pages.destroy', $page) }}')">
                                    <i class="bi bi-trash"></i> Изтрий
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="3" class="text-center">Няма страници.</td></tr>
                @endforelse
                </tbody>
            </table>
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
                    </div>
                    <div class="modal-footer justify-content-center">
                        <button type="button" class="btn btn-secondary px-4" data-bs-dismiss="modal">
                            Отказ
                        </button>
                        <form id="deleteForm" method="POST" style="display: inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger px-5">
                                Да, изтрий
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
    </div>
@endsection