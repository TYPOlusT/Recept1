@extends('layout.layouts')
@section('title', 'Категория')
@section('content')

<style>
.form-group {
    margin-bottom: 1.5rem;
}

.form-control {
    padding: 0.75rem;
    border-radius: 8px;
    border: 1px solid #ced4da;
    transition: border-color 0.15s ease-in-out;
}

.form-control:focus {
    border-color: #80bdff;
    box-shadow: 0 0 0 0.2rem rgba(0,123,255,.25);
}

label {
    font-weight: 500;
    margin-bottom: 0.5rem;
    color: #495057;
}

.btn {
    padding: 0.5rem 1.5rem;
    border-radius: 6px;
}

.btn-primary {
    background-color: #007bff;
    border-color: #007bff;
}

.alert {
    border-radius: 8px;
    margin-bottom: 1rem;
}

.border {
    border-radius: 8px;
    background-color: #f8f9fa;
}
</style>

<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="content_form mt-4 p-4 border rounded shadow">
            <h2 class="text-center mb-4">Добавление категории</h2>
            @if(session()->has('success'))
            <div class="alert alert-success" role="alert">
                {{ session()->get('success') }}
            </div>
            @endif
            <form action="{{ route('category.store')}}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <label for="name">Название категории</label>
                    <input type="text" name="name" id="name" placeholder="Введите название" class="form-control" required>
                    @error('name') <div class="alert alert-danger mt-2">{{ $message }}</div> @enderror
                </div>
                <div class="form-group">
                    <input type="submit" class="btn btn-primary" value="Добавить">
                </div>
            </form>
        </div>
    </div>
</div>

@endsection