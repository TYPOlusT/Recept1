@extends('layout.layouts')
@section('title', 'Избранные рецепты')

@section('content')
    <div class="container">
        <h1 class="text-center mb-4">Избранные рецепты</h1>

        @if($favorites->isEmpty())
            <div class="text-center py-5">
                <i class="fas fa-heart-broken fa-3x mb-3 text-muted"></i>
                <p class="text-muted">У вас пока нет избранных рецептов.</p>
                <a href="{{ route('product.index') }}" class="btn btn-primary">Перейти к рецептам</a>
            </div>
        @else
            <div class="row">
                @foreach($favorites as $product)
                    <div class="col-md-4 mb-4">
                        <div class="card h-100 recipe-card shadow-sm">
                            <div class="card-img-wrapper">
                                <img src="{{ asset('public/' . $product->img) }}" class="card-img-top" alt="{{ $product->name }}">
                                <div class="card-img-overlay d-flex align-items-end">
                                    @if($product->categories->isNotEmpty())
                                        <span class="badge bg-light text-dark p-2">{{ $product->categories->first()->name }}</span>
                                    @endif
                                </div>
                            </div>
                            <div class="card-body">
                                <h3 class="recipe-title">{{ $product->name }}</h3>
                                <div class="rating-display mb-2">
                                    <div class="stars">
                                        @for($i = 1; $i <= 5; $i++)
                                            <span class="star {{ $i <= $product->averageRating() ? 'active' : '' }}">★</span>
                                        @endfor
                                    </div>
                                    <span class="rating-value">{{ number_format($product->averageRating(), 1) }}</span>
                                </div>
                                
                                <div class="ingredients-preview">
                                    @foreach($product->ingredients->take(2) as $ingredient)
                                        <div class="ingredient-item">
                                            <i class="fas fa-circle"></i>
                                            {{ $ingredient->name }} - {{ $ingredient->quantity }} {{ $ingredient->unit }}
                                        </div>
                                    @endforeach
                                    @if($product->ingredients->count() > 2)
                                        <div class="more-ingredients">
                                            +{{ $product->ingredients->count() - 2 }} ингредиентов
                                        </div>
                                    @endif
                                </div>
                                
                                <div class="d-flex justify-content-between align-items-center mt-3">
                                    <a href="{{ route('product.show', $product->id) }}" class="btn btn-outline-primary">Смотреть рецепт</a>
                                    <form action="{{ route('favorites.remove', $product->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-outline-danger">
                                            <i class="fas fa-heart"></i>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>

    <style>
    .recipe-card {
        transition: transform 0.3s ease;
        border: none;
        border-radius: 15px;
        overflow: hidden;
    }

    .recipe-card:hover {
        transform: translateY(-5px);
    }

    .card-img-wrapper {
        position: relative;
        height: 200px;
    }

    .card-img-top {
        height: 100%;
        object-fit: cover;
    }

    .recipe-title {
        font-size: 1.2rem;
        font-weight: 600;
        margin-bottom: 1rem;
        color: #2c3e50;
    }

    .ingredients-preview {
        padding: 0.5rem 0;
    }

    .ingredient-item {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        margin-bottom: 0.5rem;
        color: #666;
        font-size: 0.9rem;
    }

    .ingredient-item i {
        font-size: 0.5rem;
        color: #3498db;
    }

    .more-ingredients {
        color: #3498db;
        font-size: 0.8rem;
        font-style: italic;
        text-align: right;
    }

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

    .btn-outline-danger {
        color: #dc3545;
        border-color: #dc3545;
    }

    .btn-outline-danger:hover {
        background-color: #dc3545;
        color: white;
    }
    </style>
@endsection 