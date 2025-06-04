@extends('layout.layouts')
@section('title', 'Добавление рецепта')
@section('content')

<style>
:root {
    --primary-color: #4CAF50;
    --primary-hover: #45a049;
    --secondary-color: #6c757d;
    --danger-color: #dc3545;
    --border-radius: 12px;
    --box-shadow: 0 2px 15px rgba(0, 0, 0, 0.1);
}

header {
    background-color: #fff;
    box-shadow: var(--box-shadow);
    padding: 1rem 0;
    position: sticky;
    top: 0;
    z-index: 1000;
}

.navbar {
    padding: 0.5rem 2rem;
}

.navbar-brand {
    font-size: 1.5rem;
    font-weight: 700;
    color: var(--primary-color) !important;
    text-decoration: none;
    transition: all 0.3s ease;
}

.navbar-brand:hover {
    transform: translateY(-1px);
}

.nav-link {
    color: #2c3e50 !important;
    font-weight: 500;
    padding: 0.5rem 1rem !important;
    margin: 0 0.2rem;
    border-radius: var(--border-radius);
    transition: all 0.3s ease;
}

.nav-link:hover {
    background-color: #f8f9fa;
    color: var(--primary-color) !important;
}

.nav-link.active {
    background-color: var(--primary-color);
    color: #fff !important;
}

.navbar-toggler {
    border: none;
    padding: 0.5rem;
    border-radius: var(--border-radius);
    transition: all 0.3s ease;
}

.navbar-toggler:focus {
    box-shadow: none;
    outline: none;
}

.navbar-toggler-icon {
    background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 30 30'%3e%3cpath stroke='rgba(76, 175, 80, 1)' stroke-linecap='round' stroke-miterlimit='10' stroke-width='2' d='M4 7h22M4 15h22M4 23h22'/%3e%3c/svg%3e");
}
body {
    background-color: #f8f9fa;
}

.form-group {
    margin-bottom: 1.8rem;
}

.form-control {
    padding: 0.85rem;
    border-radius: var(--border-radius);
    border: 2px solid #e9ecef;
    transition: all 0.3s ease;
    font-size: 1rem;
    background-color: #fff;
}

.form-control:focus {
    border-color: var(--primary-color);
    box-shadow: 0 0 0 0.2rem rgba(76, 175, 80, 0.15);
}

.form-control-file {
    padding: 0.75rem 0;
}

label {
    font-weight: 600;
    margin-bottom: 0.7rem;
    color: #2c3e50;
    font-size: 1.05rem;
}

.btn {
    padding: 0.7rem 1.8rem;
    border-radius: var(--border-radius);
    font-weight: 600;
    transition: all 0.3s ease;
    text-transform: uppercase;
    font-size: 0.9rem;
    letter-spacing: 0.5px;
}

.btn-primary {
    background-color: var(--primary-color);
    border-color: var(--primary-color);
}

.btn-primary:hover {
    background-color: var(--primary-hover);
    border-color: var(--primary-hover);
    transform: translateY(-1px);
}

.btn-secondary {
    background-color: var(--secondary-color);
    border-color: var(--secondary-color);
}

.btn-secondary:hover {
    background-color: #5a6268;
    border-color: #5a6268;
    transform: translateY(-1px);
}

.btn-danger {
    background-color: var(--danger-color);
    border-color: var(--danger-color);
}

.btn-danger:hover {
    background-color: #c82333;
    border-color: #bd2130;
    transform: translateY(-1px);
}

.alert {
    border-radius: var(--border-radius);
    margin-bottom: 1.5rem;
    padding: 1rem 1.5rem;
    border: none;
    box-shadow: var(--box-shadow);
}

.alert-success {
    background-color: #d4edda;
    color: #155724;
}

.alert-danger {
    background-color: #f8d7da;
    color: #721c24;
}

.form-row {
    display: flex;
    gap: 1.2rem;
    margin-bottom: 1.2rem;
    align-items: center;
}

.border {
    border-radius: var(--border-radius);
    background-color: #fff;
    box-shadow: var(--box-shadow);
    border: none !important;
    padding: 1.5rem !important;
}

select.form-control {
    height: calc(1.5em + 1.7rem + 2px);
    padding-top: 0.6rem;
    padding-bottom: 0.6rem;
    cursor: pointer;
}

.category-checkbox {
    margin-bottom: 0.8rem;
    padding: 0.5rem;
    border-radius: 8px;
    transition: background-color 0.2s ease;
}

.category-checkbox:hover {
    background-color: #f8f9fa;
}

.category-checkbox input[type="checkbox"] {
    margin-right: 0.8rem;
    width: 18px;
    height: 18px;
    cursor: pointer;
}

.category-checkbox label {
    margin-bottom: 0;
    cursor: pointer;
    font-weight: 500;
    color: #495057;
}

.categories-container {
    max-height: 250px;
    overflow-y: auto;
    padding: 1.2rem;
    border: 2px solid #e9ecef;
    border-radius: var(--border-radius);
    background-color: #fff;
    box-shadow: var(--box-shadow);
}
.categories-container::-webkit-scrollbar {
    width: 8px;
}

