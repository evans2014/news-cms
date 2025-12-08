@extends('layouts.app')

@section('content')
    <div class="container mt-4">
        <h1>Редактирай: {{ $page->title }}</h1>
        <form action="{{ route('admin.pages.update', $page) }}" method="POST">
            @csrf @method('PUT')
            <div class="mb-3">
                <label>Заглавие</label>
                <input type="text" name="title" class="form-control" value="{{ old('title', $page->title) }}" required>
            </div>
            <div class="mb-3">
                <label>Slug</label>
                <input type="text" name="slug" class="form-control" value="{{ old('slug', $page->slug) }}" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Съдържание</label>
                <textarea
                        name="content"
                        id="editor"
                        class="form-control d-none"
                >{{ old('content', $page->content ?? '') }}</textarea>

            </div>
            <button type="submit" class="btn btn-success">Обнови</button>
            <a href="{{ route('admin.pages.index') }}" class="btn btn-secondary">Назад</a>
        </form>
    </div>

    <script>
      tinymce.init({
        selector: '#editor',
        height: 400,
        menubar: true,
        relative_urls: false,
        remove_script_host: false,
        plugins: 'image link media code lists',
        toolbar: 'undo redo | bold italic | alignleft aligncenter alignright | bullist numlist | image | code',

        // Връзка към Laravel upload
        images_upload_handler: function (blobInfo, progress) {
          return new Promise(function (resolve, reject) {
            let xhr = new XMLHttpRequest();
            xhr.open('POST', '/admin/pages/upload');
            xhr.setRequestHeader('X-CSRF-TOKEN', document.querySelector('meta[name="csrf-token"]').getAttribute('content'));
            xhr.withCredentials = true;

            xhr.upload.onprogress = function (e) {
              progress(e.loaded / e.total * 100);
            };

            xhr.onload = function () {
              if (xhr.status < 200 || xhr.status >= 300) {
                reject('HTTP Error: ' + xhr.status);
                return;
              }
              let json = JSON.parse(xhr.responseText);
              resolve(json.location);
            };

            xhr.onerror = function () {
              reject('Image upload failed');
            };

            let formData = new FormData();
            formData.append('file', blobInfo.blob());
            xhr.send(formData);
          });
        }
        ,


        // File picker за Insert Image
        file_picker_types: 'image',
        file_picker_callback: function(callback, value, meta) {
          if (meta.filetype === 'image') {
            let input = document.createElement('input');
            input.setAttribute('type', 'file');
            input.setAttribute('accept', 'image/*');
            input.onchange = function() {
              let file = this.files[0];
              let formData = new FormData();
              formData.append('file', file);

              let xhr = new XMLHttpRequest();
              xhr.open('POST', '/admin/pages/upload');
              xhr.setRequestHeader('X-CSRF-TOKEN', document.querySelector('meta[name="csrf-token"]').getAttribute('content'));
              xhr.onload = function() {
                let json = JSON.parse(xhr.responseText);
                callback(json.location, { alt: file.name });
              };
              xhr.send(formData);
            };
            input.click();
          }
        }
      });
    </script>
@endsection