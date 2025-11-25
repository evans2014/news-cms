@forelse($media ?? [] as $m)
    <div class="col-4 col-md-3 col-lg-2 position-relative">
        <img src="{{ $m->url }}"
             class="img-thumbnail shadow-sm"
             style="height:130px; width:100%; object-fit:cover; cursor:pointer"
             onclick="selectImage('{{ $m->url }}')">

        <button type="button"
                class="btn btn-danger rounded-circle position-absolute top-0 end-0 m-2 shadow-lg"
                style="width:36px; height:36px; z-index:10"
                onclick="event.stopPropagation(); deleteMedia({{ $m->id }}, this)">
            <i class="bi bi-trash-fill"></i>
        </button>

    </div>

@empty
    <div class="col-12 text-center py-5 text-muted">
        <h5>Няма качени снимки</h5>
        <p>Качете първата си снимка горе</p>
    </div>
@endforelse

<div class="mt-4 d-flex justify-content-center">
    {{ $media->onEachSide(1)->links() }}
</div>

<script>
  document.addEventListener('click', function(e) {
    if (e.target.closest('a[rel="next"], a[rel="prev"], .pagination a')) {
      e.preventDefault();
      const url = e.target.closest('a').getAttribute('href');
      if (url && url !== '#') {
        loadMedia(url.split('?')[1] ? '?' + url.split('?')[1] : '');
      }
    }
  });
</script>