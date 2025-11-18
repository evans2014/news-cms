@php
    // АКО $level ЛИПСВА → 0
    $level = $level ?? 0;
    $padding = $level * 30;
@endphp

<div class="menu-item list-group-item p-3 d-flex justify-content-between align-items-center"
     data-id="{{ $item->id }}"
     data-parent="{{ $item->parent_id }}"
     style="margin-left: {{ $padding }}px; border-left: 3px solid {{ $item->depth > 0 ? '#007bff' : '#28a745' }};">
    <div>
        <strong>{{ $item->title }}</strong>
        <small class="text-muted">
            @if($item->type === 'external')
                ({{ $item->url }})
            @else
                ({{ ucfirst($item->type) }})
            @endif
        </small>
    </div>
    <div>
        <a href="{{ route('admin.menu.edit', $item) }}" class="btn btn-sm btn-warning">Редактирай</a>
        <form action="{{ route('admin.menu.destroy', $item->id) }}" method="POST" class="d-inline">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-sm btn-danger"
                    onclick="return confirm('Сигурни ли сте, че искате да изтриете „{{ $item->title }}“?')">
                Изтрий
            </button>
        </form>
    </div>
</div>

@foreach($item->children as $child)
    @if($child)
        @include('admin.menu.item', ['item' => $child, 'level' => $level + 1])
    @endif
@endforeach