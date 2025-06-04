@extends('layout.layouts')
@section('title', 'Добавить новый рецепт')
@section('content')
@if (Auth::check() && (Auth::user()->hasRole('admin') || Auth::user()->hasRole('user')))
    <a href="{{ route('product.create') }}" class="btn btn-custom mt-3">Добавить новый рецепт</a>
@endif

<div class="filters-section mt-4 mb-4">
    <form action="{{ route('product.index') }}" method="GET">
        <div class="row justify-content-center">
            <div class="col-md-8">
               
                <div class="form-group mb-3">
                    <input type="text" 
                           class="form-control" 
                           name="search" 
                           placeholder="Поиск по названию блюда"
                           value="{{ request()->get('search') }}">
                </div>

                <div class="filter-group">
                    <label class="filter-label">Категории блюд</label>
                    <div class="category-checkboxes border p-3">
                        <div class="row">
                            @foreach ($data->categories as $category)
                                <div class="col-md-4 mb-2">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" 
                                            name="category_ids[]" 
                                            value="{{ $category->id }}"
                                            id="category_{{ $category->id }}"
                                            {{ in_array($category->id, request()->get('category_ids', [])) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="category_{{ $category->id }}">
                                            {{ $category->name }}
                                        </label>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-12 mt-3 text-center">
                <button type="submit" class="btn btn-primary">Применить фильтры</button>
                <a href="{{ route('product.index') }}" class="btn btn-secondary ml-2">Сбросить</a>
            </div>
        </div>
    </form>
</div>

<div class="row mt-4">
    @foreach($data->products as $prod)
    <div class="col-md-3 col-sm-6 mb-4">
        <div class="card h-100 recipe-card shadow-sm">
            <div class="card-img-wrapper">
                <img src="{{ asset('public/' . $prod->img) }}" class="card-img-top" alt="{{ $prod->name }}">
                <div class="card-img-overlay d-flex align-items-end">
                    @if($prod->categories->isNotEmpty())
                        <span class="badge bg-light text-dark p-2">{{ $prod->categories->first()->name }}</span>
                    @endif
                </div>
            </div>
            <div class="card-body">
                <h3 class="recipe-title">{{ $prod->name }}</h3>
                <div class="creator-info mb-2">
                    <i class="fas fa-user"></i> Создал: {{ $prod->user->firstname ?? '' }} {{ $prod->user->lastname ?? '' }}
                </div>
                
                <div class="rating-display mb-2">
                    <div class="stars">
                        @for($i = 1; $i <= 5; $i++)
                            <span class="star {{ $i <= $prod->averageRating() ? 'active' : '' }}">★</span>
                        @endfor
                    </div>
                    <span class="rating-value">{{ number_format($prod->averageRating(), 1) }}</span>
                </div>
                
                <div class="ingredients-preview">
                    @foreach($prod->ingredients->take(2) as $ingredient)
                        <div class="ingredient-item">
                            <i class="fas fa-circle"></i>
                            {{ $ingredient->name }} - {{ $ingredient->quantity }} {{ $ingredient->unit }}
                        </div>
                    @endforeach
                    @if($prod->ingredients->count() > 2)
                        <div class="more-ingredients">
                            +{{ $prod->ingredients->count() - 2 }} ингредиентов
                        </div>
                    @endif
                </div>
                
                <a href="{{ route('product.show', $prod->id) }}" class="btn btn-outline-primary w-100 mt-3">Смотреть рецепт</a>
            </div>
        </div>
    </div>
    @endforeach
</div>

<style>
.filters-section {
    background: white;
    padding: 2rem;
    border-radius: 15px;
    box-shadow: 0 2px 15px rgba(0,0,0,0.05);
}

.filter-group {
    margin-bottom: 1rem;
}

.filter-label {
    display: block;
    margin-bottom: 0.5rem;
    color: #2c3e50;
    font-weight: 600;
    font-size: 0.9rem;
}

.custom-select {
    border: 2px solid #e9ecef;
    border-radius: 10px;
    padding: 0.5rem;
    font-size: 0.9rem;
    transition: all 0.3s ease;
    color: #2c3e50;
    background-color: white;
    height: auto;
    line-height: 1.2;
}

.custom-select:focus {
    border-color: var(--primary-color);
    box-shadow: 0 0 0 0.2rem rgba(255,107,107,0.25);
}

.custom-select option {
    color: #2c3e50;
    background-color: white;
    padding: 0.5rem;
}

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

.btn-outline-primary {
    border-color: #3498db;
    color: #3498db;
}

.btn-outline-primary:hover {
    background-color: #3498db;
    color: white;
}

.badge {
    font-size: 0.8rem;
    backdrop-filter: blur(5px);
    background-color: rgba(255, 255, 255, 0.9) !important;
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

.creator-info {
    color: #666;
    font-size: 0.9rem;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.creator-info i {
    color: #3498db;
}
</style>

@endsection
