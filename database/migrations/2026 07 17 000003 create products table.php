<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('sku', 50)->unique();
            $table->string('name', 150);
            $table->foreignId('category_id')
                  ->nullable()
                  ->constrained('categories')
                  ->nullOnDelete();
            $table->decimal('price', 10, 2)->default(0);
            $table->decimal('cost', 10, 2)->nullable()->default(0);
            $table->integer('stock_quantity')->default(0);
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->string('image_url', 255)->nullable();
            $table->timestamp('created_at')->nullable()->useCurrent();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};