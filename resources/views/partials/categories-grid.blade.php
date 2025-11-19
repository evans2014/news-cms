<div class="row">
    @forelse($categories as $category)
        <div class="col-lg-3 col-md-3 col-sm-4 col-xs-6  mb-4">
            <a href="{{ route('category.show', $category->slug) }}" class="text-decoration-none">
            <div class="card h-100 shadow-sm text-center">
                @if($category->image)
                    <img src="{{ asset('storage/' . $category->image) }}" class="card-img-top" style="height:auto;object-fit:cover;">
                @else
                    <div class="bg-light border-dashed" style="height:auto;display:flex;align-items:center;justify-content:center;">
                        <span class="text-muted">Без снимка</span>
                    </div>
                @endif
                <div class="card-body">
                    <h5 class="card-title">

                            {{ $category->name }}

                    </h5>
                    <p class="text-muted small">
                        {{ $category->news_count }} новини
                    </p>
                </div>
            </div></a>
        </div>
    @empty
        <div class="col-12 text-center py-5">
            <p class="text-muted">Няма намерени категории.</p>
        </div>
    @endforelse
</div>