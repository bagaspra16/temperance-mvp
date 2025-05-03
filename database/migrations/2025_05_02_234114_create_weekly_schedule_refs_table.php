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
        Schema::create('weekly_schedule_refs', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('weekly_template_id');
            $table->foreign('weekly_template_id')->references('id')->on('schedule_templates')->onDelete('cascade');
            $table->uuid('daily_template_id');
            $table->foreign('daily_template_id')->references('id')->on('schedule_templates');
            $table->string('day_of_week', 10)->check("day_of_week IN ('Mon','Tue','Wed','Thu','Fri','Sat','Sun')");
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
        Schema::dropIfExists('weekly_schedule_refs');
    }
};
