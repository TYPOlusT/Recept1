<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up()
    {
        // Drop any existing foreign key constraints on category_id
        try {
            Schema::table('products', function (Blueprint $table) {
                $table->dropForeign(['category_id']);
            });
        } catch (\Exception $e) {
            // Ignore if foreign key doesn't exist
        }

        // Drop the category_id column if it exists
        if (Schema::hasColumn('products', 'category_id')) {
            Schema::table('products', function (Blueprint $table) {
                $table->dropColumn('category_id');
            });
        }

        // Ensure category_product table exists with correct structure
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
        // Add back the category_id column as nullable
        if (!Schema::hasColumn('products', 'category_id')) {
            Schema::table('products', function (Blueprint $table) {
                $table->foreignId('category_id')->nullable()->constrained()->onDelete('cascade');
            });
        }
    }
}; 