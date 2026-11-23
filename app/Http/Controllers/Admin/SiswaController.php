<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\PasswordRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class SiswaController extends Controller
{
    public function index(Request $request)
    {
        $query = User::where('role', 'siswa');
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
        if ($siswa->role !== 'siswa') abort(404);
        $peminjamans = $siswa->peminjamans()->with('buku')->latest()->get();
        $totalDenda = $peminjamans->where('status', 'dikembalikan')->sum('denda');
        return view('admin.siswa.show', compact('siswa', 'peminjamans', 'totalDenda'));
    }

    public function edit(User $siswa)
    {
        if ($siswa->role !== 'siswa') abort(404);
        return view('admin.siswa.edit', compact('siswa'));
    }

    public function update(Request $request, User $siswa)
    {
        if ($siswa->role !== 'siswa') abort(404);
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . $siswa->id],
            'nis' => ['required', 'string', 'max:50', 'unique:users,nis,' . $siswa->id],
            'kelas' => ['required', 'string', 'max:50'],
            'tahun_lulus' => ['nullable', 'integer'], 
            'is_active' => ['required', 'boolean'],   
        ]);
        $siswa->update($request->all());
        return redirect()->route('admin.siswa.index')->with('success', 'Data siswa berhasil diperbarui.');
    }

    // FUNGSI UNTUK ADMIN MENGETIK PASSWORD BARU MANUAL
    public function resetPassword(Request $request, User $siswa)
    {
        if ($siswa->role !== 'siswa') abort(404);
        
        $request->validate([
            'new_password' => 'required|string|min:6'
        ]);

        $siswa->update([
            'password' => Hash::make($request->new_password)
        ]);
        
        // Selesaikan request jika ini berasal dari request siswa
        PasswordRequest::where('nis', $siswa->nis)->update(['status' => 'selesai']);

        return back()->with('success', 'Password siswa berhasil diubah menjadi: ' . $request->new_password);
    }

    // FUNGSI UNTUK MEMPROSES REQUEST DARI HALAMAN NOTIFIKASI
    public function prosesResetRequest(Request $request, $id)
    {
        $passwordReq = PasswordRequest::findOrFail($id);
        $siswa = User::where('nis', $passwordReq->nis)->orWhere('email', $passwordReq->nis)->first();

        if ($siswa) {
            $request->validate([
                'new_password' => 'required|string|min:6'
            ]);

            $siswa->update(['password' => Hash::make($request->new_password)]);
            $passwordReq->update(['status' => 'selesai']);
            
            return back()->with('success', 'Password untuk NIS ' . $passwordReq->nis . ' berhasil diubah menjadi: ' . $request->new_password);
        }

        $passwordReq->update(['status' => 'selesai']);
        return back()->with('error', 'Siswa dengan NIS/Email tersebut tidak ditemukan.');
    }
}