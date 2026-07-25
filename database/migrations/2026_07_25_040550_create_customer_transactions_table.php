<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('customer_transactions', function (Blueprint $table) {
        $table->id();
        
        $table->foreignId('customer_id')
        ->nullable()
        ->constrained('customers')
        ->nullOnDelete();

        $table->foreignId('order_id')
        ->nullable()
        ->constrained('orders')
        ->nullOnDelete();

        $table->string('store', 50);
        $table->string('transaction_id', 30)->unique();
        $table->string('payment_method', 30);
        $table->decimal('amount', 10, 2)->default(0);

        $table->enum('status', [
            'Verified',
            'Pending',
            'Error',
        ])->default('Pending');

        $table->timestamp('created_at')->nullable()->useCurrent();
        $table->timestamp('updated_at')->nullable()->useCurrent()->useCurrentOnUpdate();
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customer_transactions');
    }
};
