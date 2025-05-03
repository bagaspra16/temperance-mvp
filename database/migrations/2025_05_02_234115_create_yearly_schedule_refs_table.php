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
        Schema::create('yearly_schedule_refs', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('yearly_template_id');
            $table->foreign('yearly_template_id')->references('id')->on('schedule_templates')->onDelete('cascade');
            $table->uuid('monthly_template_id');
            $table->foreign('monthly_template_id')->references('id')->on('schedule_templates');
            $table->smallInteger('month')->check('month BETWEEN 1 AND 12');
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
        Schema::dropIfExists('yearly_schedule_refs');
    }
};
