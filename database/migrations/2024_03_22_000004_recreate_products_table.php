<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up()
    {
        // Создаем временную таблицу с нужной структурой
        Schema::create('products_new', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('name', 250);
            $table->string('description', 1000)->nullable();
            $table->text('TTH')->nullable();
            $table->string('img', 2500);
            $table->foreignId('country_id')->constrained()->onDelete('cascade');
            $table->timestamps();
        });

        // Копируем данные из старой таблицы в новую
        DB::statement('INSERT INTO products_new (id, user_id, name, description, TTH, img, country_id, created_at, updated_at)
            SELECT id, user_id, name, description, TTH, img, country_id, created_at, updated_at
            FROM products');

        // Удаляем старую таблицу
        Schema::drop('products');

        // Переименовываем новую таблицу
        Schema::rename('products_new', 'products');

        // Создаем таблицу связей, если она еще не существует
        if (!Schema::hasTable('category_product')) {
            Schema::create('category_product', function (Blueprint $table) {
                $table->id();
                $table->foreignId('category_id')->constrained()->onDelete('cascade');
                $table->foreignId('product_id')->constrained()->onDelete('cascade');
                $table->timestamps();
                
                $table->unique(['category_id', 'product_id']);
            });
        }
    }

    public function down()
    {
        // Создаем временную таблицу со старой структурой
        Schema::create('products_old', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('name', 250);
            $table->string('description', 1000)->nullable();
            $table->text('TTH')->nullable();
            $table->string('img', 2500);
            $table->foreignId('category_id')->nullable()->constrained()->onDelete('cascade');
            $table->foreignId('country_id')->constrained()->onDelete('cascade');
            $table->timestamps();
        });

        // Копируем данные обратно
        DB::statement('INSERT INTO products_old (id, user_id, name, description, TTH, img, country_id, created_at, updated_at)
            SELECT id, user_id, name, description, TTH, img, country_id, created_at, updated_at
            FROM products');

        // Удаляем новую таблицу
        Schema::drop('products');

        // Переименовываем старую таблицу обратно
        Schema::rename('products_old', 'products');

        // Удаляем таблицу связей
        Schema::dropIfExists('category_product');
    }
}; 