.categories-container::-webkit-scrollbar-track {
    background: #f1f1f1;
    border-radius: 4px;
}

.categories-container::-webkit-scrollbar-thumb {
    background: #888;
    border-radius: 4px;
}

.categories-container::-webkit-scrollbar-thumb:hover {
    background: #555;
}
#categorySearch {
    margin-bottom: 1rem;
    padding: 0.8rem 1rem;
    border: 2px solid #e9ecef;
    border-radius: var(--border-radius);
    font-size: 1rem;
    transition: all 0.3s ease;
}
#categorySearch:focus {
    border-color: var(--primary-color);
    box-shadow: 0 0 0 0.2rem rgba(76, 175, 80, 0.15);
}
h2 {
    color: #2c3e50;
    font-weight: 700;
    margin-bottom: 2rem;
    text-align: center;
}
h5 {
    color: #2c3e50;
    font-weight: 600;
    margin-top: 2rem;
    margin-bottom: 1.5rem;
    padding-bottom: 0.5rem;
    border-bottom: 2px solid #e9ecef;
}
textarea.form-control {
    min-height: 100px;
    resize: vertical;
}
input[type="file"] {
    padding: 0.5rem;
    border: 2px dashed #e9ecef;
    border-radius: var(--border-radius);
    cursor: pointer;
    transition: all 0.3s ease;
}

input[type="file"]:hover {
    border-color: var(--primary-color);
}
.col-md-8 {
    background-color: #fff;
    padding: 2rem;
    border-radius: var(--border-radius);
    box-shadow: var(--box-shadow);
    margin-top: 2rem;
    margin-bottom: 2rem;
}
input[type="submit"] {
    padding: 1rem 2.5rem;
    font-size: 1.1rem;
    margin-top: 2rem;
}
@keyframes fadeIn {
    from { opacity: 0; transform: translateY(10px); }
    to { opacity: 1; transform: translateY(0); }
}
.form-group {
    animation: fadeIn 0.5s ease-out;
}
</style>

