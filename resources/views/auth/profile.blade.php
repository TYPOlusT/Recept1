@extends('layout.layouts')
@section('title', 'Профиль')
@section('content')

<div class="container py-5">
    @if (session('success'))
    <div class="custom-alert">
        {{ session('success') }}
        <span class="close" onclick="this.parentElement.style.display='none';">&times;</span>
    </div>
    @endif

    <div class="row">
        <div class="col-md-4">
            <div class="card shadow-sm">
                <div class="card-body">
                    <div class="d-flex flex-column align-items-center text-center">
                        <img src="{{ $user->gender == 'w' ? 'https://bootdey.com/img/Content/avatar/avatar3.png' : 'https://bootdey.com/img/Content/avatar/avatar7.png' }}" alt="Admin" class="rounded-circle" width="150">
                        <div class="mt-3">
                            <h4>{{ $user->firstname }} {{ $user->lastname }}</h4>
                            <p class="text-muted">{{ $user->email }}</p>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="card mt-3 shadow-sm">
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-12">
                            <h6 class="mb-3">Личная информация</h6>
                            <div class="mb-2">
                                <strong>Имя:</strong> {{ $user->firstname }}
                            </div>
                            <div class="mb-2">
                                <strong>Фамилия:</strong> {{ $user->lastname }}
                            </div>
                            <div class="mb-2">
                                <strong>Отчество:</strong> {{ $user->patronymic }}
                            </div>
                            <div class="mb-2">
                                <strong>Email:</strong> {{ $user->email }}
                            </div>
                            <div class="mb-2">
                                <strong>Пол:</strong> {{ $user->gender == 'w' ? 'Женский' : 'Мужской' }}
                            </div>
                            <div class="mt-3">
                                <a href="{{ route('profile.edit') }}" class="btn btn-primary">Редактировать профиль</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h5 class="card-title mb-4">Ваши рецепты</h5>
                    @if ($user->products->isEmpty())
                        <div class="text-center py-4">
                            <i class="fas fa-book-open fa-3x mb-3 text-muted"></i>
                            <p class="text-muted">У вас еще нет рецептов.</p>
                            <a href="{{ route('product.create') }}" class="btn btn-primary">Добавить первый рецепт</a>
                        </div>
                    @else
                        <div class="row">
                            @foreach ($user->products as $product)
                                <div class="col-md-6 mb-4">
                                    <div class="card h-100 shadow-sm">
                                        <img src="{{ asset('public/' . $product->img) }}" class="card-img-top" alt="{{ $product->name }}" style="height: 200px; object-fit: cover;">
                                        <div class="card-body">
                                            <h5 class="card-title">{{ $product->name }}</h5>
                                            <div class="rating-display mb-2">
                                                <div class="stars">
                                                    @for($i = 1; $i <= 5; $i++)
                                                        <span class="star {{ $i <= $product->averageRating() ? 'active' : '' }}">★</span>
                                                    @endfor
                                                </div>
                                                <span class="rating-value">{{ number_format($product->averageRating(), 1) }}</span>
                                            </div>
                                            <div class="d-flex justify-content-between align-items-center mt-3">
                                                <a href="{{ route('product.show', $product->id) }}" class="btn btn-outline-primary btn-sm">Подробнее</a>
                                                <a href="{{ route('product.edit', $product->id) }}" class="btn btn-outline-secondary btn-sm">Редактировать</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .rating-display {
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .stars {
        display: flex;
        gap: 0.2rem;
    }

    .star {
        color: #ddd;
        font-size: 1.2rem;
    }

    .star.active {
        color: #ffd700;
    }

    .rating-value {
        color: #666;
        font-size: 0.9rem;
    }
</style>

@endsection
