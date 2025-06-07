<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
        public function up()
    {
        Schema::create('master_transaction_names', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->unsignedBigInteger('parentid')->nullable();
            $table->unsignedBigInteger('main_master_parentid')->nullable();
            $table->boolean('status')->default(1); // 1 = Active, 0 = Inactive
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('master_transaction_names');
    }
};
