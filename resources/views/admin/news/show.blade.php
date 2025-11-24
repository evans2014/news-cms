@extends('layouts.admin')
@section('content')
    <div class="container-fluid">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4">
                        <div>Заглавие: {{ $news->title }}</div>
                        <div>Категория:
                                @if($news->category)
                                    <span class="badge bg-primary fs-6">{{ $news->category->name }}</span>
                                @else
                                    <span class="text-muted">Без категория</span>
                                @endif
                        </div>
                        <div>Описание: {!! nl2br(e($news->description)) !!}</div>
                    </div>
                    <div class="col-md-4">
                        <div>Снимка:</div><br>
                        @if($news->image)
                            <img src="{{ $news->image }}" class="img-fluid mb-3" style="max-height: 400px;">
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