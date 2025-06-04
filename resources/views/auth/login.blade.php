@extends('layout.layouts')
@section('title', 'Авторизация')
@section('content')
<div class="container">
    @if (session('success'))
        <div class="custom-alert">
            {{ session('success') }}
            <span class="close" onclick="this.parentElement.style.display='none';">&times;</span>
        </div>
    @endif

    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow-lg rounded-lg mt-5">
                <div class="card-body p-5">
                    <h2 class="text-center mb-4">Добро пожаловать</h2>
                    <form method="POST" action="{{ route('login.post') }}">
                        @csrf
                        <div class="form-group mb-4">
                            <label for="email" class="form-label">Email адрес</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                                <input type="email" class="form-control" id="email" name="email" required placeholder="Введите email">
                            </div>
                        </div>
                        <div class="form-group mb-4">
                            <label for="password" class="form-label">Пароль</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-lock"></i></span>
                                <input type="password" class="form-control" id="password" name="password" required placeholder="Введите пароль">
                            </div>
                        </div>
                        <div class="form-check mb-4">
                            <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                            <label class="form-check-label" for="remember">Запомнить меня</label>
                        </div>
                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary btn-lg">Войти</button>
                        </div>
                        <div class="text-center mt-4">
                            <p>Нет аккаунта? <a href="{{ route('register') }}" class="text-decoration-none">Зарегистрируйтесь</a></p>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection