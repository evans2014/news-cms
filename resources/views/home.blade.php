@extends('layouts.app')

@section('content')
    <div class="container mt-4 ">
        <h1>Последни новини</h1>
        <div class="mb-3">
            <input type="text" id="search" class="form-control" placeholder="Търси...">
        </div>
        <div id="news-grid" class="row"></div>
        <div id="pagination" class="mt-4 pb-5 d-flex justify-content-center"></div>
    </div>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script>
    $(document).ready(function() {
      function loadNews(page = 1, search = '') {
        $.ajax({
          url: '{{ route("news.ajax") }}',
          method: 'GET',
          data: { page: page, search: search },
          success: function(data) {
            $('#news-grid').html(data.html || '<p class="text-muted text-center">Няма постове.</p>');
            $('#pagination').html(data.pagination || '');
          },
          error: function(xhr) {
            console.error(xhr.responseText);
            $('#news-grid').html('<div class="col-12 text-center text-danger">Грешка при зареждане на постове.</div>');
          }
        });
      }
      loadNews();
      let searchTimeout;
      $('#search').on('keyup', function() {
        clearTimeout(searchTimeout);
        searchTimeout = setTimeout(() => {
          loadNews(1, $(this).val().trim());
        }, 400); // дебъунс
      });

      $(document).on('click', '.pagination a', function(e) {
        e.preventDefault();
        const url = new URL(this.href);
        const page = url.searchParams.get('page') || 1;
        const search = $('#search').val().trim();
        loadNews(page, search);
        $('html, body').animate({ scrollTop: 0 }, 300);
      });
    });
    </script>
@endsection