@extends('layouts.admin')

@section('title', 'Нов потребител')

@section('content')
    <div class="card shadow">
        <div class="card-header bg-success text-white">
            <h5 class="mb-0">Създай нов потребител</h5>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.users.store') }}" method="POST">
                @csrf

                <div class="mb-3">
                    <label class="form-label">Име</label>
                    <input type="text" name="name" class="form-control" value="{{ old('name') }}" required>
                    @error('name') <small class="text-danger">{{ $message }}</small> @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Email</label>
                    <input type="email" name="email" class="form-control" value="{{ old('email') }}" required>
                    @error('email') <small class="text-danger">{{ $message }}</small> @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Парола</label>
                    <input type="password" name="password" class="form-control" required>
                    @error('password') <small class="text-danger">{{ $message }}</small> @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Потвърди парола</label>
                    <input type="password" name="password_confirmation" class="form-control" required>
                </div>

                <div class="mb-3 form-check">
                    <input type="checkbox" name="is_admin" class="form-check-input" id="is_admin" {{ old('is_admin') ? 'checked' : '' }}>
                    <label class="form-check-label" for="is_admin">Администратор</label>
                </div>

                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-success">Създай</button>
                    <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">Отказ</a>
                </div>
            </form>
        </div>
    </div>
@endsection