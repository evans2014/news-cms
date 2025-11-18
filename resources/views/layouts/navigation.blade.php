<nav class="navbar navbar-expand-lg bg-white shadow-sm">
    <div class="container">
        <!-- ЛОГО -->
        <a class="navbar-brand fw-bold text-primary" href="{{ route('home') }}">
            Collection CMS
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse1 navbar-collapse" id="navbarNav">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                @php
                    $menuItems = \App\Models\MenuItem::with('children')
                                                     ->whereNull('parent_id')
                                                     ->where('is_active', true)
                                                     ->orderBy('order')
                                                     ->get();



                @endphp



                @foreach($menuItems as $item)
                    @if($item->children->count() > 0)
                        <!-- ДРОПДАУН -->
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                                {{ $item->title }}
                            </a>
                            <ul class="dropdown-menu">
                                @foreach($item->children as $child)
                                    @php
                                        $url = '#';

                                    if ($item->type === 'internal' || $item->type === 'external') {
                                        $url = $item->url ?? '#';
                                    } elseif ($item->target_id) {
                                        $url = match($item->type) {
                                            'page'     => ($page = \App\Models\Page::find($item->target_id))     ? route('page.show', $page->slug)     : '#',
                                            'category' => ($cat  = \App\Models\Category::find($item->target_id)) ? route('category.show', $cat->slug)  : '#',
                                            'news'     => ($news = \App\Models\News::find($item->target_id))     ? route('news.show', $news)             : '#',
                                            default    => '#',
                                        };
                                    }

                                    @endphp

                                    <li><a class="dropdown-item" href="{{ $url }}">{{ $child->title }}</a></li>
                                @endforeach
                            </ul>
                        </li>
                    @else
                        @php
                            $url = '#';

                                    if ($item->type === 'internal' || $item->type === 'external') {
                                        $url = $item->url ?? '#';
                                    } elseif ($item->target_id) {
                                        $url = match($item->type) {
                                            'page'     => ($page = \App\Models\Page::find($item->target_id))     ? route('page.show', $page->slug)     : '#',
                                            'category' => ($cat  = \App\Models\Category::find($item->target_id)) ? route('category.show', $cat->slug)  : '#',
                                            'news'     => ($news = \App\Models\News::find($item->target_id))     ? route('news.show', $news)             : '#',
                                            default    => '#',
                                        };
                                    }
                        @endphp
                        <li class="nav-item">
                            <a class="nav-link" href="{{ $url }}">{{ $item->title }}</a>
                        </li>
                    @endif
                @endforeach
            </ul>
            <ul class="navbar-nav">
                @auth
                    @if(auth()->user()->is_admin)
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                                Админ
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li><a class="dropdown-item" href="{{ route('admin.dashboard') }}">Панел</a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <form method="POST" action="{{ route('logout') }}" class="d-inline">
                                        @csrf
                                        <button class="dropdown-item text-danger">Изход</button>
                                    </form>
                                </li>
                            </ul>
                        </li>
                    @else
                        <li class="nav-item">
                            <form method="POST" action="{{ route('logout') }}" class="d-inline">
                                @csrf
                                <button class="nav-link btn btn-link p-0">Изход</button>
                            </form>
                        </li>
                    @endif
                @else
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('login') }}">Вход</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('registration') }}">Регистрация</a>
                    </li>
                @endauth
            </ul>
        </div>
    </div>
</nav>