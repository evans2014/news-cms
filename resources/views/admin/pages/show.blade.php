@extends('layouts.admin')

@section('content')
    <div class="container mt-4">
        <h1>{{ $page->title }}</h1>
        <div>{!! html_entity_decode(e($page->content)) !!}</div>
        <a href="{{ route('admin.pages.index') }}" class="btn btn-secondary">Назад</a>
    </div>
@endsection