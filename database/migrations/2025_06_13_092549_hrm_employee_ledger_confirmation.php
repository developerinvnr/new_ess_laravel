<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('hrm_employee_ledger_confirmation', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('EmployeeId');
            $table->string('Year', 10); // e.g., '2024-25'
            $table->string('ip_address', 45); // Supports IPv4 and IPv6
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('hrm_employee_ledger_confirmation');
    }
};