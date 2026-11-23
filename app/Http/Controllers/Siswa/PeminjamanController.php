<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use App\Models\Buku;
use App\Models\Peminjaman;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PeminjamanController extends Controller
{
        public function index(Request $request)
    {
        $status = $request->get('status', 'semua');
        $query = Peminjaman::with(['user', 'buku'])->latest();

        if ($status !== 'semua') {
            if ($status === 'denda') {
                // Tampilkan yang memiliki denda > 0 (baik yang sudah dibayar maupun belum)
                $query->where('denda', '>', 0);
            } else {
                $query->where('status', $status);
            }
        }

        $peminjamans = $query->paginate(15);
        return view('siswa.peminjaman.index', compact('peminjamans', 'status'));
    }

    public function pinjam(Request $request)
    {
        $request->validate(['buku_id' => 'required|exists:bukus,id']);
        $buku = Buku::findOrFail($request->buku_id);

        if ($buku->stok_tersedia < 1) {
            return back()->with('error', 'Stok buku habis.');
        }

        // FITUR: Siswa hanya bisa meminjam 1 buku
        $pinjamanAktif = Peminjaman::where('user_id', auth()->id())
            ->whereIn('status', ['menunggu_diambil', 'dipinjam', 'terlambat'])
            ->exists();

        if ($pinjamanAktif) {
            return back()->with('error', 'Anda masih memiliki peminjaman aktif. Selesaikan atau batalkan terlebih dahulu.');
        }

        $urutan = Peminjaman::whereDate('created_at', today())->count() + 1;

        $peminjaman = Peminjaman::create([
            'kode_peminjaman' => 'PJM-' . date('Ymd') . '-' . str_pad($urutan, 4, '0', STR_PAD_LEFT),
            'user_id' => auth()->id(),
            'buku_id' => $buku->id,
            'qr_token' => (string) Str::uuid(),
            'tanggal_pinjam' => now(),
            'tanggal_jatuh_tempo' => now()->addDays(7), // FITUR: Jatuh tempo 7 hari
            'status' => 'menunggu_diambil',
        ]);

        return redirect()->route('siswa.peminjaman.qr', $peminjaman->id)
            ->with('success', 'Peminjaman berhasil!');
    }

    public function batalkan(Peminjaman $peminjaman)
    {
        // FITUR: Batalkan hanya jika status masih menunggu
        if ($peminjaman->user_id !== auth()->id() || $peminjaman->status !== 'menunggu_diambil') {
            abort(403);
        }

        $peminjaman->update(['status' => 'dibatalkan']);
        return back()->with('success', 'Peminjaman berhasil dibatalkan.');
    }

    public function showQr(Peminjaman $peminjaman)
    {
        if ($peminjaman->user_id !== auth()->id()) abort(403);
        return view('siswa.peminjaman.qr', compact('peminjaman'));
    }

    public function showQrKembali(Peminjaman $peminjaman)
    {
        if ($peminjaman->user_id !== auth()->id() || $peminjaman->status === 'dikembalikan') abort(403);
        return view('siswa.peminjaman.qr_kembali', compact('peminjaman'));
    }
}