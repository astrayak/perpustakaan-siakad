<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('bukus', function (Blueprint $table) {
            $table->id();
            // Relasi ke tabel kategoris (jika kategori dihapus, buku tidak bisa dihapus)
            $table->foreignId('kategori_id')->constrained('kategoris')->restrictOnDelete();
            
            $table->string('kode_buku')->unique();
            $table->string('judul');
            $table->string('penulis');
            $table->string('penerbit')->nullable();
            $table->year('tahun_terbit')->nullable();
            $table->string('isbn')->nullable();
            $table->text('deskripsi')->nullable();
            $table->string('cover')->nullable();
            $table->integer('stok_total')->default(0);
            $table->integer('stok_tersedia')->default(0);
            $table->string('lokasi_rak')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bukus');
    }
};