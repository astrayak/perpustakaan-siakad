<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Peminjaman;
use Illuminate\Http\Request;

class PeminjamanController extends Controller
{
    public function index(Request $request)
    {
        $status = $request->get('status', 'semua');
        $sort = $request->get('sort', 'terbaru'); 
        
        // Gunakan query builder untuk menampung berbagai filter
        $query = Peminjaman::with(['user', 'buku']);

        // 1. Filter Status
        if ($status !== 'semua') {
            if ($status === 'denda') {
                $query->where('denda', '>', 0);
            } else {
                $query->where('status', $status);
            }
        }

        // 2. Filter Tanggal Kustom
        if ($request->filled('start_date') && $request->filled('end_date')) {
            $query->whereBetween('tanggal_pinjam', [$request->start_date, $request->end_date]);
        }

        // 3. Fitur Urutkan (Sorting)
        if ($sort === 'terlama') {
            $query->oldest('tanggal_pinjam');
        } else {
            $query->latest('tanggal_pinjam'); 
        }

        // 4. Ambil data dengan pagination
        $peminjamans = $query->paginate(15)->appends($request->all()); 
        
        return view('admin.peminjaman.index', compact('peminjamans', 'status', 'sort'));
    }

    public function bayarDenda(Peminjaman $peminjaman)
    {
        if ($peminjaman->denda <= 0) {
            return back()->with('error', 'Tidak ada denda yang perlu dibayar.');
        }
        
        $peminjaman->update(['denda_dibayar' => true]);
        return back()->with('success', 'Denda berhasil ditandai sudah dibayar.');
    }
}