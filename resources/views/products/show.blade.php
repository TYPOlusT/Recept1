@extends('layout.layouts')
@section('title', 'Вкусные Рецепты')
@section('content')
<style>
    .product_item_show {
        background-color: white;
        border-radius: 15px;
        overflow: hidden;
        transition: transform 0.3s ease;
        box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        padding: 2rem;
        margin: 2rem auto;
        max-width: 1200px;
        display: flex;
        flex-direction: row;
        align-items: flex-start;
    }
    
    .product_item_show:hover {
        transform: translateY(-5px);
    }
    
    .content_colm {
        flex-grow: 1;
        padding-left: 2rem;
    }

    .image-container {
        flex-shrink: 0;
        width: 400px;
    }

    .recipe-image {
        border-radius: 15px;
        object-fit: cover;
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        margin: 1rem 0;
        width: 100%;
        height: auto;
    }

    .main-image {
        width: 100%;
        height: 400px;
        object-fit: cover;
    }

    .step-image {
        max-width: 100%;
        height: 500px;
        object-fit: cover;
        margin: 1.5rem 0;
        border-radius: 10px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.15);
    }

    .step-container {
        margin-bottom: 2rem;
        position: relative;
        padding-left: 3rem;
    }

    .step-container::before {
        content: counter(item);
        counter-increment: item;
        position: absolute;
        left: 0;
        top: 0;
        width: 2.5rem;
        height: 2.5rem;
        background-color: var(--primary-color);
        color: white;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: bold;
        font-size: 1.2rem;
    }

    ol {
        counter-reset: item;
        list-style-type: none;
        padding-left: 0;
    }

    .step-text {
        margin-bottom: 1rem;
        padding-top: 0.5rem;
    }
    
    h2 {
        font-size: 2.2rem;
        font-weight: 700;
        color: var(--primary-color);
        margin-bottom: 1.5rem;
    }
    
    h6.text-muted {
        color: var(--dark-color);
        font-size: 1.2rem;
        margin: 1.2rem 0;
        line-height: 1.6;
    }

    ul, ol {
        padding-left: 1.5rem;
        margin: 1.5rem 0;
    }

    li {
        margin-bottom: 1rem;
        color: var(--dark-color);
        line-height: 1.6;
        font-size: 1.1rem;
    }

    .btn {
        border-radius: 25px;
        padding: 0.8rem 1.5rem;
        font-weight: 500;
        transition: all 0.3s ease;
        margin: 0.5rem 0;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(0,0,0,0.2);
    }

    .btn-secondary {
        background-color: var(--dark-color);
        border: none;
        color: white;
    }

    .btn-primary {
        background-color: var(--primary-color);
        border: none;
        color: white;
    }

    .btn-danger {
        background-color: #dc3545;
        border: none;
        color: white;
    }

    .btn-success {
        background-color: var(--secondary-color);
        border: none;
        color: white;
    }

    hr {
        margin: 2rem 0;
        border-color: rgba(0,0,0,0.1);
    }

    .rating-stars {
        display: flex;
        gap: 0.5rem;
        margin: 1rem 0;
        align-items: center;
    }

    .rating-star {
        cursor: pointer;
        font-size: 1.8rem;
        color: #ddd;
        transition: all 0.2s ease;
    }

    .rating-star.active {
        color: #ffd700;
        transform: scale(1.1);
    }

    .rating-star:hover {
        color: #ffd700;
        transform: scale(1.1);
    }

    .average-rating {
        font-size: 1.3rem;
        color: var(--dark-color);
        margin-left: 1.5rem;
        font-weight: 500;
    }

    .badge {
        padding: 0.6rem 1rem;
        font-size: 0.9rem;
        border-radius: 20px;
        margin: 0.3rem;
    }

    .badge.bg-primary {
        background-color: var(--primary-color) !important;
    }

    @media (max-width: 768px) {
        .product_item_show {
            flex-direction: column;
            padding: 1rem;
        }

        .content_colm {
            padding-left: 0;
            margin-top: 1.5rem;
        }

        .main-image {
            max-width: 100%;
            height: 300px;
        }

        .step-image {
            max-width: 100%;
            height: 200px;
        }
    }
