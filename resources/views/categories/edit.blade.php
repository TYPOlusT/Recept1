@extends('layout.layouts')
@section('title', 'Категория')
@section('content')
<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="content_form mt-4 p-4 border rounded shadow">
        <h2 class="text-center mb-4">Редактирование категории</h2>
        <form action="{{ route('category.update', $category) }}" method="post" enctype="multipart/form-data">
            @csrf
            @method('PATCH')
            <div class="form-group">
                <label for="name">Название товара:</label>
                <input type="text" id="name" name="name" class="form-control" value="{{ old('name', $category->name) }}">
            </div>
            <div class="form-group mb-3">
                <input type="submit" class="btn btn-primary" value="Изменить">
            </div>
        </form>
        </div>
    </div>
</div>
@endsection