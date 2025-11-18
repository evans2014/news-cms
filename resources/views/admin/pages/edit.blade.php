@extends('layouts.admin')

@section('title', 'Редактирай меню елемент')

@section('content')
    <div class="container mt-5">
        <div class="row">
            <div class="col-lg-8 mx-auto">
                <div class="card shadow">
                    <div class="card-header bg-primary text-white">
                        <h4 class="mb-0">Редактирай елемент: {{ $menuItem->title }}</h4>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('admin.menu.update', $menuItem) }}" method="POST">

                            @csrf
                            @method('PUT')

                            <div class="mb-3">
                                <label class="form-label">Заглавие</label>
                                <input type="text" name="title" class="form-control" value="{{ old('title', $menuItem->title) }}" required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Тип</label>
                                <select name="type" class="form-select" id="type-select" required>
                                    <option value="external" {{ old('type', $menuItem->type) === 'external' ? 'selected' : '' }}>Външен линк</option>
                                    <option value="page" {{ old('type', $menuItem->type) === 'page' ? 'selected' : '' }}>Страница</option>
                                    <option value="news" {{ old('type', $menuItem->type) === 'news' ? 'selected' : '' }}>Новина</option>
                                    <option value="category" {{ old('type', $menuItem->type) === 'category' ? 'selected' : '' }}>Категория</option>
                                </select>
                            </div>

                            <!-- Външен URL -->
                            <div class="mb-3" id="external-url" style="display: {{ old('type', $menuItem->type) === 'external' ? 'block' : 'none' }}">
                                <label class="form-label">URL</label>
                                <input type="url" name="url" class="form-control" value="{{ old('url', $menuItem->url) }}" placeholder="https://example.com">
                            </div>

                            <!-- Страница -->
                            <div class="mb-3" id="page-target" style="display: {{ old('type', $menuItem->type) === 'page' ? 'block' : 'none' }}">
                                <label class="form-label">Избери страница</label>
                                <select name="target_id" class="form-select">
                                    <option value="">-- Избери --</option>
                                    @foreach($pages as $page)
                                        <option value="{{ $page->id }}" {{ old('target_id', $menuItem->target_id) == $page->id ? 'selected' : '' }}>
                                            {{ $page->title }} ({{ $page->slug }})
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Новина -->
                            <div class="mb-3" id="news-target" style="display: {{ old('type', $menuItem->type) === 'news' ? 'block' : 'none' }}">
                                <label class="form-label">Избери новина</label>
                                <select name="target_id" class="form-select">
                                    <option value="">-- Избери --</option>
                                    @foreach($news as $item)
                                        <option value="{{ $item->id }}" {{ old('target_id', $menuItem->target_id) == $item->id ? 'selected' : '' }}>
                                            {{ Str::limit($item->title, 50) }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Категория -->
                            <div class="mb-3" id="category-target" style="display: {{ old('type', $menuItem->type) === 'category' ? 'block' : 'none' }}">
                                <label class="form-label">Избери категория</label>
                                <select name="target_id" class="form-select">
                                    <option value="">-- Избери --</option>
                                    @foreach($categories as $cat)
                                        <option value="{{ $cat->id }}" {{ old('target_id', $menuItem->target_id) == $cat->id ? 'selected' : '' }}>
                                            {{ $cat->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Родител (подменю) -->
                            <div class="mb-3">
                                <label class="form-label">Подменю на</label>
                                <select name="parent_id" class="form-select">
                                    <option value="">-- Няма (главно меню) --</option>
                                    @foreach($menuItems as $parent)
                                        <option value="{{ $parent->id }}" {{ old('parent_id', $menuItem->parent_id) == $parent->id ? 'selected' : '' }}>
                                            {{ str_repeat('— ', $parent->depth) }}{{ $parent->title }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="d-flex gap-2">
                                <button type="submit" class="btn btn-success">Запази</button>
                                <a href="{{ route('admin.menu.index') }}" class="btn btn-secondary">Отказ</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
      document.getElementById('type-select')?.addEventListener('change', function() {
        const type = this.value;
        document.getElementById('external-url').style.display = type === 'external' ? 'block' : 'none';
        document.getElementById('page-target').style.display = type === 'page' ? 'block' : 'none';
        document.getElementById('news-target').style.display = type === 'news' ? 'block' : 'none';
        document.getElementById('category-target').style.display = type === 'category' ? 'block' : 'none';
      });
    </script>
@endsection