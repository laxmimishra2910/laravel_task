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
 Schema::create('projects', function (Blueprint $table) {
            $table->id();
             $table->unsignedBigInteger('tenant_id');
             $table->string('project_name');
            $table->text('description')->nullable();
            $table->string('status')->default('Pending'); // Pending, In Progress, Completed
            $table->date('start_date');
            $table->date('end_date')->nullable();
            $table->timestamps();
             $table->foreign('tenant_id')->references('id')->on('tenants')->onDelete('cascade');
        });
    }
    /**
     * 
     * 
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('projects'); // ✅ FIXED
    }
};
