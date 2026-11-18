<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use App\Models\Buku;
use App\Models\Peminjaman;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PeminjamanController extends Controller
{
    public function index()
    {
        $peminjamans = Peminjaman::with('buku')
            ->where('user_id', auth()->id())
            ->latest()
            ->paginate(10);

        return view('siswa.peminjaman.index', compact('peminjamans'));
    }

    public function pinjam(Request $request)
    {
        $request->validate(['buku_id' => 'required|exists:bukus,id']);

        $buku = Buku::findOrFail($request->buku_id);

        if ($buku->stok_tersedia < 1) {
            return back()->with('error', 'Stok buku habis.');
        }

        $sudahPinjam = Peminjaman::where('user_id', auth()->id())
            ->where('buku_id', $buku->id)
            ->whereIn('status', ['menunggu_diambil', 'dipinjam'])
            ->exists();

        if ($sudahPinjam) {
            return back()->with('error', 'Anda masih memiliki peminjaman aktif untuk buku ini.');
        }

        $urutan = Peminjaman::whereDate('created_at', today())->count() + 1;

        $peminjaman = Peminjaman::create([
            'kode_peminjaman' => 'PJM-' . date('Ymd') . '-' . str_pad($urutan, 4, '0', STR_PAD_LEFT),
            'user_id' => auth()->id(),
            'buku_id' => $buku->id,
            'qr_token' => (string) Str::uuid(),
            'tanggal_pinjam' => now(),
            'tanggal_jatuh_tempo' => now()->addDays(7),
            'status' => 'menunggu_diambil',
        ]);

        return redirect()->route('siswa.peminjaman.qr', $peminjaman->id)
            ->with('success', 'Peminjaman berhasil! Tunjukkan QR di bawah ke petugas.');
    }

    public function showQr(Peminjaman $peminjaman)
    {
        if ($peminjaman->user_id !== auth()->id()) {
            abort(403);
        }

        return view('siswa.peminjaman.qr', compact('peminjaman'));
    }

        // Tambahkan fungsi ini di bawah function showQr
    public function showQrKembali(Peminjaman $peminjaman)
    {
        if ($peminjaman->user_id !== auth()->id() || $peminjaman->status === 'dikembalikan') {
            abort(403);
        }

        return view('siswa.peminjaman.qr_kembali', compact('peminjaman'));
    }
}