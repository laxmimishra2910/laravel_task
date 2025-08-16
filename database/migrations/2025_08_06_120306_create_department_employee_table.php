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
        // Finally create the pivot table
  Schema::create('department_employee', function (Blueprint $table) {
    $table->id();
    $table->uuid('employee_id');
    $table->uuid('department_id');
    $table->timestamps();

    $table->foreign('employee_id')->references('id')->on('employees')->onDelete('cascade');
    $table->foreign('department_id')->references('id')->on('departments')->onDelete('cascade');
    
    // For one-to-many (one employee to one department)
    $table->unique(['employee_id']);
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('department_employee');
    }
};
