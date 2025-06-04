@extends('layout.layouts')

@section('title', 'Главная - Рецепты Блюд')

@section('content')
<style>
    body {
        font-family: Arial, sans-serif;
        background-color: #f8f9fa;
        color: #333;
        line-height: 1.6;
    }
    h1 {
        text-align: center;
        margin-top: 20px;
        color: #3498db;
    }
    h3 {
        margin-top: 30px;
        color: #2c3e50;
    }
    .recipe-card {
        background-color: #ffffff;
        border-radius: 8px;
        padding: 20px;
        margin: 20px 0;
        box-shadow: 0 2px 15px rgba(0, 0, 0, 0.1);
        transition: transform 0.3s ease;
    }
    .recipe-card:hover {
        transform: translateY(-5px);
    }
    .recipe-image {
        width: 100%;
        height: 300px;
        object-fit: cover;
        border-radius: 8px;
        margin-bottom: 15px;
    }
    .recipe-title {
        font-size: 1.4rem;
        font-weight: 600;
        color: #2c3e50;
        margin-bottom: 10px;
    }
    .recipe-description {
        color: #666;
        margin-bottom: 15px;
    }
    .recipe-meta {
        display: flex;
        justify-content: space-between;
        color: #666;
        font-size: 0.9rem;
    }
    .footer-text {
        text-align: center;
        margin: 40px 0;
        font-size: 1.2em;
        color: #3498db;
    }
    .admin-actions {
        text-align: right;
        margin-bottom: 20px;
    }
</style>

<div class="container py-5">
    @if (Auth::check() && Auth::user()->role === 'admin')
        <div class="admin-actions mb-4">
            <a href="{{ route('news.create') }}" class="btn btn-success">
                <i class="fas fa-plus"></i> Создать новость
            </a>
        </div>
    @endif

    <h1 class="mb-4">Новости</h1>

    @if($news && count($news) > 0)
        <div class="row">
            @foreach($news as $item)
                <div class="col-md-6 col-lg-4 mb-4">
                    <div class="card h-100">
                        <a href="{{ route('news.show', $item->id) }}" class="text-decoration-none text-dark">
                            @if($item->image)
                                <img src="{{ Storage::url($item->image) }}" 
                                     class="card-img-top" 
                                     alt="{{ $item->title }}" 
                                     style="height: 200px; object-fit: cover;"
                                     onerror="this.onerror=null; this.src='{{ asset('images/no-image.png') }}';">
                            @else
                                <div class="card-img-top bg-light d-flex align-items-center justify-content-center" style="height: 200px;">
                                    <span class="text-muted">Нет изображения</span>
                                </div>
                            @endif
                            <div class="card-body">
                                <h5 class="card-title">{{ $item->title }}</h5>
                                <p class="card-text">{{ Str::limit($item->content, 150) }}</p>
                                <div class="d-flex justify-content-between align-items-center">
                                    <small class="text-muted">
                                        <i class="far fa-clock"></i> {{ $item->created_at->diffForHumans() }}
                                    </small>
                                    <small class="text-muted">
                                        Автор: {{ $item->user->firstname }} {{ $item->user->lastname }}
                                    </small>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="alert alert-info">
            Пока нет доступных новостей.
        </div>
    @endif
</div>
@endsection 