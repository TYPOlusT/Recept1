@extends('layout.layouts')

@section('title', $news->title)

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm">
                @if($news->image)
                    <img src="{{ asset('storage/' . $news->image) }}" class="card-img-top" alt="{{ $news->title }}" style="height: 400px; object-fit: cover;">
                @endif
                <div class="card-body">
                    <h1 class="card-title mb-4">{{ $news->title }}</h1>
                    
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <small class="text-muted">
                            <i class="far fa-clock"></i> {{ $news->created_at->format('d.m.Y H:i') }}
                        </small>
                        <small class="text-muted">
                            Автор: {{ $news->user->firstname }} {{ $news->user->lastname }}
                        </small>
                    </div>

                    <div class="card-text mb-4">
                        {!! nl2br(e($news->content)) !!}
                    </div>

                    @if (Auth::check() && Auth::user()->role === 'admin')
                        <div class="d-flex justify-content-end gap-2">
                            <a href="{{ route('news.edit', $news->id) }}" class="btn btn-primary">
                                <i class="fas fa-edit"></i> Редактировать
                            </a>
                            <form action="{{ route('news.destroy', $news->id) }}" method="POST" onsubmit="return confirm('Вы уверены, что хотите удалить эту новость?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">
                                    <i class="fas fa-trash"></i> Удалить
                                </button>
                            </form>
                        </div>
                    @endif

                    <div class="mt-4">
                        <a href="{{ route('news.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> Назад к списку новостей
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 