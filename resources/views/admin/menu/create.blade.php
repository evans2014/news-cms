{{-- resources/views/admin/menu/create.blade.php --}}
@extends('layouts.admin')

@section('content')
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12">
                <h1 class="h3 mb-4 text-gray-800">Добавяне на нов елемент в менюто</h1>

                <form action="{{ route('admin.menu.store') }}" method="POST">
                    @csrf

                    <div class="card shadow">
                        <div class="card-body">

                            <!-- Заглавие -->
                            <div class="mb-4">
                                <label class="form-label fw-bold">Заглавие <span class="text-danger">*</span></label>
                                <input type="text" name="title" class="form-control @error('title') is-invalid @enderror"
                                       value="{{ old('title') }}" required autofocus>
                                @error('title') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                            </div>

                            <!-- Тип на линка -->
                            <div class="mb-4">
                                <label class="form-label fw-bold">Тип линк <span class="text-danger">*</span></label>
                                <select name="type" id="menu-type" class="form-select @error('type') is-invalid @enderror" required>
                                    <option value="">-- Избери тип --</option>
                                    <option value="page">Статична страница</option>
                                    <option value="category">Категория</option>
                                    <option value="news">Пост</option>
                                    <option value="external">Външен линк</option>
                                    <option value="internal">Вътрешен път (/privacy)</option>
                                </select>
                                @error('type') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                            </div>

                            <!-- Динамично поле за избор на страница/категория/новина -->
                            <div id="target-field" class="mb-4" style="display: none;">
                                <label id="target-label" class="form-label fw-bold">Избери елемент</label>
                                <select name="target_id" id="target-select" class="form-select">
                                    <option value="">-- Избери --</option>
                                </select>
                                @error('target_id') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                            </div>

                            <!-- Поле за URL (internal / external) -->
                            <div id="url-field" class="mb-4" style="display: none;">
                                <label class="form-label fw-bold">Път / URL <span class="text-danger">*</span></label>
                                <input type="text" id="url-display" class="form-control mb-2"
                                       value="{{ old('url') }}" placeholder="/privacy-policy">
                                <input type="hidden" name="url" id="url-hidden" value="{{ old('url') }}">
                                <small id="url-hint" class="text-muted"></small>
                                @error('url') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                            </div>

                            <!-- Родителски елемент -->
                            <div class="mb-4">
                                <label class="form-label fw-bold">Родителски елемент (по желание)</label>
                                <select name="parent_id" class="form-select">
                                    <option value="">-- Няма (главно меню) --</option>
                                    @foreach($menuItems as $item)
                                        <option value="{{ $item->id }}">
                                            {{ str_repeat('— ', $item->depth) }}{{ $item->title }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="pt-4 text-end border-top">
                                <a href="{{ route('admin.menu.index') }}" class="btn btn-secondary me-2">Отказ</a>
                                <button type="submit" class="btn btn-success btn-lg">Добави в менюто</button>
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

        // Данни от контролера – задължително подадени от create() метода!
        const data = {
          pages: @json($pages->pluck('title', 'id')->toArray()),
          categories: @json($categories->pluck('name', 'id')->toArray()),
          news: @json($recentNews->mapWithKeys(fn($item) => [$item->id => Str::limit($item->title, 60)])->toArray())
        };

        function populateSelect(options) {
          targetSelect.innerHTML = '<option value="">-- Избери --</option>';
          Object.entries(options).forEach(([id, title]) => {
            const option = new Option(title, id);
            targetSelect.add(option);
          });
        }

        function updateFields() {
          const type = typeSelect.value;

          // Скриваме всичко
          targetField.style.display = 'none';
          urlField.style.display = 'none';

          if (['page', 'category', 'news'].includes(type)) {
            targetField.style.display = 'block';
            targetLabel.textContent =
              type === 'page' ? 'Избери страница' :
                type === 'category' ? 'Избери категория' : 'Избери новина';

            const items = type === 'page' ? data.pages :
              type === 'category' ? data.categories : data.news;
            populateSelect(items);
          }

          if (['external', 'internal'].includes(type)) {
            urlField.style.display = 'block';
            urlDisplay.value = '';
            urlHidden.value = '';
            urlDisplay.oninput = () => urlHidden.value = urlDisplay.value;

            if (type === 'internal') {
              urlDisplay.placeholder = '/privacy-policy';
              urlHint.innerHTML = 'Само път – напр. <code>/privacy</code>, <code>/contact</code>, <code>/about-us</code>';
            } else {
              urlDisplay.placeholder = 'https://example.com';
              urlHint.textContent = 'Задължително започва с https://';
            }
          }
        }

        typeSelect.addEventListener('change', updateFields);
      });
    </script>
@endsection