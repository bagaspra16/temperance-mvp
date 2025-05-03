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
        Schema::create('monthly_schedule_refs', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('monthly_template_id');
            $table->foreign('monthly_template_id')->references('id')->on('schedule_templates')->onDelete('cascade');
            $table->uuid('weekly_template_id');
            $table->foreign('weekly_template_id')->references('id')->on('schedule_templates');
            $table->smallInteger('week_of_month')->check('week_of_month BETWEEN 1 AND 5');
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
        Schema::dropIfExists('monthly_schedule_refs');
    }
};
