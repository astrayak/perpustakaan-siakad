<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Peminjaman extends Model
{
    // TAMBAHKAN BARIS INI
    protected $table = 'peminjamans';

    protected $fillable = [
        'kode_peminjaman', 'user_id', 'buku_id', 'qr_token',
        'tanggal_pinjam', 'tanggal_jatuh_tempo', 'tanggal_kembali',
        'status', 'diambil_at', 'dikembalikan_at',
        'denda', 'catatan', 'petugas_id',
    ];

    protected $casts = [
        'tanggal_pinjam' => 'date',
        'tanggal_jatuh_tempo' => 'date',
        'tanggal_kembali' => 'date',
        'diambil_at' => 'datetime',
        'dikembalikan_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function buku()
    {
        return $this->belongsTo(Buku::class);
    }

    public function petugas()
    {
        return $this->belongsTo(User::class, 'petugas_id');
    }

    public function scanLogs()
    {
        return $this->hasMany(ScanLog::class);
    }
}