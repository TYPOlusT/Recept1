@extends('layout.layouts')

@section('title', 'Редактировать продукт', 'Admin')

@section('content')
<div class="container">
    @if (session('success'))
        <div class="custom-alert">
            {{ session('success') }}
            <span class="close" onclick="this.parentElement.style.display='none';">&times;</span>
        </div>
    @endif

    @if ($errors->any())
        <div class="custom-alert">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <span class="close" onclick="this.parentElement.style.display='none';">&times;</span>
        </div>
    @endif

    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-lg rounded-lg mt-5">
                <div class="card-body p-5">
                    <a href="{{ route('product.index') }}" class="btn btn-secondary mb-4">Назад</a>
                    <h2 class="text-center mb-4">Редактировать продукт</h2>

                    <form action="{{ route('product.update', $product->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="form-group mb-4">
                            <label for="name" class="form-label">Название продукта:</label>
                            <input type="text" name="name" id="name" value="{{ old('name', $product->name) }}" class="form-control" required>
                        </div>

                      
                        <div class="form-group mb-4">
                            <label for="description" class="form-label">Описание:</label>
                            <textarea name="description" id="description" class="form-control">{{ old('description', $product->description) }}</textarea>
                        </div>

                        <div class="form-group mb-4">
                            <label for="TTH" class="form-label">Пошаговая инструкция приготовления:</label>
                            <input type="text" name="TTH" id="TTH" value="{{ old('TTH', $product->TTH) }}" class="form-control" required>
                        </div>

                        <div class="form-group mb-4">
                            <label class="form-label">Категории:</label>
                            <div class="border p-3">
                                @foreach ($categories as $category)
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" 
                                            name="categories[]" 
                                            value="{{ $category->id }}" 
                                            id="category_{{ $category->id }}"
                                            {{ in_array($category->id, $product->categories->pluck('id')->toArray()) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="category_{{ $category->id }}">
                                            {{ $category->name }}
                                        </label>
                                    </div>
                                @endforeach
                            </div>
                            @error('categories') <div class="alert alert-danger mt-2">{{ $message }}</div> @enderror
                        </div>

                        <div class="form-group mb-4">
                            <label for="country_id" class="form-label">Страна:</label>
                            <select name="country_id" id="country_id" class="form-select" required>
                                <option value="">Выберите страну</option>
                                @foreach ($countries as $country)
                                    <option value="{{ $country->id }}" {{ old('country_id', $product->country_id) == $country->id ? 'selected' : '' }}>
                                        {{ $country->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group mb-4">
                            <label class="form-label">Текущее изображение:</label>
                            <div class="mb-3">
                                <img src="{{ asset($product->img) }}" alt="{{ $product->name }}" style="max-width: 200px; max-height: 200px; object-fit: cover;">
                            </div>
                            <label for="img" class="form-label">Загрузить новое изображение (если необходимо):</label>
                            <input type="file" class="form-control" name="img" id="img">
                        </div>

                        <h5 class="mb-3">Ингредиенты:</h5>
                        <div id="ingredients-container">
                            @foreach ($product->ingredients as $index => $ingredient)
                                <div class="ingredient-item mb-3">
                                    <div class="row">
                                        <div class="col-md-3 mb-2">
                                            <input type="text" name="ingredients[{{ $index }}][name]" value="{{ old('ingredients.'.$index.'.name', $ingredient->name) }}" class="form-control @error('ingredients.'.$index.'.name') is-invalid @enderror" placeholder="Название ингредиента" required>
                                            @error('ingredients.'.$index.'.name')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-md-3 mb-2">
                                            <input type="number" step="0.01" name="ingredients[{{ $index }}][quantity]" value="{{ old('ingredients.'.$index.'.quantity', $ingredient->quantity) }}" class="form-control @error('ingredients.'.$index.'.quantity') is-invalid @enderror" placeholder="Количество" required>
                                            @error('ingredients.'.$index.'.quantity')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-md-3 mb-2">
                                            <input type="text" name="ingredients[{{ $index }}][unit]" value="{{ old('ingredients.'.$index.'.unit', $ingredient->unit) }}" class="form-control @error('ingredients.'.$index.'.unit') is-invalid @enderror" placeholder="Единица измерения" required>
                                            @error('ingredients.'.$index.'.unit')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-md-3 mb-2">
                                            <button type="button" class="btn btn-danger" onclick="removeIngredient(this)">Удалить</button>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <button type="button" class="btn btn-success mb-4" onclick="addIngredient()">Добавить ингредиент</button>

                        <h5 class="mb-3">Пошаговая инструкция:</h5>
                        <div id="recipe-steps-container">
                            @foreach ($product->recipeSteps as $index => $step)
                                <div class="recipe-step-item mb-4">
                                    <div class="form-group mb-3">
                                        <textarea name="recipe_steps[{{ $index }}][instruction]" class="form-control @error('recipe_steps.'.$index.'.instruction') is-invalid @enderror" placeholder="Описание шага" required>{{ old('recipe_steps.'.$index.'.instruction', $step->instruction) }}</textarea>
                                        @error('recipe_steps.'.$index.'.instruction')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    @if($step->image)
                                        <div class="mb-3">
                                            <img src="{{ asset('images/steps/' . $step->image) }}" alt="Шаг {{ $loop->index + 1 }}" style="max-width: 100px; max-height: 100px; object-fit: cover;">
                                            <input type="hidden" name="recipe_steps[{{ $index }}][current_image]" value="{{ $step->image }}">
                                        </div>
                                    @endif
                                    <div class="form-group">
                                        <label class="form-label">Загрузить новое изображение (если необходимо):</label>
                                        <input type="file" class="form-control @error('recipe_steps.'.$index.'.image') is-invalid @enderror" name="recipe_steps[{{ $index }}][image]" accept="image/*">
                                        @error('recipe_steps.'.$index.'.image')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <button type="button" class="btn btn-danger mt-2" onclick="removeRecipeStep(this)">Удалить шаг</button>
                                </div>
                            @endforeach
                        </div>
                        <button type="button" class="btn btn-success mb-4" onclick="addRecipeStep()">Добавить шаг</button>

                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary btn-lg">Обновить продукт</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function addIngredient() {
    const container = document.getElementById('ingredients-container');
    const index = container.children.length;
    
    const newIngredient = document.createElement('div');
    newIngredient.className = 'ingredient-item mb-3';
    newIngredient.innerHTML = `
        <div class="row">
            <div class="col-md-3 mb-2">
                <input type="text" name="ingredients[${index}][name]" class="form-control" placeholder="Название ингредиента" required>
                <div class="invalid-feedback">Пожалуйста, введите название ингредиента</div>
            </div>
            <div class="col-md-3 mb-2">
                <input type="number" step="0.01" name="ingredients[${index}][quantity]" class="form-control" placeholder="Количество" required min="0.01">
                <div class="invalid-feedback">Пожалуйста, введите количество (больше 0)</div>
            </div>
            <div class="col-md-3 mb-2">
                <input type="text" name="ingredients[${index}][unit]" class="form-control" placeholder="Единица измерения" required>
                <div class="invalid-feedback">Пожалуйста, введите единицу измерения</div>
            </div>
            <div class="col-md-3 mb-2">
                <button type="button" class="btn btn-danger" onclick="removeIngredient(this)">Удалить</button>
            </div>
        </div>
    `;
    
    container.appendChild(newIngredient);
}

function removeIngredient(button) {
    if (confirm('Вы уверены, что хотите удалить этот ингредиент?')) {
        button.closest('.ingredient-item').remove();
        reindexIngredients();
    }
}

function reindexIngredients() {
    const container = document.getElementById('ingredients-container');
    const items = container.getElementsByClassName('ingredient-item');
    
    for (let i = 0; i < items.length; i++) {
        const inputs = items[i].getElementsByTagName('input');
        inputs[0].name = `ingredients[${i}][name]`;
        inputs[1].name = `ingredients[${i}][quantity]`;
        inputs[2].name = `ingredients[${i}][unit]`;
    }
}

function addRecipeStep() {
    const container = document.getElementById('recipe-steps-container');
    const index = container.children.length;
    
    const newStep = document.createElement('div');
    newStep.className = 'recipe-step-item mb-4';
    newStep.innerHTML = `
        <div class="form-group mb-3">
            <textarea name="recipe_steps[${index}][instruction]" class="form-control" placeholder="Описание шага" required></textarea>
            <div class="invalid-feedback">Пожалуйста, введите описание шага</div>
        </div>
        <div class="form-group">
            <label class="form-label">Загрузить изображение:</label>
            <input type="file" class="form-control" name="recipe_steps[${index}][image]" accept="image/*">
            <div class="invalid-feedback">Пожалуйста, загрузите изображение в формате jpg, png или gif</div>
        </div>
        <button type="button" class="btn btn-danger mt-2" onclick="removeRecipeStep(this)">Удалить шаг</button>
    `;
    
    container.appendChild(newStep);
}

function removeRecipeStep(button) {
    if (confirm('Вы уверены, что хотите удалить этот шаг?')) {
        button.closest('.recipe-step-item').remove();
        reindexRecipeSteps();
    }
}

function reindexRecipeSteps() {
    const container = document.getElementById('recipe-steps-container');
    const items = container.getElementsByClassName('recipe-step-item');
    
    for (let i = 0; i < items.length; i++) {
        const textarea = items[i].getElementsByTagName('textarea')[0];
        const fileInput = items[i].getElementsByTagName('input')[0];
        textarea.name = `recipe_steps[${i}][instruction]`;
        fileInput.name = `recipe_steps[${i}][image]`;
    }
}

// Добавляем валидацию формы перед отправкой
document.querySelector('form').addEventListener('submit', function(e) {
    const ingredients = document.querySelectorAll('.ingredient-item');
    const steps = document.querySelectorAll('.recipe-step-item');
    
    if (ingredients.length === 0) {
        e.preventDefault();
        alert('Пожалуйста, добавьте хотя бы один ингредиент');
        return;
    }
    
    if (steps.length === 0) {
        e.preventDefault();
        alert('Пожалуйста, добавьте хотя бы один шаг рецепта');
        return;
    }
    
    // Проверяем все поля на заполненность
    const inputs = this.querySelectorAll('input[required], textarea[required]');
    let isValid = true;
    
    inputs.forEach(input => {
        if (!input.value.trim()) {
            input.classList.add('is-invalid');
            isValid = false;
        } else {
            input.classList.remove('is-invalid');
        }
    });
    
    if (!isValid) {
        e.preventDefault();
        alert('Пожалуйста, заполните все обязательные поля');
    }
});
</script>
@endsection
