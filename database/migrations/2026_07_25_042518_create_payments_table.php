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
        Schema::create('payments', function (Blueprint $table) {
            $table->id();

            $table->foreignId('order_id')
                  ->constrained('orders')
                  ->cascadeOnDelete();

            $table->decimal('amount', 10, 2);

            $table->enum('method', [
                'Cash on Delivery',
                'Credit/Debit Card',
                'GCash',
                'Bank Transfer',
            ]);

            $table->enum('status', [
                'Pending',
                'Paid',
                'Refunded',
                'Failed',
            ])->default('Pending');

            $table->timestamp('paid_at')->nullable();

            // No created_at or updated_at in the original SQL.

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
