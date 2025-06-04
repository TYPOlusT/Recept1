<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up()
    {
        Schema::create('category_product', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->constrained()->onDelete('cascade');
            $table->foreignId('product_id')->constrained()->onDelete('cascade');
            $table->timestamps();
            
            // Ensure a product can't be in the same category twice
            $table->unique(['category_id', 'product_id']);
        });

        // Migrate existing category relationships
        DB::statement('INSERT INTO category_product (category_id, product_id, created_at, updated_at)
            SELECT category_id, id, NOW(), NOW()
            FROM products
            WHERE category_id IS NOT NULL');
    }

    public function down()
    {
        Schema::dropIfExists('category_product');
    }
}; 