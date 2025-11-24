@extends('layouts.admin')

@section('content')
    <div class="container mt-4">
        <h1>Редактирай категория</h1>
        <form action="{{ route('admin.categories.update', $category) }}" method="POST" enctype="multipart/form-data">
            @csrf @method('PUT')
            <div class="mb-3">
                <label>Име</label>
                <input type="text" name="name" class="form-control" value="{{ $category->name }}">
            </div>
            <div class="mb-4">
                <label>Картинка</label>
                <div class="row">
                    <div class="col-md-3">
                        <img id="categoryImagePreview"
                             src="{{ old('image', $category->image ?? asset('images/no-image.jpg')) }}"
                             class="img-thumbnail" style="width:300px; height:auto; object-fit:cover;">
                    </div>
                    <div class="col-md-8">
                        <input type="hidden" name="image" id="categoryImageInput"
                               value="{{ old('image', $category->image ?? '') }}">
                        <button type="button"
                                class="btn btn-primary"
                                data-bs-toggle="modal"
                                data-bs-target="#mediaModal"
                                onclick="window.currentImageField = 'category'">
                            Избери снимка от библиотеката
                        </button>
                        @if(old('image', $category->image ?? ''))
                            <button type="button" class="btn btn-outline-danger btn-sm ms-2"
                                    onclick="document.getElementById('categoryImageInput').value='';
                                 document.getElementById('categoryImagePreview').src='{{ asset('images/no-image.jpg') }}'">
                                Премахни
                            </button>
                        @endif
                    </div>
                </div>
            </div>
            <button type="submit" class="btn btn-success">Обнови</button>
        </form>
    </div>
@endsection