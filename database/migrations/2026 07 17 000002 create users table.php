<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('email', 150)->unique();
            $table->string('password_hash', 255);
            $table->string('full_name', 150)->nullable();
            $table->enum('role', ['admin', 'staff'])->default('user');
            $table->timestamp('created_at')->nullable()->useCurrent();
            // Note: no `updated_at` column — matches the current dump,
            // and App\Models\User has $timestamps = false to match.
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};