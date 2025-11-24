<div class="row">
    @forelse($categories as $category)

        <div class="col-lg-2 col-md-3 col-sm-4 col-xs-6 p-2">
            <a href="{{ route('category.show', $category->slug) }}" class="text-decoration-none">
            <div class="card h-100 shadow-sm text-center">
                @if($category->image)
                    <img src="{{ $category->image }}" class="card-img-top" style="height:auto;object-fit:cover;">
                @else
                    <div class="bg-light border-dashed" style="height:auto;display:flex;align-items:center;justify-content:center;">
                        <span class="text-muted">Без снимка</span>
                    </div>
                @endif
                <div class="card-body p-1">
                    <h5 class="card-title">
                            {{ $category->name }}
                    </h5>
                    <p class="text-muted small">
                        {{ $category->news_count }}
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