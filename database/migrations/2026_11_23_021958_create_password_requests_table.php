<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('password_requests', function (Blueprint $table) {
            $table->id();
            $table->string('nis'); // Siswa memasukkan NIS atau Email
            $table->text('alasan')->nullable(); // Alasan lupa password (opsional)
            $table->enum('status', ['pending', 'selesai'])->default('pending');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('password_requests');
    }
};