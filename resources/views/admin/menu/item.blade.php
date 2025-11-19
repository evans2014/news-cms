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
            <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#deleteModal"
                    onclick="setDeleteForm('{{ route('admin.menu.destroy', $item->id) }}')">
                <i class="bi bi-trash"></i> Изтрий
            </button>
        </form>
    </div>
</div>
<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title">
                    <i class="bi bi-exclamation-triangle"></i> Потвърждение за изтриване
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body text-center py-4">
                <p class="lead">Сигурен ли си, че искаш да изтриеш този запис?</p>
                <p class="text-muted">Това действие е необратимо!</p>
            </div>
            <div class="modal-footer justify-content-center">
                <button type="button" class="btn btn-secondary px-4" data-bs-dismiss="modal">
                    Отказ
                </button>
                <form id="deleteForm" method="POST" style="display: inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger px-5">
                        Да, изтрий завинаги
                    </button>

                </form>
            </div>
        </div>
    </div>
</div>

<script>
  function setDeleteForm(action) {
    document.getElementById('deleteForm').action = action;
  }
</script>

@foreach($item->children as $child)
    @if($child)
        @include('admin.menu.item', ['item' => $child, 'level' => $level + 1])
    @endif
@endforeach