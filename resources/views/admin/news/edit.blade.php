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
                        <div class="col-3">
                            <div class="mb-3">
                                <label class="form-label">Снимка</label>
                                @if($news->image)
                                    <div class="mb-2">
                                        <img src="{{ asset('storage/' . $news->image) }}" width="300" class="img-thumbnail">
                                    </div>
                                @endif
                                <input type="file" name="image" class="form-control @error('image') is-invalid @enderror">
                                @error('image') <div class="text-danger small">{{ $message }}</div> @enderror
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="mb-4">
                                <label class="form-label fw-bold">Категории <span class="text-danger">*</span></label>

                                <select name="categories[]"
                                        class="form-select @error('categories') is-invalid @enderror"
                                        multiple
                                        size="8"
                                        required>
                                    @foreach(\App\Models\Category::orderBy('name')->get() as $category)
                                        <option value="{{ $category->id }}"
                                                {{ isset($news) && $news->categories->contains($category->id) ? 'selected' : '' }}>
                                            {{ $category->name }}
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
@endsection