<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        // First, ensure all products have at least one category in the pivot table
        if (Schema::hasTable('category_product')) {
            Schema::table('products', function (Blueprint $table) {
                // Remove the foreign key constraint first
                $table->dropForeign(['category_id']);
                // Then remove the column
                $table->dropColumn('category_id');
            });
        }
    }

    public function down()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->foreignId('category_id')->nullable()->constrained()->onDelete('cascade');
        });
    }
}; 