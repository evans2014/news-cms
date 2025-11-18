<nav aria-label="breadcrumb" class="bg-light py-3 border-bottom">
    <div class="container">
        <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item">
                <a href="{{ route('home') }}" class="text-decoration-none">Начало</a>
            </li>

            @hasSection('breadcrumbs')
                @yield('breadcrumbs')
            @else
                {{-- Автоматични breadcrumbs за най-честите страници --}}
                @if(request()->routeIs('news.show'))
                    <li class="breadcrumb-item">
                        <a href="{{ route('home') }}" class="text-decoration-none">Новини</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">
                        {{ Str::limit($news->title ?? '', 40) }}
                    </li>
                @elseif(request()->routeIs('category.show'))
                    <li class="breadcrumb-item">
                        <a href="{{ route('categories.index') }}" class="text-decoration-none">Категории</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">
                        {{ $category->name ?? '' }}
                    </li>
                @elseif(request()->routeIs('pages.show'))
                    <li class="breadcrumb-item active" aria-current="page">
                        {{ $page->title ?? '' }}
                    </li>
                @endif
            @endif
        </ol>
    </div>
</nav>