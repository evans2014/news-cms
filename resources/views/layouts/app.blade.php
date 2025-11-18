<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @include('partials.seo')


    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <!-- В app.blade.php -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.tiny.cloud/1/pevkj1un72fxa0t2cmkxzyylb6pcekmzy5gwryy2k0b5aonf/tinymce/7/tinymce.min.js" referrerpolicy="origin"></script>

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased">
<div class="min-h-screen bg-gray-100">
    @include('layouts.navigation')

    <!-- Page Heading -->
    <header class="bg-white shadow">
        <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
            {{ $header ?? '' }}
        </div>
    </header>
    <!-- Page Content -->
    <main>
        @yield('content')
    </main>
</div>
<script>
  tinymce.init({
    selector: '#tinymce-editor',
    height: 500,
    plugins: 'image link lists table code media',
    toolbar: 'undo redo | styles | bold italic | alignleft aligncenter alignright | bullist numlist | link image media | code',
    images_upload_url: '{{ route("admin.pages.upload") }}',
    automatic_uploads: true,
    file_picker_types: 'image',
    relative_urls: false,
    remove_script_host: false,
  });
</script>
<script>
  // Позволява изтриване през confirm()
  document.querySelectorAll('form').forEach(form => {
    form.addEventListener('submit', function(e) {
      if (form.querySelector('button[type="submit"]')?.innerText.includes('Изтрий')) {
        if (!confirm('Сигурни ли сте?')) {
          e.preventDefault();
        }
      }
    });
  });
</script>
</body>
</html>