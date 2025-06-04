<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRecipeStepsTable extends Migration
{
    public function up()
    {
        Schema::create('recipe_steps', function (Blueprint $table) {
            $table->id(); // Уникальный ID для каждого шага
            $table->foreignId('product_id')->constrained()->onDelete('cascade'); // Связь с продуктом
            $table->text('instruction'); // Шаги приготовления
            $table->string('image')->nullable(); // Путь к изображению шага (если есть)
            $table->timestamps(); // Метаданные о времени создания и обновления
        });
    }

    public function down()
    {
        Schema::dropIfExists('recipe_steps'); // Удаление таблицы при откате миграции
    }
}
