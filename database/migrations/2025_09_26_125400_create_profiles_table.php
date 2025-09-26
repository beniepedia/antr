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
        Schema::create('profiles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('tenant_id')->constrained('tenants')->onDelete('cascade');
            $table->string('employee_id')->nullable()->unique();
            $table->enum('position', ['operator', 'supervisor', 'manager'])->default('operator');
            $table->enum('shift', ['morning', 'afternoon', 'night'])->nullable();
            $table->date('hire_date')->nullable();
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->string('station_code')->nullable(); // Kode SPBU
            $table->string('license_number')->nullable(); // Nomor lisensi jika diperlukan
            $table->integer('experience_years')->nullable();
            $table->string('avatar')->nullable(); // Path ke foto profil
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('profiles');
    }
};
