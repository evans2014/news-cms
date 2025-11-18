@extends('layouts.app')

@section('title', 'Регистрация')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow">
                <div class="card-header bg-success text-white text-center">
                    <h4>Регистрация</h4>
                </div>
                <div class="card-body p-4">
                    <form method="POST" action="{{ route('registration') }}">
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
                        <button type="submit" class="btn btn-success w-100">Регистрация</button>
                    </form>
                    <div class="text-center mt-3">
                        <a href="{{ route('login') }}" class="text-muted">Вече имаш акаунт? Влез</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection