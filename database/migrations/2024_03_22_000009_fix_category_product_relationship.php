<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        // Удаляем все существующие таблицы
        Schema::dropIfExists('category_product');
        Schema::dropIfExists('products');
        Schema::dropIfExists('categories');

        // Создаем таблицу категорий
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->string('name', 58);
            $table->timestamps();
        });

        // Создаем таблицу продуктов
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

        // Создаем таблицу связей
        Schema::create('category_product', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->constrained()->onDelete('cascade');
            $table->foreignId('product_id')->constrained()->onDelete('cascade');
            $table->timestamps();
            
            $table->unique(['category_id', 'product_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('category_product');
        Schema::dropIfExists('products');
        Schema::dropIfExists('categories');
    }
}; 