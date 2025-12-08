@extends('layouts.admin')
@if($page->sections)
    @foreach($page->sections as $section)
        {{ $section->title }}
    @endforeach
@endif
@foreach($page->sections ?? [] as $section)
    {{ $section->title }}
@endforeach


@section('content')
    <div class="container mt-4">
      <h1>{{ $page->title }}</h1>
        <div>{!! html_entity_decode(e($page->content)) !!}</div>
        <a href="{{ route('admin.pages.index') }}" class="btn btn-secondary">Назад</a>
    </div>
@endsection
