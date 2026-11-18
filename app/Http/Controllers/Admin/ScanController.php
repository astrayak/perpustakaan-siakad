<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Peminjaman;
use App\Models\ScanLog;
use Illuminate\Http\Request;

class ScanController extends Controller
{
    public function index()
    {
        return view('admin.scan.index');
    }

    public function proses(Request $request)
    {
        $request->validate(['qr_token' => 'required|string']);

        $peminjaman = Peminjaman::where('qr_token', $request->qr_token)
            ->with(['user', 'buku'])
            ->first();

        if (!$peminjaman) {
            return response()->json([
                'success' => false,
                'message' => 'QR Code tidak valid / tidak ditemukan.',
            ], 404);
        }

        // CASE 1: Ambil buku
        if ($peminjaman->status === 'menunggu_diambil') {
            if ($peminjaman->buku->stok_tersedia < 1) {
                return response()->json([
                    'success' => false,
                    'message' => 'Stok buku habis, tidak bisa dipinjam.',
                ], 400);
            }

            $peminjaman->update([
                'status' => 'dipinjam',
                'diambil_at' => now(),
                'petugas_id' => auth()->id(),
            ]);

            $peminjaman->buku->decrement('stok_tersedia');

            ScanLog::create([
                'peminjaman_id' => $peminjaman->id,
                'admin_id' => auth()->id(),
                'aksi' => 'ambil_buku',
                'ip_address' => $request->ip(),
            ]);

            return response()->json([
                'success' => true,
                'aksi' => 'ambil_buku',
                'message' => "Buku \"{$peminjaman->buku->judul}\" berhasil dipinjam oleh {$peminjaman->user->name}",
                'data' => $peminjaman,
            ]);
        }

        // CASE 2: Kembalikan buku
        if (in_array($peminjaman->status, ['dipinjam', 'terlambat'])) {
            $jatuhTempo = \Carbon\Carbon::parse($peminjaman->tanggal_jatuh_tempo);
            $hariIni = now();
            $denda = 0;

            if ($hariIni->greaterThan($jatuhTempo)) {
                $hariTerlambat = $jatuhTempo->diffInDays($hariIni);
                $denda = $hariTerlambat * 1000;
            }

            $peminjaman->update([
                'status' => 'dikembalikan',
                'tanggal_kembali' => now(),
                'dikembalikan_at' => now(),
                'denda' => $denda,
                'petugas_id' => auth()->id(),
            ]);

            $peminjaman->buku->increment('stok_tersedia');

            ScanLog::create([
                'peminjaman_id' => $peminjaman->id,
                'admin_id' => auth()->id(),
                'aksi' => 'kembalikan_buku',
                'ip_address' => $request->ip(),
            ]);

            return response()->json([
                'success' => true,
                'aksi' => 'kembalikan_buku',
                'message' => "Buku \"{$peminjaman->buku->judul}\" berhasil dikembalikan." .
                             ($denda > 0 ? " Denda: Rp " . number_format($denda, 0, ',', '.') : " Tanpa denda."),
                'data' => $peminjaman,
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Status peminjaman tidak valid untuk diproses.',
        ], 400);
    }
}