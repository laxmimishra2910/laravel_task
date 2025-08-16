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
        Schema::create('employee_feedback', function (Blueprint $table) {
    $table->uuid('id')->primary();
    $table->uuid('employee_id');
    $table->uuid('feedback_id');
    $table->timestamps();
    
    // Foreign key constraints
    $table->foreign('employee_id')->references('id')->on('employees')->onDelete('cascade');
    $table->foreign('feedback_id')->references('id')->on('feedback')->onDelete('cascade');
    
    // Composite unique index
    $table->unique(['employee_id', 'feedback_id']);
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employee_feedback');
    }
};
