@extends('layouts.admin')

@section('content')
@php
    use App\Models\MenuItem;
    $items = MenuItem::with('children')
                     ->whereNull('parent_id')
                     ->orderBy('order')
                     ->get();
@endphp

<div class="container mt-4">
    <div class="d-flex justify-content-between mb-3">
        <h1>Меню</h1>
        <a href="{{ route('admin.menu.create') }}" class="btn btn-primary">+ Добави елемент</a>
    </div>

    <div id="menu-list" class="list-group">
        @foreach($items as $item)
            @include('admin.menu.item', ['item' => $item, 'level' => 0])
        @endforeach

    </div>

    <p class="text-muted mt-3">Плъзгай елементите, за да промениш реда.</p>
</div>

<!-- jQuery + jQuery UI -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://code.jquery.com/ui/1.13.2/jquery-ui.min.js"></script>

<script>
  $(function() {
    $("#menu-list").sortable({
      items: '.menu-item',
      update: function() {
        const order = [];
        $('.menu-item').each(function() {
          order.push({
            id: $(this).data('id'),
            parent_id: $(this).data('parent') || null
          });
        });
        $.post('{{ route("admin.menu.reorder") }}', {
          order: order,
          _token: '{{ csrf_token() }}'
        });
      }
    });
  });
</script>
@endsection