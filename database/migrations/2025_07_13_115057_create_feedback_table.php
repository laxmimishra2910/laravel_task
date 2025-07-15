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
       Schema::create('feedback', function (Blueprint $table) {
    $table->id();
     $table->unsignedBigInteger('tenant_id');
    $table->uuid('employee_id'); // Foreign key to employees
    $table->string('client_name');
    $table->string('email')->nullable();
    $table->text('message');
    $table->enum('rating', ['Excellent', 'Good', 'Average', 'Poor']);
    $table->timestamps();
    $table->foreign('tenant_id')->references('id')->on('tenants')->onDelete('cascade');
    // Relationship with employees
    $table->foreign('employee_id')
        ->references('id')
        ->on('employees')
        ->onDelete('cascade'); // Optional: deletes feedback when employee is deleted
});

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('feedback');
    }
};
