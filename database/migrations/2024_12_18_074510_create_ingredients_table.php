<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIngredientsTable extends Migration
{
    public function up()
    {
        Schema::create('ingredients', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained()->onDelete('cascade'); // Это должно быть здесь
            $table->string('name');
            $table->decimal('quantity');
            $table->string('unit')->nullable();
            $table->timestamps();
        });
    }
    
    

    public function down()
    {
        Schema::dropIfExists('ingredients');
    }
}
