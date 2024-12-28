<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Users table creation
        Schema::create('users', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('email', 100)->unique();
            $table->index('email');
            $table->boolean('email_verified')->default(false);
            $table->string('phone_number', 15)->unique()->nullable();
            $table->string('full_name', 50);
            $table->string('address', 100)->nullable();
            $table->string('password', 100);
            $table->string('provider_type', 50)->default('LOCAL');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
