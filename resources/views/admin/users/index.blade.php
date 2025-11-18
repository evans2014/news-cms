@extends('layouts.admin')

@section('title', 'Потребители')

@section('content')
    <div class="card shadow">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Потребители</h5>
            <a href="{{ route('admin.users.create') }}" class="btn btn-primary btn-sm">+ Нов потребител</a>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                    <tr>
                        <th>Име</th>
                        <th>Email</th>
                        <th>Роля</th>
                        <th>Действия</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse($users as $user)
                        <tr>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>
                            <span class="badge {{ $user->is_admin ? 'bg-danger' : 'bg-secondary' }}">
                                {{ $user->is_admin ? 'Админ' : 'Потребител' }}
                            </span>
                            </td>
                            <td>
                                <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-sm btn-warning">Редактирай</a>
                                <form action="{{ route('admin.users.destroy', $user) }}" method="POST" class="d-inline">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Изтриване?')">Изтрий</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center text-muted">Няма потребители</td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
            {{ $users->links() }}
        </div>
    </div>
@endsection