@extends('layouts.admin')
@section('content')
    <div class="container-fluid">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4">
                        <div>Заглавие: {{ $news->title }}</div>
                        <div>Категория:
                            @if($news->categories->count())
                                @foreach($news->categories as $category)
                                    <a href="{{ route('category.show', $category->slug) }}" class="badge bg-primary text-white text-decoration-none me-1 px-3 py-2 rounded-pill">
                                        {{ $category->name }}
                                    </a>{{ !$loop->last ? '' : '' }}
                                @endforeach
                            @else
                                <span class="text-muted small">Без категория</span>
                            @endif
                        </div>
                        <div>Описание: {!! nl2br(e($news->description)) !!}</div>
                    </div>
                    <div class="col-md-4">
                        <div>Снимка:</div><br>
                        @if($news->image)
                            <img src="{{ asset('storage/' . $news->image) }}" class="img-fluid mb-3" style="max-height: 400px;">
                        @else
                            <em>няма снимка</em>
                        @endif
                    </div>
                </div>
                <hr>
                <a href="{{ route('admin.news.index') }}" class="btn btn-secondary">Назад</a>
                <a href="{{ route('admin.news.edit', $news) }}" class="btn btn-warning">Редактирай</a>
            </div>
        </div>
    </div>
@endsection

@extends('layouts.admin')