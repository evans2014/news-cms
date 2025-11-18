@extends('layouts.app')

@section('content')
    <div class="container py-5">
        <h1 class="mb-4">Всички категории</h1>

        <div class="mb-4">
            <input type="text" id="search" class="form-control form-control-lg" placeholder="Търси категория...">
        </div>

        <div id="categories-grid"></div>
        <div id="pagination" class="mt-4 d-flex justify-content-center"></div>
    </div>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script>
      $(document).ready(function() {
        function loadCategories(page = 1, search = '') {
          $.get('{{ route("categories.ajax") }}', { page: page, search: search }, function(data) {
            $('#categories-grid').html(data.html);
            $('#pagination').html(data.pagination);
          });
        }

        loadCategories();

        let timeout;
        $('#search').on('keyup', function() {
          clearTimeout(timeout);
          timeout = setTimeout(() => {
            loadCategories(1, $(this).val().trim());
          }, 400);
        });

        $(document).on('click', '.pagination a', function(e) {
          e.preventDefault();
          const url = new URL(this.href);
          const page = url.searchParams.get('page');
          const search = $('#search').val().trim();
          loadCategories(page, search);
        });
      });
    </script>
@endsection