@extends('layouts.app')

@section('content')
    <div class="container py-5">212
        <h1>{{ $page->title }}</h1>
        <div>{!! $page->content !!}</div>

    </div>
@endsection

