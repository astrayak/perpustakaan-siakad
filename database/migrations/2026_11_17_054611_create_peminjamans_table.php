<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('peminjamans', function (Blueprint $table) {
            $table->id();
            $table->string('kode_peminjaman')->unique();
            
            // Relasi ke tabel users (Siswa yang meminjam)
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            // Relasi ke tabel bukus
            $table->foreignId('buku_id')->constrained('bukus')->restrictOnDelete();
            
            $table->string('qr_token')->unique();
            $table->string('qr_image')->nullable();
            $table->date('tanggal_pinjam');
            $table->date('tanggal_jatuh_tempo');
            $table->date('tanggal_kembali')->nullable();
            
            $table->enum('status', [
                'menunggu_diambil', 
                'dipinjam', 
                'dikembalikan', 
                'terlambat', 
                'dibatalkan'
            ])->default('menunggu_diambil');
            
            $table->timestamp('diambil_at')->nullable();
            $table->timestamp('dikembalikan_at')->nullable();
            $table->integer('denda')->default(0);
            $table->text('catatan')->nullable();
            
            // Relasi ke tabel users (Admin/Petugas yang memproses)
            $table->foreignId('petugas_id')->nullable()->constrained('users')->nullOnDelete();
            
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('peminjamans');
    }
};