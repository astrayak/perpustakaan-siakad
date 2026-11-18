<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class ScanLog extends Model
{
    protected $fillable = [
        'peminjaman_id', 'admin_id', 'aksi',
        'scanned_at', 'ip_address', 'keterangan',
    ];

    protected $casts = [
        'scanned_at' => 'datetime',
    ];

    public function peminjaman()
    {
        return $this->belongsTo(Peminjaman::class);
    }

    public function admin()
    {
        return $this->belongsTo(User::class, 'admin_id');
    }
}