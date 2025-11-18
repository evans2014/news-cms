@extends('layouts.app')

@section('title', 'Вход')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-5">
            <div class="card shadow">
                <div class="card-header bg-primary text-white text-center">
                    <h4>Вход в системата</h4>
                </div>
                <div class="card-body p-4">
                    <form method="POST" action="{{ route('login') }}">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label">Email</label>
                            <input type="email" name="email" class="form-control" value="{{ old('email') }}" required autofocus>
                            @error('email') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Парола</label>
                            <input type="password" name="password" class="form-control" required>
                        </div>
                        <div class="mb-3 form-check">
                            <input type="checkbox" name="remember" class="form-check-input" id="remember">
                            <label class="form-check-label" for="remember">Запомни ме</label>
                        </div>
                        <button type="submit" class="btn btn-primary w-100">Вход</button>
                    </form>
                    <div class="text-center mt-3">
                        <a href="{{ route('register') }}" class="text-muted">Нямаш акаунт? Регистрирай се</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection