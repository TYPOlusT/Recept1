@extends('layout.layouts')
@section('title', 'Категория')
@section('content')
@if (Auth::check() && Auth::user()->hasRole('admin')) 
<a href="{{ route('category.create') }}" class="btn btn-primary mt-3">Добавить новую категорию</a>
@endif
<div class="row mt-4">
    @foreach ($categories as $categ)
    <div class="col-md-4 mb-4">
        <div class="card category_box">
            <div class="card-body">
                <h4 class="card-title">
                    {{ $categ->name }}
                </h4>
                @if (Auth::check() && Auth::user()->hasRole('admin')) 
                <div class="d-flex justify-content-between">
                    <a href="{{ route('category.edit', $categ->id) }}" class="btn btn-primary">Редактировать</a>
                    <form action="{{ route('category.destroy', $categ->id) }}" method="POST" onsubmit="return confirm('Вы уверены, что хотите удалить эту категорию?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Удалить</button>
                    </form>
                </div>
                @endif
            </div>
        </div>
    </div>
    @endforeach
</div>

@endsection
