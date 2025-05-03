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
        Schema::create('habit_logs', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('habit_id');
            $table->foreign('habit_id')->references('id')->on('habits');
            $table->uuid('user_id');
            $table->foreign('user_id')->references('id')->on('users');
            $table->date('log_date');
            $table->boolean('status')->default(false);
            $table->text('note')->nullable();
            $table->boolean('deleted')->default(false);
            $table->timestamp('created_date')->default(now());
            $table->uuid('created_by');
            $table->timestamp('updated_date')->nullable();
            $table->uuid('updated_by')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('habit_logs');
    }
};
