<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        // Создаем таблицу пользователей, если она еще не существует
        if (!Schema::hasTable('users')) {
            Schema::create('users', function (Blueprint $table) {
                $table->id();
                $table->string('name');
                $table->string('email')->unique();
                $table->string('password');
                $table->rememberToken();
                $table->timestamps();
            });
        }

        // Создаем таблицу стран
        if (!Schema::hasTable('countries')) {
            Schema::create('countries', function (Blueprint $table) {
                $table->id();
                $table->string('name');
                $table->timestamps();
            });
        }

        // Создаем таблицу категорий
        if (!Schema::hasTable('categories')) {
            Schema::create('categories', function (Blueprint $table) {
                $table->id();
                $table->string('name', 58);
                $table->timestamps();
            });
        }

        // Создаем таблицу продуктов
        if (!Schema::hasTable('products')) {
            Schema::create('products', function (Blueprint $table) {
                $table->id();
                $table->foreignId('user_id')->constrained()->onDelete('cascade');
                $table->string('name', 250);
                $table->string('description', 1000)->nullable();
                $table->text('TTH')->nullable();
                $table->string('img', 2500);
                $table->foreignId('country_id')->constrained()->onDelete('cascade');
                $table->timestamps();
            });
        }

        // Создаем таблицу связей категорий и продуктов
        if (!Schema::hasTable('category_product')) {
            Schema::create('category_product', function (Blueprint $table) {
                $table->id();
                $table->foreignId('category_id')->constrained()->onDelete('cascade');
                $table->foreignId('product_id')->constrained()->onDelete('cascade');
                $table->timestamps();
                
                $table->unique(['category_id', 'product_id']);
            });
        }

        // Создаем таблицу ингредиентов
        if (!Schema::hasTable('ingredients')) {
            Schema::create('ingredients', function (Blueprint $table) {
                $table->id();
                $table->foreignId('product_id')->constrained()->onDelete('cascade');
                $table->string('name');
                $table->decimal('quantity', 8, 2);
                $table->string('unit');
                $table->timestamps();
            });
        }

        // Создаем таблицу шагов рецепта
        if (!Schema::hasTable('recipe_steps')) {
            Schema::create('recipe_steps', function (Blueprint $table) {
                $table->id();
                $table->foreignId('product_id')->constrained()->onDelete('cascade');
                $table->text('instruction');
                $table->string('image')->nullable();
                $table->timestamps();
            });
        }

        // Создаем таблицу рейтингов
        if (!Schema::hasTable('ratings')) {
            Schema::create('ratings', function (Blueprint $table) {
                $table->id();
                $table->foreignId('user_id')->constrained()->onDelete('cascade');
                $table->foreignId('product_id')->constrained()->onDelete('cascade');
                $table->integer('rating');
                $table->timestamps();
            });
        }

        // Создаем таблицу избранных рецептов
        if (!Schema::hasTable('favorites')) {
            Schema::create('favorites', function (Blueprint $table) {
                $table->id();
                $table->foreignId('user_id')->constrained()->onDelete('cascade');
                $table->foreignId('product_id')->constrained()->onDelete('cascade');
                $table->timestamps();
                
                // Уникальный индекс для предотвращения дублирования
                $table->unique(['user_id', 'product_id']);
            });
        }

        // Создаем таблицу заказов
        if (!Schema::hasTable('orders')) {
            Schema::create('orders', function (Blueprint $table) {
                $table->id();
                $table->foreignId('user_id')->constrained()->onDelete('cascade');
                $table->string('status')->default('pending');
                $table->decimal('total_amount', 10, 2)->default(0);
                $table->text('notes')->nullable();
                $table->timestamps();
            });
        }

        // Создаем таблицу элементов заказа
        if (!Schema::hasTable('order_items')) {
            Schema::create('order_items', function (Blueprint $table) {
                $table->id();
                $table->foreignId('order_id')->constrained()->onDelete('cascade');
                $table->foreignId('product_id')->constrained()->onDelete('cascade');
                $table->integer('quantity');
                $table->decimal('price', 10, 2);
                $table->timestamps();
            });
        }
    }

    public function down()
    {
        Schema::dropIfExists('order_items');
        Schema::dropIfExists('orders');
        Schema::dropIfExists('ratings');
        Schema::dropIfExists('favorites');
        Schema::dropIfExists('recipe_steps');
        Schema::dropIfExists('ingredients');
        Schema::dropIfExists('category_product');
        Schema::dropIfExists('products');
        Schema::dropIfExists('categories');
        Schema::dropIfExists('countries');
        Schema::dropIfExists('users');
    }
}; 