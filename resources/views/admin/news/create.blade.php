@extends('layouts.admin')

@section('content')
    <div class="container mt-4">
        <h1>Създай пост</h1>

        <form action="{{ route('admin.news.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="mb-3">
                <label class="form-label">Заглавие</label>
                <input type="text" name="title" class="form-control @error('title') is-invalid @enderror" value="{{ old('title') }}">
                @error('title') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="mb-3">
                <label class="form-label">Описание</label>
                <textarea name="description" rows="5" class="form-control @error('description') is-invalid @enderror">{{ old('description') }}</textarea>
                @error('description') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="mb-4">
                <label class="form-label fw-bold">Картинка на новината</label>

                <div class="row g-4">
                    <input type="hidden" name="image" id="newsImageInput"
                           value="{{ old('image', $news->image ?? '') }}">
                    <img id="newsImagePreview"
                         src="{{ old('image', $news->image ?? asset('images/no-image.jpg')) }}"
                         class="img-thumbnail" style="width:100%; max-height:300px; object-fit:cover;">
                    <button type="button" class="btn btn-primary mt-3"
                            data-bs-toggle="modal" data-bs-target="#mediaModal"
                            onclick="window.currentImageField = 'news'">
                        Избери от библиотеката
                    </button>
                    <button type="button" class="btn btn-danger mt-2"
                            onclick="document.getElementById('newsImageInput').value='';
                document.getElementById('newsImagePreview').src='{{ asset('images/no-image.jpg') }}'">
                        Премахни
                    </button>
                </div>
            </div>

            <script>
              function clearNewsImage() {
                document.getElementById('newsImageInput').value = '';
                document.getElementById('newsImagePreview').src = '{{ asset('images/no-image.jpg') }}';
              }
            </script>

            <div class="mb-3">
                <select name="category_id" class="form-select" required>
                    @foreach(\App\Models\Category::all() as $cat)
                        <option value="{{ $cat->id }}"
                                {{ old('category_id', $news->category_id ?? '') == $cat->id ? 'selected' : '' }}>
                            {{ $cat->name }}
                        </option>
                    @endforeach
                </select>
                @error('category_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <button type="submit" class="btn btn-success">Създай</button>
            <a href="{{ route('admin.news.index') }}" class="btn btn-secondary">Назад</a>
        </form>
    </div>
@endsection