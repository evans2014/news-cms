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
                        id="tinymce-editor"
                        class="form-control d-none"
                >{{ old('content', $page->content ?? '') }}</textarea>

            </div>
            <button type="submit" class="btn btn-success">Обнови</button>
            <a href="{{ route('admin.pages.index') }}" class="btn btn-secondary">Назад</a>
        </form>
    </div>
    <script>
      document.addEventListener('DOMContentLoaded', function () {
        if (tinymce.get('tinymce-editor')) {
          tinymce.remove('#tinymce-editor');
        }

        tinymce.init({
          selector: 'textarea#tinymce-editor',
          height: 500,
          menubar: true,
          plugins: 'link image lists table code media fullscreen',
          toolbar: 'undo redo | bold italic | alignleft aligncenter alignright | bullist numlist | link image media | code | fullscreen',
          branding: false,
          promotion: false,
          images_upload_handler: function (blobInfo, progress) {
            return new Promise(function (resolve, reject) {
              let xhr = new XMLHttpRequest();
              xhr.open('POST', '{{ route("admin.pages.upload") }}');
              xhr.withCredentials = true;

              xhr.setRequestHeader(
                'X-CSRF-TOKEN',
                document.querySelector('meta[name="csrf-token"]').getAttribute('content')
              );

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
          },
        // automatic_uploads: true,
          file_picker_types: 'image',
          relative_urls: false,
          remove_script_host: false,
          convert_urls: true,

          setup: function (editor) {
            editor.on('init', function () {
              const textarea = document.getElementById('tinymce-editor');
              if (textarea && textarea.value) {
                // Декодирай, ако е ескейпнато
                const decoded = textarea.value
                  .replace(/&lt;/g, '<')
                  .replace(/&gt;/g, '>')
                  .replace(/&amp;/g, '&');
                editor.setContent(decoded);
              }
            });

            editor.on('change keyup paste', function () {
              const content = editor.getContent();
              document.getElementById('tinymce-editor').value = content;
            });
          }
        });
      });
    </script>
@endsection