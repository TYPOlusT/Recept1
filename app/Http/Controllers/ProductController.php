<?php

namespace App\Http\Controllers;

use App\Models\Country;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use App\Models\Ingredient;
use App\Models\RecipeStep;
use App\Models\Rating;
use Illuminate\Support\Facades\Schema;

class ProductController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except(['index', 'show']);
    }

    public function index(Request $request)
    {
        $search = $request->input('search');
        $categoryIds = $request->input('category_ids', []);

        $query = Product::with(['categories', 'ingredients', 'ratings', 'user']);

        // Apply search filter
        if ($search) {
            $query->where('name', 'like', "%{$search}%");
        }

        // Apply category filters
        if (!empty($categoryIds)) {
            $query->whereHas('categories', function ($query) use ($categoryIds) {
                $query->whereIn('categories.id', $categoryIds);
            });
        }

        $products = $query->paginate(12);
        $categories = Category::all();

        $data = (object) [
            'products' => $products,
            'categories' => $categories,
            'search' => $search,
            'category_ids' => $categoryIds,
        ];

        return view('products.products')->with(['data' => $data]);
    }


    public function create()
    {
        $categories = Category::all();
        $countries = Country::all();
        return view('products.create')->with(['category' => $categories])->with(['countries' => $countries]);
    }


    public function store(Request $request)
    {
        \Log::info('Starting recipe creation', ['request' => $request->all()]);

        // Валидация входящих данных
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255', 'min:3'],
            'description' => ['required', 'string', 'max:1000', 'min:10'],
            'TTH' => ['required', 'string', 'min:20'],
            'img' => ['required', 'file', 'mimes:jpg,jpeg,png', 'max:5120'], // max 5MB
            'categories' => ['required', 'array', 'min:1'],
            'categories.*' => ['exists:categories,id'],
            'country_id' => ['required', 'exists:countries,id'],
            'ingredients' => ['required', 'array', 'min:1'],
            'ingredients.*.name' => ['required', 'string', 'max:100'],
            'ingredients.*.quantity' => ['required', 'numeric', 'min:0.01'],
            'ingredients.*.unit' => ['required', 'string', 'max:20'],
            'recipe_steps' => ['required', 'array', 'min:1'],
            'recipe_steps.*.instruction' => ['required', 'string', 'min:10'],
            'recipe_steps.*.image' => ['nullable', 'file', 'mimes:jpg,jpeg,png', 'max:5120'], // max 5MB
        ], [
            'name.required' => 'Пожалуйста, введите название рецепта',
            'name.min' => 'Название рецепта должно содержать минимум 3 символа',
            'name.max' => 'Название рецепта не должно превышать 255 символов',
            
            'description.required' => 'Пожалуйста, введите описание рецепта',
            'description.min' => 'Описание должно содержать минимум 10 символов',
            'description.max' => 'Описание не должно превышать 1000 символов',
            
            'TTH.required' => 'Пожалуйста, введите пошаговую инструкцию',
            'TTH.min' => 'Инструкция должна содержать минимум 20 символов',
            
            'img.required' => 'Пожалуйста, загрузите изображение рецепта',
            'img.mimes' => 'Изображение должно быть в формате jpg, jpeg или png',
            'img.max' => 'Размер изображения не должен превышать 5MB',
            
            'categories.required' => 'Пожалуйста, выберите хотя бы одну категорию',
            'categories.min' => 'Выберите хотя бы одну категорию',
            
            'country_id.required' => 'Пожалуйста, выберите страну',
            'country_id.exists' => 'Выбранная страна не существует',
            
            'ingredients.required' => 'Пожалуйста, добавьте хотя бы один ингредиент',
            'ingredients.min' => 'Добавьте хотя бы один ингредиент',
            'ingredients.*.name.required' => 'Введите название ингредиента',
            'ingredients.*.name.max' => 'Название ингредиента не должно превышать 100 символов',
            'ingredients.*.quantity.required' => 'Введите количество ингредиента',
            'ingredients.*.quantity.numeric' => 'Количество должно быть числом',
            'ingredients.*.quantity.min' => 'Количество должно быть больше 0',
            'ingredients.*.unit.required' => 'Введите единицу измерения',
            'ingredients.*.unit.max' => 'Единица измерения не должна превышать 20 символов',
            
            'recipe_steps.required' => 'Пожалуйста, добавьте хотя бы один шаг рецепта',
            'recipe_steps.min' => 'Добавьте хотя бы один шаг рецепта',
            'recipe_steps.*.instruction.required' => 'Введите инструкцию для шага',
            'recipe_steps.*.instruction.min' => 'Инструкция должна содержать минимум 10 символов',
            'recipe_steps.*.image.mimes' => 'Изображение шага должно быть в формате jpg, jpeg или png',
            'recipe_steps.*.image.max' => 'Размер изображения шага не должен превышать 5MB',
        ]);
        
        if ($validator->fails()) {
            \Log::error('Validation failed', ['errors' => $validator->errors()->toArray()]);
            return redirect()->route('product.create')
                ->withErrors($validator)
                ->withInput();
        }
    
        try {
            \Log::info('Starting file upload');
            // Сохранение изображения продукта
            if ($request->hasFile('img')) {
                $image = $request->file('img');
                $image_name = time() . '.' . $image->getClientOriginalExtension();
                $path = 'images/products/';
                
                // Создаем директорию, если она не существует
                if (!file_exists(public_path($path))) {
                    mkdir(public_path($path), 0777, true);
                }
                
                $image->move(public_path($path), $image_name);
                $full_path = $path . $image_name;
                \Log::info('Main image uploaded', ['path' => $full_path]);
            } else {
                \Log::error('No main image uploaded');
                return redirect()->back()->withErrors(['img' => 'Ошибка при загрузке изображения'])->withInput();
            }
        
            \Log::info('Creating product record');
            // Создание продукта
            $product = Product::create([
                'name' => $request->name,
                'description' => $request->description,
                'TTH' => $request->TTH,
                'img' => $full_path,
                'country_id' => $request->country_id,
                'user_id' => Auth::id(),
            ]);
            \Log::info('Product created', ['id' => $product->id]);

            // Привязка категорий
            if ($request->has('categories')) {
                $product->categories()->attach($request->categories);
                \Log::info('Categories attached', ['categories' => $request->categories]);
            }
        
            \Log::info('Saving ingredients');
            // Сохранение ингредиентов
            foreach ($request->input('ingredients') as $ingredient) {
                Ingredient::create([
                    'product_id' => $product->id,
                    'name' => $ingredient['name'],
                    'quantity' => $ingredient['quantity'],
                    'unit' => $ingredient['unit'],
                ]);
            }
            \Log::info('Ingredients saved');
        
            \Log::info('Saving recipe steps');
            // Сохранение шагов рецепта
            foreach ($request->input('recipe_steps') as $index => $step) {
                $image_step_name = null;
                
                if ($request->hasFile("recipe_steps.{$index}.image")) {
                    $stepImage = $request->file("recipe_steps.{$index}.image");
                    $stepImageName = time() . '_step_' . $index . '.' . $stepImage->getClientOriginalExtension();
                    $path = 'images/steps/';
                    
                    // Создаем директорию, если она не существует
                    if (!file_exists(public_path($path))) {
                        mkdir(public_path($path), 0777, true);
                    }
                    
                    $stepImage->move(public_path($path), $stepImageName);
                    $image_step_name = $path . $stepImageName;
                    \Log::info('Step image uploaded', ['step' => $index, 'path' => $image_step_name]);
                }

                RecipeStep::create([
                    'product_id' => $product->id,
                    'instruction' => $step['instruction'],
                    'image' => $image_step_name,
                ]);
            }
            \Log::info('Recipe steps saved');
        
            \Log::info('Recipe creation completed successfully');
            return redirect()->route('product.index')->with('success', 'Рецепт успешно добавлен');
        } catch (\Exception $e) {
            \Log::error('Error creating recipe', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            // В случае ошибки удаляем загруженные файлы
            if (isset($full_path) && file_exists(public_path($full_path))) {
                unlink(public_path($full_path));
            }
            
            return redirect()->back()
                ->withErrors(['error' => 'Произошла ошибка при создании рецепта: ' . $e->getMessage()])
                ->withInput();
        }
    }
    

    public function show($id)
    {
        $product = Product::with(['categories', 'ingredients', 'recipeSteps', 'ratings', 'user'])->find($id);
    
        if (!$product) {
            return redirect()->route('product.index')->withErrors('Продукт не найден.');
        }
    
        $country = Country::find($product->country_id);
    
        $data = (object) [
            'id' => $product->id,
            'name' => $product->name,
            'img' => $product->img,
            'description' => $product->description,
            'TTH' => $product->TTH,
            'categories' => $product->categories,
            'country' => $country ? $country->name : 'Unknown',
            'ingredients' => $product->ingredients,
            'recipeSteps' => $product->recipeSteps,
            'ratings' => $product->ratings,
            'averageRating' => $product->averageRating(),
            'user_id' => $product->user_id
        ];
    
        return view('products.show')->with(['data' => $data]);
    }
    

    public function edit($id)
    {
        $product = Product::with('categories')->findOrFail($id);
        
        // Проверяем права доступа
        if (!Auth::user()->hasRole('admin') && Auth::id() !== $product->user_id) {
            abort(403, 'У вас нет прав для редактирования этого рецепта.');
        }
        
        $categories = Category::all();
        $countries = Country::all();
    
        return view('products.edit', compact('product', 'categories', 'countries'));
    }
    

    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);
        
        // Проверяем права доступа
        if (!Auth::user()->hasRole('admin') && Auth::id() !== $product->user_id) {
            abort(403, 'У вас нет прав для редактирования этого рецепта.');
        }
        
        // Валидация входящих данных
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
            'TTH' => 'required|string',
            'img' => 'nullable|file|mimes:jpg,jpeg,png',
            'categories' => 'required|array|min:1',
            'categories.*' => 'exists:categories,id',
            'country_id' => 'required|exists:countries,id',
            'ingredients' => 'required|array',
            'ingredients.*.name' => 'required|string',
            'ingredients.*.quantity' => 'required|numeric',
            'ingredients.*.unit' => 'required|string',
            'recipe_steps' => 'required|array',
            'recipe_steps.*.instruction' => 'required|string',
            'recipe_steps.*.image' => 'nullable|file|mimes:jpg,jpeg,png',
        ]);
    
        if ($validator->fails()) {
            return redirect()->route('product.edit', $product->id)
                             ->withErrors($validator)
                             ->withInput();
        }
    
        // Обновление полей продукта
        $product->name = $request->input('name');
        $product->description = $request->input('description');
        $product->TTH = $request->input('TTH');
        $product->country_id = $request->input('country_id');
    
        // Проверка и обновление изображения
        if ($request->hasFile('img')) {
            // Удаляем старое изображение
            if (file_exists(public_path($product->img))) {
                unlink(public_path($product->img));
            }
    
            // Загружаем новое изображение
            $image_name = time() . '.' . $request->file('img')->extension();
            $path = 'images/products/';
            $request->file('img')->move(public_path($path), $image_name);
            $product->img = $path . $image_name;
        }
    
        // Обновляем категории
        if ($request->has('categories')) {
            $product->categories()->sync($request->categories);
        }
    
        // Сохраняем изменения продукта
        $product->save();
    
        // Обработка ингредиентов
        $product->ingredients()->delete();
        foreach ($request->input('ingredients') as $ingredient) {
            Ingredient::create([
                'product_id' => $product->id,
                'name' => $ingredient['name'],
                'quantity' => $ingredient['quantity'],
                'unit' => $ingredient['unit'],
            ]);
        }
    
        // Обработка шагов рецепта
        $product->recipeSteps()->delete();
        foreach ($request->recipe_steps as $index => $step) {
            $image_step_name = null;
            
            // Проверяем наличие нового файла изображения
            if ($request->hasFile("recipe_steps.{$index}.image")) {
                $stepImage = $request->file("recipe_steps.{$index}.image");
                $stepImageName = time() . '_step_' . $index . '.' . $stepImage->getClientOriginalExtension();
                $path = 'images/steps/';
                $stepImage->move(public_path($path), $stepImageName);
                $image_step_name = $path . $stepImageName;
            } elseif (!empty($step['current_image'])) {
            
                $image_step_name = $step['current_image'];
            }

            RecipeStep::create([
                'product_id' => $product->id,
                'instruction' => $step['instruction'],
                'image' => $image_step_name
            ]);
        }
    
        return redirect()->route('product.index')->with('success', 'Продукт успешно обновлён.');
    }


    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        
        if (!Auth::user()->hasRole('admin') && Auth::id() !== $product->user_id) {
            abort(403, 'У вас нет прав для удаления этого рецепта.');
        }
        
        if (file_exists(public_path($product->img))) {
            unlink(public_path($product->img));
        }
        $product->delete();
        return redirect()->route('product.index')->with('success', 'Рецепт удален');
    }

    public function rate(Request $request, $id)
    {
        $request->validate([
            'rating' => 'required|integer|min:0|max:5'
        ]);

        $product = Product::findOrFail($id);
        
        Rating::updateOrCreate(
            [
                'user_id' => Auth::id(),
                'product_id' => $id
            ],
            [
                'rating' => $request->rating
            ]
        );

        return redirect()->back()->with('success', 'Оценка успешно сохранена');
    }
}
