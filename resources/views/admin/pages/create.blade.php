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
                        id="editor"
                        class="form-control"
                >{{ old('content', $page->content ?? '') }}</textarea>
            </div>
            <button type="submit" class="btn btn-success">Създай</button>
        </form>
    </div>

    <script>
      tinymce.init({
        selector: '#editor',
        height: 400,
        menubar: true,
        relative_urls: false,
        remove_script_host: false,
       // plugins: 'image link media code lists',
        //toolbar: 'undo redo | bold italic | alignleft aligncenter alignright | bullist numlist | image | code',
        plugins: 'code table lists image link media ',
        toolbar: 'undo redo | blocks | bold italic | alignleft aligncenter alignright | indent outdent | bullist numlist | code | table',

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