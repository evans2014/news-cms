{{-- resources/views/admin/dashboard.blade.php --}}
@extends('layouts.admin')

@section('title', 'Админ Панел')

@section('content')
    <div class="row g-4">
        <div class="col-md-6 col-lg-4">
            <div class="card border-start border-primary border-4 shadow-sm">
                <div class="card-body d-flex align-items-center">
                    <div class="flex-shrink-0">
                        <i class="fas fa-folder fa-3x text-primary"></i>
                    </div>
                    <div class="flex-grow-1 ms-4">
                        <h5 class="mb-1 text-muted">Категории</h5>
                        <h2 class="mb-0">{{ \App\Models\Category::count() }}</h2>
                        <small class="text-success">
                            <a href="{{ route('admin.categories.index') }}" class="text-decoration-none">
                                Към категориите →
                            </a>
                        </small>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6 col-lg-4">
            <div class="card border-start border-success border-4 shadow-sm">
                <div class="card-body d-flex align-items-center">
                    <div class="flex-shrink-0">
                        <i class="fas fa-newspaper fa-3x text-success"></i>
                    </div>
                    <div class="flex-grow-1 ms-4">
                        <h5 class="mb-1 text-muted">Новини</h5>
                        <h2 class="mb-0">{{ \App\Models\News::count() }}</h2>
                        <small class="text-success">
                            <a href="{{ route('admin.news.index') }}" class="text-decoration-none">
                                Към новините →
                            </a>
                        </small>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6 col-lg-4">
            <div class="card border-start border-warning border-4 shadow-sm">
                <div class="card-body d-flex align-items-center">
                    <div class="flex-shrink-0">
                        <i class="fas fa-file-alt fa-3x text-warning"></i>
                    </div>
                    <div class="flex-grow-1 ms-4">
                        <h5 class="mb-1 text-muted">Страници</h5>
                        <h2 class="mb-0">{{ \App\Models\Page::count() }}</h2>
                        <small class="text-success">
                            <a href="{{ route('admin.pages.index') }}" class="text-decoration-none">
                                Към страниците →
                            </a>
                        </small>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="mt-5">
        <h4 class="mb-4">Последни новини</h4>
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                <tr>
                    <th>Заглавие</th>
                    <th>Категории</th>
                    <th>Дата</th>
                    <th>Действия</th>
                </tr>
                </thead>
                <tbody>
                @forelse(\App\Models\News::latest()->take(5)->get() as $newsItem)
                    <tr>
                        <td>{{ Str::limit($newsItem->title, 50) }}</td>
                        <td>
                            @foreach($newsItem->categories as $cat)
                                <span class="badge bg-secondary me-1">{{ $cat->name }}</span>
                            @endforeach
                        </td>
                        <td>{{ $newsItem->created_at->format('d.m.Y') }}</td>
                        <td>
                            <a href="{{ route('admin.news.edit', $newsItem) }}" class="btn btn-sm btn-warning">Редактирай</a>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="4" class="text-center text-muted">Няма новини</td></tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection