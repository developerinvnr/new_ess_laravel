<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('communication_controls', function (Blueprint $table) {
            $table->id();
            $table->string('module_name')->unique();
            $table->boolean('status')->default(0); // 0 = Inactive, 1 = Active
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('communication_controls');
    }
};

