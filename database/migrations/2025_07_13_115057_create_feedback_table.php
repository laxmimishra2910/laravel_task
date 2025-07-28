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
            $table->uuid('id')->primary();
             $table->string('client_name');
            $table->string('email')->nullable();
            $table->text('message');
            $table->enum('rating', ['Excellent', 'Good', 'Average', 'Poor']);
            $table->timestamps();
             
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
