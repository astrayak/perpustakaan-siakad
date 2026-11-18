<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class SiswaController extends Controller
{
    public function index(Request $request)
    {
        $query = User::where('role', 'siswa');

        // Fitur Pencarian
        if ($request->has('search')) {
            $query->where(function($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('nis', 'like', '%' . $request->search . '%')
                  ->orWhere('kelas', 'like', '%' . $request->search . '%');
            });
        }

        $siswas = $query->latest()->paginate(10);
        return view('admin.siswa.index', compact('siswas'));
    }

    public function show(User $siswa)
    {
        // Pastikan yang dilihat benar-benar siswa
        if ($siswa->role !== 'siswa') {
            abort(404);
        }

        // Ambil riwayat peminjaman siswa tersebut
        $peminjamans = $siswa->peminjamans()
            ->with('buku')
            ->latest()
            ->get();

        // Hitung total denda yang belum dibayar (status dikembalikan dengan denda > 0)
        $totalDenda = $peminjamans->where('status', 'dikembalikan')->sum('denda');

        return view('admin.siswa.show', compact('siswa', 'peminjamans', 'totalDenda'));
    }

    public function edit(User $siswa)
    {
        if ($siswa->role !== 'siswa') {
            abort(404);
        }
        return view('admin.siswa.edit', compact('siswa'));
    }

    public function update(Request $request, User $siswa)
    {
        if ($siswa->role !== 'siswa') {
            abort(404);
        }

        // Validasi data termasuk tahun_lulus dan is_active
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . $siswa->id],
            'nis' => ['required', 'string', 'max:50', 'unique:users,nis,' . $siswa->id],
            'kelas' => ['required', 'string', 'max:50'],
            'no_hp' => ['nullable', 'string', 'max:20'],
            'alamat' => ['nullable', 'string'],
            'tahun_lulus' => ['nullable', 'integer'], 
            'is_active' => ['required', 'boolean'],   
        ]);

        $siswa->update([
            'name' => $request->name,
            'email' => $request->email,
            'nis' => $request->nis,
            'kelas' => $request->kelas,
            'no_hp' => $request->no_hp,
            'alamat' => $request->alamat,
            'tahun_lulus' => $request->tahun_lulus,
            'is_active' => $request->is_active,
        ]);

        return redirect()->route('admin.siswa.index')->with('success', 'Data siswa berhasil diperbarui.');
    }
}