<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // 1. Soft Delete untuk Kategori & Buku (agar tidak terhapus permanen)
        Schema::table('kategoris', function (Blueprint $table) {
            $table->softDeletes();
        });
        Schema::table('bukus', function (Blueprint $table) {
            $table->softDeletes();
        });

        // 2. Kolom File Digital di Buku
        Schema::table('bukus', function (Blueprint $table) {
            $table->string('file_digital')->nullable()->after('cover');
            $table->boolean('is_digital')->default(false)->after('file_digital');
        });
    }

    public function down(): void
    {
        Schema::table('kategoris', function (Blueprint $table) { $table->dropSoftDeletes(); });
        Schema::table('bukus', function (Blueprint $table) { $table->dropSoftDeletes(); });
        Schema::table('bukus', function (Blueprint $table) { $table->dropColumn(['file_digital', 'is_digital']); });
    }
};