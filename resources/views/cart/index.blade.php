@extends('layout.layouts')
@section('title', 'Корзина')

@section('content')
    <div class="container">
        <h1 class="text-center mb-4">Ваше избранное</h1>

        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Наименование</th>
                        <th>Действия</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($cart as $key => $item)
                        <tr>
                            <td>{{ $item['name'] }}</td>
                            <td>
                                <a href="{{ route('product.show', $item['id']) }}" class="btn btn-info btn-sm">Подробнее</a>
                                <form action="{{ route('cart.remove', $item['id']) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm">Удалить</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <?php $total = 0; ?>
                    <tr>
                        <th></th>
                        <th></th>
                    </tr>
                </tfoot>
            </table>
        </div>

        <div class="text-center mt-4">
            <a href="{{ route('product.index') }}" class="btn btn-primary">Вернуться в каталог</a>
        </div>
    </div>
@endsection

<style>
.container {
    max-width: 900px;
    margin: 2rem auto;
}

h1 {
    color: #2c3e50;
    font-weight: 600;
    margin-bottom: 2rem;
}

.table-responsive {
    background: white;
    border-radius: 15px;
    box-shadow: 0 0 20px rgba(0,0,0,0.1);
    padding: 1rem;
}

.table {
    margin-bottom: 0;
}

.table thead th {
    background-color: #3498db;
    color: white;
    border: none;
    padding: 15px;
    font-weight: 500;
}

.table tbody td {
    padding: 15px;
    border-bottom: 1px solid #eee;
    color: #444;
}

.table tbody tr:hover {
    background-color: #f8f9fa;
    transition: background-color 0.3s ease;
}

.table tbody tr:last-child td {
    border-bottom: none;
}

.btn-primary {
    background-color: #3498db;
    border: none;
    padding: 12px 30px;
    font-size: 1.1rem;
    border-radius: 30px;
    transition: all 0.3s ease;
}

.btn-primary:hover {
    background-color: #2980b9;
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(52, 152, 219, 0.3);
}

.btn-info {
    background-color: #17a2b8;
    border: none;
    color: white;
    padding: 8px 16px;
    border-radius: 20px;
    transition: all 0.3s ease;
}

.btn-info:hover {
    background-color: #138496;
    transform: translateY(-1px);
    box-shadow: 0 3px 10px rgba(23, 162, 184, 0.3);
}

.btn-danger {
    background-color: #dc3545;
    border: none;
    color: white;
    padding: 8px 16px;
    border-radius: 20px;
    transition: all 0.3s ease;
}

.btn-danger:hover {
    background-color: #c82333;
    transform: translateY(-1px);
    box-shadow: 0 3px 10px rgba(220, 53, 69, 0.3);
}
</style>