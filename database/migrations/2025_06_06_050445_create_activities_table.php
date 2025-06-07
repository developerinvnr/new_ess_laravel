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
        Schema::create('activities_master', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->enum('approve', ['Yes', 'No'])->default('No');
            $table->enum('reject', ['Yes', 'No'])->default('No');
            $table->json('modules')->nullable(); // Checkbox values
            $table->json('notification_types')->nullable(); // Email, SMS, etc.
            $table->enum('status', ['Active', 'Deactive'])->default('Active');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('activities_master');
    }
};
