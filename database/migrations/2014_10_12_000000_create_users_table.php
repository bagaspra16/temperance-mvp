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
        Schema::create('users', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('name', 100);
            $table->string('email', 100)->unique();
            $table->text('password');
            $table->boolean('deleted')->default(false);
            $table->timestamp('created_date')->default(now());
            $table->uuid('created_by')->nullable();
            $table->timestamp('updated_date')->nullable();
            $table->uuid('updated_by')->nullable();
            $table->rememberToken();
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