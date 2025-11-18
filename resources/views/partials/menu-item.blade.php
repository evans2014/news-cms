@if(!isset($item) || !$item) @continue @endif

@php
    $url = '#';
    $attributes = '';

    if (in_array($item->type, ['internal', 'external']) && $item->url) {
        $url = $item->url;
        if ($item->type === 'external') {
            $attributes = 'target="_blank" rel="noopener"';
        }
    }
    elseif ($item->target_id) {
        $url = match($item->type) {
            'page'     => ($p = \App\Models\Page::find($item->target_id))?->slug
                ? route('pages.show', $p->slug) : '#',
            'category' => ($c = \App\Models\Category::find($item->target_id))?->slug
                ? route('category.show', $c->slug) : '#',
            'news'     => \App\Models\News::find($item->target_id)
                ? route('news.show', $item->target_id) : '#',
            default    => '#'
        };
    }
@endphp

<li class="nav-item {{ $item->children->count() ? 'dropdown' : '' }}">
    <a href="{{ $url }}"
       class="nav-link {{ $item->children->count() ? 'dropdown-toggle' : '' }}"
       @if($item->children->count()) data-bs-toggle="dropdown" @endif
            {!! $attributes !!}>
        {{ $item->title }}
    </a>

    @if($item->children->count())
        <ul class="dropdown-menu">
            @foreach($item->children as $child)
                @include('partials.menu-item', ['item' => $child])
            @endforeach
        </ul>
    @endif
</li>