@extends('layouts.admin')

@section('content')
    <div class="container mt-4">
        <h1>Създай страница</h1>
        <form action="{{ route('admin.pages.store') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label>Заглавие</label>
                <input type="text" name="title" id="title" class="form-control" value="{{ old('title') }}" required>
            </div>
            <div class="mb-3">
                <label>Slug (URL)</label>
                <input type="text" name="slug" id="slug" class="form-control" value="{{ old('slug') }}" required>
                <small class="text-muted">Пример: <code>about-us</code></small>
            </div>
            <div class="mb-3">
                <label class="form-label">Съдържание</label>
                <textarea
                        name="content"
                        id="tinymce-editor"
                        class="form-control"
                >{{ old('content', $page->content ?? '') }}</textarea>
            </div>
            <button type="submit" class="btn btn-success">Създай</button>
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
          plugins: [
            'advlist', 'autolink', 'lists', 'link', 'image', 'charmap',
            'preview', 'anchor', 'searchreplace', 'visualblocks', 'code',
            'fullscreen', 'insertdatetime', 'media', 'table', 'help', 'wordcount'
          ],
          toolbar: 'undo redo | blocks | bold italic underline | ' +
            'alignleft aligncenter alignright alignjustify | ' +
            'bullist numlist outdent indent | link image media | ' +
            'removeformat | code | fullscreen',
          branding: false,
          promotion: false,
          images_upload_url: '{{ route("admin.pages.upload") }}',
          automatic_uploads: true,
          file_picker_types: 'image',
          relative_urls: false,
          remove_script_host: false,
          convert_urls: true,
          setup: function (editor) {
            editor.on('init', function () {
              const initialContent = editor.getElement().value;
              if (initialContent) {
                editor.setContent(initialContent);
              }
            });

            editor.on('change keyup paste', function () {
              editor.save();
            });
          }
        });
      });
    </script>
@endsection