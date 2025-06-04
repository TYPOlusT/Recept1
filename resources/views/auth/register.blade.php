@extends('layout.layouts')
@section('title', 'Регистрация')
@section('content')
<div class="container">
    @if (session('success'))
        <div class="custom-alert">
            {{ session('success') }}
            <span class="close" onclick="this.parentElement.style.display='none';">&times;</span>
        </div>
    @endif

    @if ($errors->any())
        <div class="custom-alert">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <span class="close" onclick="this.parentElement.style.display='none';">&times;</span>
        </div>
    @endif

    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow-lg rounded-lg mt-5">
                <div class="card-body p-5">
                    <h2 class="text-center mb-4">Регистрация</h2>
                    <form method="POST" action="{{ route('register.store') }}">
                        @csrf
                        <div class="form-group mb-4">
                            <label for="firstname" class="form-label">Имя</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-user"></i></span>
                                <input type="text" class="form-control" id="firstname" name="firstname" value="{{ old('firstname') }}" required placeholder="Введите имя">
                            </div>
                        </div>
                        <div class="form-group mb-4">
                            <label for="lastname" class="form-label">Фамилия</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-user"></i></span>
                                <input type="text" class="form-control" id="lastname" name="lastname" value="{{ old('lastname') }}" required placeholder="Введите фамилию">
                            </div>
                        </div>
                        <div class="form-group mb-4">
                            <label for="patronymic" class="form-label">Отчество</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-user"></i></span>
                                <input type="text" class="form-control" id="patronymic" name="patronymic" value="{{ old('patronymic') }}" placeholder="Введите отчество">
                            </div>
                        </div>
                        <div class="form-group mb-4">
                            <label for="email" class="form-label">Email адрес</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                                <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}" required placeholder="Введите email">
                            </div>
                        </div>
                        <div class="form-group mb-4">
                            <label for="password" class="form-label">Пароль</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-lock"></i></span>
                                <input type="password" class="form-control" id="password" name="password" required placeholder="Введите пароль">
                            </div>
                        </div>
                        <div class="form-group mb-4">
                            <label for="password_confirmation" class="form-label">Подтверждение пароля</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-lock"></i></span>
                                <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" required placeholder="Подтвердите пароль">
                            </div>
                        </div>
                        <div class="form-group mb-4">
                            <label for="gender" class="form-label">Пол</label>
                            <select class="form-select" id="gender" name="gender" required>
                                <option value="">Выберите пол</option>
                                <option value="w" {{ old('gender') == 'w' ? 'selected' : '' }}>Женский</option>
                                <option value="m" {{ old('gender') == 'm' ? 'selected' : '' }}>Мужской</option>
                            </select>
                        </div>
                        <input type="hidden" id="role" name="role" value="user">
                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary btn-lg">Зарегистрироваться</button>
                        </div>
                        <div class="text-center mt-4">
                            <p>Уже есть аккаунт? <a href="{{ route('login') }}" class="text-decoration-none">Войти</a></p>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection