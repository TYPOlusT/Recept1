<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Кулинарные рецепты | @yield('title', 'Главная')</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary-color: #ff6b6b;
            --secondary-color: #4ecdc4;
            --dark-color: #2d3436;
            --light-color: #f9f9f9;
        }

        body {
            font-family: 'Montserrat', sans-serif;
            background-color: var(--light-color);
            color: var(--dark-color);
            line-height: 1.6;
            -webkit-user-select: none;
            -moz-user-select: none;
            -ms-user-select: none;
            user-select: none;
        }

        .wrapper {
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        .navbar-custom {
            background-color: white;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            padding: 1rem 0;
        }

        .navbar-brand {
            font-size: 1.8rem;
            font-weight: 700;
            color: var(--primary-color) !important;
        }

        .nav-link {
            font-weight: 500;
            color: var(--dark-color) !important;
            margin: 0 1rem;
            transition: color 0.3s ease;
        }

        .nav-link:hover {
            color: var(--primary-color) !important;
        }

        .btn-custom {
            background-color: var(--primary-color);
            color: white;
            border: none;
            padding: 0.8rem 1.5rem;
            border-radius: 25px;
            transition: transform 0.3s ease;
        }

        .btn-custom:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(255,107,107,0.3);
        }

        .card {
            border: none;
            border-radius: 15px;
            overflow: hidden;
            transition: transform 0.3s ease;
            background: white;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }

        .card:hover {
            transform: translateY(-5px);
        }

        .card-img-top {
            height: 200px;
            object-fit: cover;
        }

        footer {
            background-color: var(--dark-color);
            color: white;
            padding: 2rem 0;
            margin-top: auto;
        }

        footer a {
            color: var(--secondary-color) !important;
            transition: color 0.3s ease;
        }

        footer a:hover {
            color: white !important;
        }

        .content {
            padding: 2rem 0;
        }

        .form-control {
            border-radius: 25px;
            padding: 0.8rem 1.2rem;
        }

        .alert {
            border-radius: 15px;
        }

        @media (max-width: 768px) {
            .navbar-nav {
                text-align: center;
            }
            
            .nav-link {
                margin: 0.5rem 0;
            }
        }
    </style>
</head>

<body>
    <div class="wrapper">
        <nav class="navbar navbar-expand-lg navbar-light navbar-custom fixed-top">
            <div class="container">
                <a class="navbar-brand" href="/">Вкусные Рецепты</a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav ml-auto">
                       
                         <li class="nav-item">
                            <a class="nav-link" href="/news">Новости</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="/category">Категории</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="/favorites">
                                <i class="far fa-heart"></i> Избранное
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="/product">Рецепты</a>
                        </li>
                        @if (!Auth::check())
                            <li class="nav-item">
                                <a class="nav-link btn-custom" href="{{route('login')}}">Войти</a>
                            </li>
                        @else
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown">
                                    <i class="far fa-user"></i> Профиль
                                </a>
                                <div class="dropdown-menu">
                                    <a class="dropdown-item" href="/profile">Мой профиль</a>
                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item" href="/logout" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                        Выйти
                                    </a>
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endif
                    </ul>
                </div>
            </div>
        </nav>

        <div class="container content" style="margin-top: 80px;">
            @yield('content')
        </div>

        <footer class="footer">
            <div class="container">
                <div class="row">
                    <div class="col-md-6">
                        <h5>О нас</h5>
                        <p>Мы собираем лучшие кулинарные рецепты со всего мира, чтобы сделать вашу готовку проще и вкуснее!</p>
                    </div>
                    <div class="col-md-6">
                        <h5>Полезные ссылки</h5>
                        <ul class="list-unstyled">
                            <li><a href="/privacy-policy">Политика конфиденциальности</a></li>
                            <li><a href="/terms-of-service">Условия использования</a></li>
                            <li><a href="/contact">Связаться с нами</a></li>
                        </ul>
                    </div>
                </div>
                <hr class="mt-4">
                <p class="text-center mb-0">© {{ date('Y') }} Вкусные Рецепты - Все права защищены</p>
            </div>
        </footer>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    @yield('scripts')
</body>
</html>
