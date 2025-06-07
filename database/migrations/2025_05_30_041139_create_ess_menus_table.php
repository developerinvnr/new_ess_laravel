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
        Schema::create('menu_visibility', function (Blueprint $table) {
            $table->id();
            $table->string('name');              // Display name
            $table->string('route')->nullable(); // Laravel route name
            $table->string('icon')->nullable();  // Optional font-awesome icon class
            $table->boolean('is_visible')->default(true); // Visibility flag
            $table->timestamps();
        });


    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('menu_visibility');
    }
};