<div class="row justify-content-center">
    <div class="col-md-8 mt-4">
        @if(session()->has('success'))
            <div class="alert alert-success">
                {{ session()->get('success') }}
            </div>
        @endif

        @if($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
<br>   </br>

        <form action="{{ route('product.store') }}" method="post" enctype="multipart/form-data">
            @csrf
            <h2 class="text-center mb-4">Добавление рецепта</h2>
            
            <div class="form-group">
                <label for="name">Название рецепта</label>
                <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" id="name" placeholder="Введите название" required value="{{ old('name') }}">
                @error('name') 
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="description">Описание</label>
                <textarea class="form-control @error('description') is-invalid @enderror" name="description" id="description" placeholder="Введите описание" required rows="3">{{ old('description') }}</textarea>
                @error('description') 
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="TTH">Пошаговая инструкция приготовления</label>
                <textarea class="form-control @error('TTH') is-invalid @enderror" name="TTH" id="TTH" placeholder="Опишите каждый этап приготовления здесь…" required rows="4">{{ old('TTH') }}</textarea>
                @error('TTH') 
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label>Категории</label>
                <input type="text" class="form-control mb-2" id="categorySearch" placeholder="Поиск категорий...">
                <div class="categories-container @error('categories') is-invalid @enderror">
                    @foreach ($category as $categ)
                        <div class="category-checkbox">
                            <input type="checkbox" name="categories[]" value="{{ $categ->id }}" id="category_{{ $categ->id }}" {{ in_array($categ->id, old('categories', [])) ? 'checked' : '' }}>
                            <label for="category_{{ $categ->id }}">{{ $categ->name }}</label>
                        </div>
                    @endforeach
                </div>
                @error('categories') 
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

           
            <div class="form-group">
                <label for="country_id">Национальные кухни</label>
                <select class="form-control @error('country_id') is-invalid @enderror" name="country_id" id="country_id" required>
                    <option value="" disabled selected>Выберите страну</option>
                    @foreach ($countries as $country)
                        <option value="{{ $country->id }}" {{ old('country_id') == $country->id ? 'selected' : '' }}>
                            {{ $country->name }}
                        </option>
                    @endforeach
                </select>
                @error('country_id') 
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <!-- Изображение -->
            <div class="form-group">
                <label for="img">Изображение</label>
                <input type="file" class="form-control-file @error('img') is-invalid @enderror" name="img" id="img" required>
                @error('img') 
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <h5 class="mt-4 mb-3">Ингредиенты</h5>
            <div id="ingredients">
                <div class="form-row">
                    <div class="col">
                        <input type="text" class="form-control @error('ingredients.0.name') is-invalid @enderror" name="ingredients[0][name]" placeholder="Название ингредиента" required value="{{ old('ingredients.0.name') }}">
                        @error('ingredients.0.name') 
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col">
                        <input type="number" step="0.01" class="form-control @error('ingredients.0.quantity') is-invalid @enderror" name="ingredients[0][quantity]" placeholder="Количество" required value="{{ old('ingredients.0.quantity') }}">
                        @error('ingredients.0.quantity') 
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col">
                        <input type="text" class="form-control @error('ingredients.0.unit') is-invalid @enderror" name="ingredients[0][unit]" placeholder="Единица измерения" required value="{{ old('ingredients.0.unit') }}">
                        @error('ingredients.0.unit') 
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>
            <button type="button" class="btn btn-secondary mt-2" id="add-ingredient">Добавить ингредиент</button>

            <h5 class="mt-4 mb-3">Шаги рецепта</h5>
            <div id="recipe-steps">
                <div class="form-group">
                    <div class="form-group border p-3 mb-3">
                        <textarea class="form-control mb-2 @error('recipe_steps.0.instruction') is-invalid @enderror" name="recipe_steps[0][instruction]" placeholder="Инструкция" required rows="3">{{ old('recipe_steps.0.instruction') }}</textarea>
                        @error('recipe_steps.0.instruction') 
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div class="mt-2">
                            <label>Фото для шага</label>
                            <input type="file" class="form-control-file @error('recipe_steps.0.image') is-invalid @enderror" name="recipe_steps[0][image]" accept="image/jpeg,image/png,image/jpg,image/gif,image/webp">
                            @error('recipe_steps.0.image') 
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <input type="hidden" name="recipe_steps[0][step_number]" value="1">
                        </div>
                    </div>
                </div>
            </div>
            <button type="button" class="btn btn-secondary" id="add-step">Добавить шаг</button>

            <div class="text-center mt-4">
                <input type="submit" class="btn btn-primary btn-lg" value="Добавить рецепт">
            </div>
        </form>
    </div>
</div>

@section('scripts')
<script>
    let ingredientIndex = 1;
    let stepIndex = 1;

    // Функция поиска категорий
    document.getElementById('categorySearch').addEventListener('input', function(e) {
        const searchText = e.target.value.toLowerCase();
        const categories = document.querySelectorAll('.category-checkbox');
        
        categories.forEach(category => {
            const label = category.querySelector('label').textContent.toLowerCase();
            if (label.includes(searchText)) {
                category.style.display = '';
            } else {
                category.style.display = 'none';
            }
        });
    });

    // Функция для добавления ингредиента
    function addIngredient() {
        const ingredientsDiv = document.getElementById('ingredients');
        const newRow = document.createElement('div');
        newRow.className = 'form-row mt-2';
        newRow.innerHTML = `
            <div class="col">
                <input type="text" class="form-control" name="ingredients[${ingredientIndex}][name]" placeholder="Название ингредиента" required>
            </div>
            <div class="col">
                <input type="number" step="0.01" class="form-control" name="ingredients[${ingredientIndex}][quantity]" placeholder="Количество" required>
            </div>
            <div class="col">
                <input type="text" class="form-control" name="ingredients[${ingredientIndex}][unit]" placeholder="Единица измерения" required>
            </div>
            <div class="col-auto">
                <button type="button" class="btn btn-danger remove-ingredient">Удалить</button>
            </div>
        `;
        ingredientsDiv.appendChild(newRow);
        ingredientIndex++;

        // Добавляем обработчик для новой кнопки удаления
        newRow.querySelector('.remove-ingredient').addEventListener('click', function() {
            this.closest('.form-row').remove();
        });
    }

    // Функция для добавления шага
    function addStep() {
        const stepsDiv = document.getElementById('recipe-steps');
        const newStep = document.createElement('div');
        newStep.className = 'form-group mt-3';
        newStep.innerHTML = `
            <div class="form-group border p-3 mb-3">
                <textarea class="form-control mb-2" name="recipe_steps[${stepIndex}][instruction]" placeholder="Инструкция" required rows="3"></textarea>
                <div class="mt-2">
                    <label>Фото для шага</label>
                    <input type="file" class="form-control-file" name="recipe_steps[${stepIndex}][image]" accept="image/jpeg,image/png,image/jpg,image/gif,image/webp">
                    <input type="hidden" name="recipe_steps[${stepIndex}][step_number]" value="${stepIndex + 1}">
                </div>
                <button type="button" class="btn btn-danger mt-2 remove-step">Удалить шаг</button>
            </div>
        `;
        stepsDiv.appendChild(newStep);
        stepIndex++;

        // Добавляем обработчик для кнопки удаления
        newStep.querySelector('.remove-step').addEventListener('click', function() {
            this.closest('.form-group').remove();
        });
    }

    // Инициализация при загрузке страницы
    document.addEventListener('DOMContentLoaded', function() {
        // Добавляем обработчик для кнопки добавления ингредиента
        const addIngredientButton = document.getElementById('add-ingredient');
        if (addIngredientButton) {
            addIngredientButton.addEventListener('click', addIngredient);
        }

        // Добавляем обработчик для кнопки добавления шага
        const addStepButton = document.getElementById('add-step');
        if (addStepButton) {
            addStepButton.addEventListener('click', addStep);
        }
    });
</script>
@endsection