</style>

<a href="{{ route('product.index') }}" class="btn btn-secondary mt-3">Назад</a>

<div class="product_item_show mb-4 mt-4">
    <div class="image-container">
        <img src="{{ asset('public/' . $data->img) }}" alt="{{ $data->name }}" class="recipe-image main-image">
    </div>
    <div class="content_colm">
        <h2>{{ $data->name }}</h2>
        <h6 class="text-muted">Описание: {{ $data->description }}</h6>
        
        <div class="rating-section">
            <h6 class="text-muted">Рейтинг рецепта:</h6>
            <div class="d-flex align-items-center">
                <div class="rating-stars">
                    @if(Auth::check())
                        <form action="{{ route('product.rate', $data->id) }}" method="POST" id="ratingForm">
                            @csrf
                            @for($i = 1; $i <= 5; $i++)
                                <span class="rating-star" data-rating="{{ $i }}" onclick="submitRating({{ $i }})">★</span>
                            @endfor
                            <input type="hidden" name="rating" id="ratingInput">
                        </form>
                    @else
                        @for($i = 1; $i <= 5; $i++)
                            <span class="rating-star">★</span>
                        @endfor
                    @endif
                </div>
                <span class="average-rating">
                    Средняя оценка: {{ number_format($data->averageRating, 1) }} / 5
                </span>
            </div>
        </div>

        <hr>
        <div class="mb-3">
            <strong>Категории:</strong>
            <div class="mt-2">
                @foreach($data->categories as $category)
                    <span class="badge bg-primary me-2">{{ $category->name }}</span>
                @endforeach
            </div>
        </div>
        <p>Страна: {{ $data->country }}</p>
        
        <h6 class="text-muted">Ингредиенты:</h6>
        <ul>
            @foreach ($data->ingredients as $ingredient)
                <li>{{ $ingredient->quantity }} {{ $ingredient->unit }} {{ $ingredient->name }}</li>
            @endforeach
        </ul>

        <h6 class="text-muted">Пошаговые инструкции:</h6>
        <ol>
            @foreach ($data->recipeSteps as $step)
                <li class="step-container">
                    <div class="step-text">{{ $step->instruction }}</div>
                    @if($step->image)
                        <img src="{{ asset('public/' . $step->image) }}" alt="Шаг {{ $loop->index + 1 }}" class="recipe-image step-image">
                    @endif
                </li>
            @endforeach
        </ol>

        @if (Auth::check() && (Auth::user()->hasRole('admin') || Auth::user()->id === $data->user_id))
        <div class="d-flex gap-2 mt-4">
            <a href="{{ route('product.edit', $data->id) }}" class="btn btn-primary">Редактировать</a>
            <form action="{{ route('product.destroy', $data->id) }}" method="POST" onsubmit="return confirm('Вы уверены, что хотите удалить этот рецепт?');" class="d-inline">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger">Удалить</button>
            </form>
        </div>
        @endif

        @if(Auth::check())
            @if(Auth::user()->favoriteProducts->contains($data->id))
                <form action="{{ route('favorites.remove', $data->id) }}" method="POST" class="mt-3">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">
                        <i class="fas fa-heart"></i> Удалить из избранного
                    </button>
                </form>
            @else
                <form action="{{ route('favorites.add', $data->id) }}" method="POST" class="mt-3">
                    @csrf
                    <button type="submit" class="btn btn-outline-danger">
                        <i class="far fa-heart"></i> Добавить в избранное
                    </button>
                </form>
            @endif
        @endif
    </div>
</div>

@if(Auth::check())
<script>
    function submitRating(rating) {
        document.getElementById('ratingInput').value = rating;
        document.getElementById('ratingForm').submit();
    }

    // Highlight stars based on user's previous rating
    document.addEventListener('DOMContentLoaded', function() {
        const stars = document.querySelectorAll('.rating-star');
        const userRating = {{ $data->ratings->where('user_id', Auth::id())->first()->rating ?? 0 }};
        
        stars.forEach((star, index) => {
            if (index < userRating) {
                star.classList.add('active');
            }
        });
    });
</script>
@endif
@endsection