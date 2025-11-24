@extends('layouts.admin')

@section('content')
    <div class="container-fluid">
        <h1 class="h3 mb-4 text-gray-800">Редактиране на пост</h1>

        <form action="{{ route('admin.news.update', $news) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="card shadow mb-4">
                <div class="card-body">
                    <div class="row">
                        <div class="col-5">
                            <div class="mb-3">
                                <label class="form-label">Заглавие <span class="text-danger">*</span></label>
                                <input type="text" name="title" class="form-control @error('title') is-invalid @enderror"
                                       value="{{ old('title', $news->title) }}" required>
                                @error('title') <div class="text-danger small">{{ $message }}</div> @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Описание <span class="text-danger">*</span></label>
                                <textarea name="description" rows="10" class="form-control @error('description') is-invalid @enderror" required>{{ old('description', $news->description) }}</textarea>
                                @error('description') <div class="text-danger small">{{ $message }}</div> @enderror
                            </div>

                        </div>
                          <div class="col-3 mb-4">
                            <label class="form-label fw-bold">Картинка на новината</label>

                            <div class="row g-4">
                                <div class="row g-4">
                                    <!-- Скрито поле за URL от библиотеката -->
                                    <input type="hidden" name="image" id="newsImageInput"
                                           value="{{ old('image', $news->image ?? '') }}">

                                    <!-- Преглед на снимката -->
                                    <img id="newsImagePreview"
                                         src="{{ old('image', $news->image ?? asset('images/no-image.jpg')) }}"
                                         class="img-thumbnail" style="width:100%; max-height:300px; object-fit:cover;">

                                    <!-- Бутон за библиотеката -->
                                    <button type="button" class="btn btn-primary mt-3"
                                            data-bs-toggle="modal" data-bs-target="#mediaModal"
                                            onclick="window.currentImageField = 'news'">
                                        Избери от библиотеката
                                    </button>

                                    <!-- Премахни снимката -->
                                    <button type="button" class="btn btn-danger mt-2"
                                            onclick="document.getElementById('newsImageInput').value='';
                document.getElementById('newsImagePreview').src='{{ asset('images/no-image.jpg') }}'">
                                        Премахни
                                    </button>
                                </div>
                            </div>
                        </div>

                        <div class="col-4">
                            <div class="mb-4">
                                <label class="form-label fw-bold">Категории <span class="text-danger">*</span></label>
                                <select name="category_id" class="form-select" required>
                                    @foreach(\App\Models\Category::all() as $cat)
                                        <option value="{{ $cat->id }}"
                                                {{ old('category_id', $news->category_id ?? '') == $cat->id ? 'selected' : '' }}>
                                            {{ $cat->name }}
                                        </option>
                                    @endforeach
                                </select>

                                <div class="form-text">
                                    Задръж <kbd>Ctrl</kbd> (или <kbd>Cmd</kbd> на Mac) и кликни за избор на няколко категории.
                                </div>

                                @error('categories')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="text-end">
                        <a href="{{ route('admin.news.index') }}" class="btn btn-secondary">Отказ</a>
                        <button type="submit" class="btn btn-primary">Запази промените</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
    <script>
      function clearNewsImage() {
        document.getElementById('newsImageInput').value = '';
        document.getElementById('newsImagePreview').src = '{{ asset('images/no-image.jpg') }}';
      }
    </script>
@endsection