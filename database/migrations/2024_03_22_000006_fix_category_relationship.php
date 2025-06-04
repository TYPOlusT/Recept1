<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up()
    {
        if (!Schema::hasTable('category_product')) {
            Schema::create('category_product', function (Blueprint $table) {
                $table->id();
                $table->foreignId('category_id')->constrained()->onDelete('cascade');
                $table->foreignId('product_id')->constrained()->onDelete('cascade');
                $table->timestamps();
                
                $table->unique(['category_id', 'product_id']);
            });
        }

     
        if (Schema::hasColumn('products', 'category_id')) {
            DB::statement('INSERT IGNORE INTO category_product (category_id, product_id, created_at, updated_at)
                SELECT category_id, id, NOW(), NOW()
                FROM products
                WHERE category_id IS NOT NULL');

            Schema::table('products', function (Blueprint $table) {
                $table->dropForeign(['category_id']);
                $table->dropColumn('category_id');
            });
        }
    }

    public function down()
    {
        if (!Schema::hasColumn('products', 'category_id')) {
            Schema::table('products', function (Blueprint $table) {
                $table->foreignId('category_id')->nullable()->constrained()->onDelete('cascade');
            });

            DB::statement('UPDATE products p
                INNER JOIN category_product cp ON p.id = cp.product_id
                SET p.category_id = cp.category_id
                WHERE cp.id = (
                    SELECT MIN(id) FROM category_product WHERE product_id = p.id
                )');
        }
    }
}; 