<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('login_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('set null');
            $table->string('name'); // Menyimpan nama untuk berjaga-jaga jika user dihapus
            $table->string('role'); // admin atau siswa
            $table->string('ip_address', 45)->nullable();
            $table->string('user_agent')->nullable(); // Info browser/device
            $table->timestamp('login_at')->useCurrent();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('login_logs');
    }
};