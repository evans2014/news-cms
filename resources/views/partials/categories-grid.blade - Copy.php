@foreach($categories as $category)
    <div class="col-md-6 col-lg-4">
        <a href="{{ route('category.show', $category->slug) }}" class="text-decoration-none">

            <div class="card h-100 shadow-sm hover-shadow transition">
                <div class="card-body text-center d-flex flex-column justify-content-center">
                    @if($category->image)
                        <img src="{{ asset('storage/' . $category->image) }}" class="card-img-top" style="height:200px;object-fit:cover;" alt="{{ $category->name }}">
                    @endif
                    <i class="fas fa-folder fa-3x text-primary mb-3"></i>
                    <h5 class="card-title text-dark">{{ $category->name }}</h5>
                    <small class="text-muted">{{ $category->news_count }} новини</small>
                </div>
            </div>
        </a>
    </div>
@endforeach