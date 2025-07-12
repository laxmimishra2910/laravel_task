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
        Schema::create('employees', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('phone');
            $table->string('position');
            $table->decimal('salary', 10, 2);
            $table->string('photo')->nullable(); // Optional image field
            $table->uuid('department_id'); // ✅ Add the column first
            $table->foreign('department_id')
            ->references('id')->on('departments')
            ->onDelete('cascade');
            $table->softDeletes(); // Adds `deleted_at` column
            $table->timestamps();
            // $table->engine = 'InnoDB'; 
        });

      
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employees');
    }
};
