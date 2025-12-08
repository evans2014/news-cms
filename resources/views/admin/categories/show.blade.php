@extends('layouts.admin')

@section('content')
    <div class="container-fluid">
        <h2>Преглед на категория: {{ $category->name }}</h2>

        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4">
                        <strong>Име:</strong><br>
                        {{ $category->name }}

                    </div>
                    <div class="col-md-4 p-2">
                        <strong>Снимка:</strong><br>
                        @if($category->image)
                            <img src="{{ $category->image }}" class="img-thumbnail" style="max-height:200px;">
                        @else
                            <em>няма снимка</em>
                        @endif
                    </div>
                </div>

                <a href="{{ route('admin.categories.index') }}" class="btn btn-secondary">Назад</a>
                <a href="{{ route('admin.categories.edit', $category) }}" class="btn btn-warning">Редактирай</a>
            </div>
        </div>
    </div>
@endsection