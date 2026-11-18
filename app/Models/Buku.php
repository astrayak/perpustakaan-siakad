<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Buku extends Model
{
    protected $fillable = [
        'kategori_id', 'kode_buku', 'judul', 'penulis', 'penerbit',
        'tahun_terbit', 'isbn', 'deskripsi', 'cover',
        'stok_total', 'stok_tersedia', 'lokasi_rak',
    ];

    public function kategori()
    {
        return $this->belongsTo(Kategori::class);
    }

    public function peminjamans()
    {
        return $this->hasMany(Peminjaman::class);
    }

    // TAMBAHKAN FUNGSI INI UNTUK URL GAMBAR
    public function getCoverUrlAttribute()
    {
        if ($this->cover && Storage::disk('public')->exists($this->cover)) {
            return asset('storage/' . $this->cover);
        }
        return null; // Jika tidak ada gambar
    }
}