{{-- resources/views/admin/menu/edit.blade.php --}}
@extends('layouts.admin')

@section('content')
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12">
                <h1 class="h3 mb-4 text-gray-800">Редактиране на меню елемент</h1>

                @php
                    $item = $menuItem ?? $menu ?? null;
                    if (!$item) {
                        abort(404, 'Елементът не е намерен');
                    }
                @endphp

                <form action="{{ route('admin.menu.update', $item) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="card shadow mb-4">
                        <div class="card-body">

                            <div class="mb-4">
                                <label class="form-label fw-bold">Заглавие <span class="text-danger">*</span></label>
                                <input type="text" name="title" class="form-control @error('title') is-invalid @enderror"
                                       value="{{ old('title', $item->title) }}" required>
                                @error('title') <div class="text-danger small">{{ $message }}</div> @enderror
                            </div>

                            <div class="mb-4">
                                <label class="form-label fw-bold">Тип линк <span class="text-danger">*</span></label>
                                <select name="type" id="menu-type" class="form-select" required>
                                    <option value="">-- Избери тип --</option>
                                    <option value="page" {{ old('type', $item->type) == 'page' ? 'selected' : '' }}>Статична страница</option>
                                    <option value="category" {{ old('type', $item->type) == 'category' ? 'selected' : '' }}>Категория</option>
                                    <option value="news" {{ old('type', $item->type) == 'news' ? 'selected' : '' }}>Пост</option>
                                    <option value="external" {{ old('type', $item->type) == 'external' ? 'selected' : '' }}>Външен линк</option>
                                    <option value="internal" {{ old('type', $item->type) == 'internal' ? 'selected' : '' }}>Вътрешен път (/privacy)</option>
                                </select>
                            </div>
                            <div id="target-field" class="mb-4" style="display: none;">
                                <label id="target-label" class="form-label fw-bold">Избери елемент</label>
                                <select name="target_id" id="target-select" class="form-select">
                                    <option value="">-- Зарежда се... --</option>
                                </select>
                            </div>
                            <div id="url-field" class="mb-4" style="display: none;">
                                <label class="form-label fw-bold">Път / URL <span class="text-danger">*</span></label>
                                <input type="text" id="url-display" class="form-control mb-2"
                                       value="{{ old('url', $item->url) }}" placeholder="/privacy-policy">
                                <input type="hidden" name="url" id="url-hidden" value="{{ old('url', $item->url) }}">
                                <small id="url-hint" class="text-muted"></small>
                            </div>
                            <div class="mb-4">
                                <label class="form-label fw-bold">Родителски елемент</label>
                                <select name="parent_id" class="form-select">
                                    <option value="">-- Няма (главно меню) --</option>
                                    @foreach($menuItems ?? [] as $menu)
                                        @if($menu->id != $item->id)
                                            <option value="{{ $menu->id }}"
                                                    {{ old('parent_id', $item->parent_id) == $menu->id ? 'selected' : '' }}>
                                                {{ str_repeat('— ', $menu->depth) }}{{ $menu->title }}
                                            </option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>

                            <div class="pt-3 text-end">
                                <a href="{{ route('admin.menu.index') }}" class="btn btn-secondary">Назад</a>
                                <button type="submit" class="btn btn-primary">Запази промените</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
      document.addEventListener('DOMContentLoaded', function () {
        const typeSelect   = document.getElementById('menu-type');
        const targetField  = document.getElementById('target-field');
        const targetSelect = document.getElementById('target-select');
        const targetLabel  = document.getElementById('target-label');
        const urlField     = document.getElementById('url-field');
        const urlDisplay   = document.getElementById('url-display');
        const urlHidden    = document.getElementById('url-hidden');
        const urlHint      = document.getElementById('url-hint');

        const data = {
          pages: @json($pages->pluck('title', 'id')->toArray()),
          categories: @json($categories->pluck('name', 'id')->toArray()),
          news: @json($recentNews->mapWithKeys(fn($n) => [$n->id => Str::limit($n->title, 50)])->toArray())
        };

        const currentTargetId = "{{ old('target_id', $item->target_id ?? '') }}";
        const currentUrl = "{{ old('url', $item->url ?? '') }}";

        function populateSelect(options, selected = '') {
          targetSelect.innerHTML = '<option value="">-- Избери --</option>';
          Object.entries(options).forEach(([id, title]) => {
            const opt = new Option(title, id, false, id == selected);
            targetSelect.add(opt);
          });
        }

        function updateFields() {
          const type = typeSelect.value;
          targetField.style.display = 'none';
          urlField.style.display = 'none';

          if (['page', 'category', 'news'].includes(type)) {
            targetField.style.display = 'block';
            targetLabel.textContent = type === 'page' ? 'Избери страница' :
              type === 'category' ? 'Избери категория' : 'Избери новина';
            const items = type === 'page' ? data.pages : type === 'category' ? data.categories : data.news;
            populateSelect(items, currentTargetId);
          }

          if (['external', 'internal'].includes(type)) {
            urlField.style.display = 'block';
            urlDisplay.value = currentUrl;
            urlHidden.value = currentUrl;
            urlDisplay.oninput = () => urlHidden.value = urlDisplay.value;

            if (type === 'internal') {
              urlDisplay.placeholder = '/privacy-policy';
              urlHint.innerHTML = 'Само път – напр. <code>/privacy</code>';
            } else {
              urlDisplay.placeholder = 'https://example.com';
              urlHint.textContent = 'Задължително с https://';
            }
          }
        }

        typeSelect.addEventListener('change', updateFields);
        updateFields();
      });
    </script>
@endsection