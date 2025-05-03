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
        Schema::create('goals', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('user_id');
            $table->foreign('user_id')->references('id')->on('users');
            $table->uuid('category_id');
            $table->foreign('category_id')->references('id')->on('categories');
            $table->text('title');
            $table->text('description');
            $table->string('type', 10)->check("type IN ('daily', 'weekly', 'monthly', 'yearly')");
            $table->integer('target_value');
            $table->string('unit', 50);
            $table->date('start_date');
            $table->date('end_date');
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
        Schema::dropIfExists('goals');
    }
};
