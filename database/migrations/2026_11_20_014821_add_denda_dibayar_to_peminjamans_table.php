<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('peminjamans', function (Blueprint $table) {
            $table->boolean('denda_dibayar')->default(false)->after('denda');
            $table->string('bukti_pembayaran')->nullable()->after('denda_dibayar');
        });
    }

    public function down(): void
    {
        Schema::table('peminjamans', function (Blueprint $table) {
            $table->dropColumn(['denda_dibayar', 'bukti_pembayaran']);
        });
    }
};