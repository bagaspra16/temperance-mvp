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
        Schema::create('habits', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('user_id');
            $table->foreign('user_id')->references('id')->on('users');
            $table->uuid('goal_id')->nullable();
            $table->foreign('goal_id')->references('id')->on('goals');
            $table->text('title');
            $table->jsonb('schedule');
            $table->boolean('active')->default(true);
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
        Schema::dropIfExists('habits');
    }
};
