@extends('layout.layouts')

@section('title', 'Новости')

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
    .news-card {
        background-color: #ffffff;
        border-radius: 8px;
        padding: 20px;
        margin: 20px 0;
        box-shadow: 0 2px 15px rgba(0, 0, 0, 0.1);
        transition: transform 0.3s ease;
    }
    .news-card:hover {
        transform: translateY(-5px);
    }
    .news-image {
        width: 100%;
        height: 300px;
        object-fit: cover;
        border-radius: 8px;
        margin-bottom: 15px;
    }
    .news-title {
        font-size: 1.4rem;
        font-weight: 600;
        color: #2c3e50;
        margin-bottom: 10px;
    }
    .news-content {
        color: #666;
        margin-bottom: 15px;
    }
    .news-meta {
        display: flex;
        justify-content: space-between;
        color: #666;
        font-size: 0.9rem;
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
                    <div class="news-card">
                        @if($item->image)
                            <img src="{{ asset('storage/' . $item->image) }}" class="news-image" alt="{{ $item->title }}">
                        @endif
                        <div class="card-body">
                            <h5 class="news-title">{{ $item->title }}</h5>
                            <p class="news-content">{{ Str::limit($item->content, 150) }}</p>
                            <div class="news-meta">
                                <small class="text-muted">
                                    <i class="far fa-clock"></i> {{ $item->created_at->diffForHumans() }}
                                </small>
                                <small class="text-muted">
                                    Автор: {{ $item->user->firstname }} {{ $item->user->lastname }}
                                </small>
                            </div>
                        </div>
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
