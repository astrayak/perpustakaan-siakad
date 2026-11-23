
@extends('layouts.siswa')

@section('content')

    <!-- JUDUL HALAMAN -->
    <div class="mb-6">
        <h2 class="text-2xl font-bold text-gray-800">
            Riwayat Peminjaman
        </h2>

        <p class="text-gray-500 text-sm mt-1">
            Daftar buku yang pernah dan sedang Anda pinjam.
        </p>
    </div>


    <!-- ==========================================
         TAMPILAN MOBILE & TABLET (CARD)
    =========================================== -->

    <div class="block lg:hidden space-y-4">

        @forelse($peminjamans as $p)

            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-4">

                <!-- HEADER CARD -->
                <div class="flex items-start justify-between gap-3 mb-4">

                    <div class="min-w-0">

                        <h3 class="font-bold text-gray-800 text-base break-words">
                            {{ $p->buku->judul }}
                        </h3>

                        <p class="text-xs text-gray-400 mt-1 break-all">
                            {{ $p->kode_peminjaman }}
                        </p>

                    </div>

                    <!-- STATUS -->
                    <div class="flex-shrink-0">

                        @if($p->status == 'menunggu_diambil')
                            <span class="inline-block bg-orange-100 text-orange-700 px-3 py-1.5 rounded-full text-xs font-bold">
                                Menunggu Diambil
                            </span>

                        @elseif($p->status == 'dipinjam')
                            <span class="inline-block bg-blue-100 text-blue-700 px-3 py-1.5 rounded-full text-xs font-bold">
                                Sedang Dipinjam
                            </span>

                        @elseif($p->status == 'dikembalikan')
                            <span class="inline-block bg-green-100 text-green-700 px-3 py-1.5 rounded-full text-xs font-bold">
                                Selesai
                            </span>

                        @elseif($p->status == 'terlambat')
                            <span class="inline-block bg-red-100 text-red-700 px-3 py-1.5 rounded-full text-xs font-bold">
                                Terlambat
                            </span>

                        @elseif($p->status == 'dibatalkan')
                            <span class="inline-block bg-gray-100 text-gray-700 px-3 py-1.5 rounded-full text-xs font-bold">
                                Dibatalkan
                            </span>

                        @else
                            <span class="inline-block bg-gray-100 text-gray-700 px-3 py-1.5 rounded-full text-xs font-bold">
                                {{ $p->status }}
                            </span>
                        @endif

                    </div>

                </div>


                <!-- PEMBATAS -->
                <div class="border-t border-gray-100 my-3"></div>


                <!-- INFORMASI TANGGAL -->
                <div class="grid grid-cols-2 gap-3 mb-4">

                    <div class="bg-gray-50 rounded-xl p-3">

                        <p class="text-xs text-gray-500 mb-1">
                            <i class="fa-regular fa-calendar mr-1"></i>
                            Tanggal Pinjam
                        </p>

                        <p class="text-sm font-semibold text-gray-800">
                            {{ $p->tanggal_pinjam->format('d/m/Y') }}
                        </p>

                    </div>


                    <div class="bg-gray-50 rounded-xl p-3">

                        <p class="text-xs text-gray-500 mb-1">
                            <i class="fa-regular fa-clock mr-1"></i>
                            Jatuh Tempo
                        </p>

                        <p class="text-sm font-semibold {{ \Carbon\Carbon::now()->greaterThan($p->tanggal_jatuh_tempo) && $p->status != 'dikembalikan' ? 'text-red-500' : 'text-gray-800' }}">

                            {{ $p->tanggal_jatuh_tempo->format('d/m/Y') }}

                        </p>

                    </div>

                </div>


                <!-- TOMBOL AKSI -->
                @if($p->status == 'menunggu_diambil')

                    <div class="flex flex-col sm:flex-row gap-2">

                        <a href="{{ route('siswa.peminjaman.qr', $p->id) }}"
                           class="flex-1 inline-flex items-center justify-center gap-2 bg-[#6C5DD3] text-white px-4 py-3 rounded-xl text-sm font-semibold hover:bg-[#5a4cb1] transition-all">

                            <i class="fa-solid fa-qrcode"></i>
                            Lihat QR

                        </a>


                        <form action="{{ route('siswa.peminjaman.batalkan', $p->id) }}"
                              method="POST"
                              class="flex-1"
                              onsubmit="return confirm('Apakah Anda yakin ingin membatalkan peminjaman ini?');">

                            @csrf
                            @method('PATCH')

                            <button type="submit"
                                    class="w-full inline-flex items-center justify-center gap-2 bg-red-500 text-white px-4 py-3 rounded-xl text-sm font-semibold hover:bg-red-600 transition-all">

                                <i class="fa-solid fa-xmark"></i>
                                Batalkan

                            </button>

                        </form>

                    </div>

                @elseif($p->status == 'dipinjam' || $p->status == 'terlambat')

                    <a href="{{ route('siswa.peminjaman.qr_kembali', $p->id) }}"
                       class="w-full inline-flex items-center justify-center gap-2 bg-orange-500 text-white px-4 py-3 rounded-xl text-sm font-semibold hover:bg-orange-600 transition-all">

                        <i class="fa-solid fa-rotate-left"></i>
                        Kembalikan Buku

                    </a>

                @endif

            </div>

        @empty

            <!-- KOSONG -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8 text-center">

                <i class="fa-solid fa-clock-rotate-left text-4xl text-gray-300 mb-3"></i>

                <p class="text-gray-500 text-sm">
                    Belum ada riwayat peminjaman.
                </p>

            </div>

        @endforelse

    </div>


    <!-- ==========================================
         TAMPILAN DESKTOP (TABEL)
    =========================================== -->

    <div class="hidden lg:block bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">

        <div class="overflow-x-auto">

            <table class="w-full text-left border-collapse">

                <thead class="bg-gray-50 border-b border-gray-100">

                    <tr>

                        <th class="p-4 text-sm font-semibold text-gray-600">
                            Buku
                        </th>

                        <th class="p-4 text-sm font-semibold text-gray-600">
                            Tgl Pinjam
                        </th>

                        <th class="p-4 text-sm font-semibold text-gray-600">
                            Jatuh Tempo
                        </th>

                        <th class="p-4 text-sm font-semibold text-gray-600">
                            Status
                        </th>

                        <th class="p-4 text-sm font-semibold text-gray-600 text-center">
                            Aksi
                        </th>

                    </tr>

                </thead>


                <tbody>

                    @forelse($peminjamans as $p)

                        <tr class="hover:bg-gray-50 border-b border-gray-50 transition-colors">

                            <!-- BUKU -->
                            <td class="p-4">

                                <div class="font-bold text-gray-800">
                                    {{ $p->buku->judul }}
                                </div>

                                <div class="text-xs text-gray-500">
                                    {{ $p->kode_peminjaman }}
                                </div>

                            </td>


                            <!-- TANGGAL PINJAM -->
                            <td class="p-4 text-sm text-gray-600">

                                {{ $p->tanggal_pinjam->format('d/m/Y') }}

                            </td>


                            <!-- JATUH TEMPO -->
                            <td class="p-4 text-sm font-medium {{ \Carbon\Carbon::now()->greaterThan($p->tanggal_jatuh_tempo) && $p->status != 'dikembalikan' ? 'text-red-500' : 'text-gray-600' }}">

                                {{ $p->tanggal_jatuh_tempo->format('d/m/Y') }}

                            </td>


                            <!-- STATUS -->
                            <td class="p-4">

                                @if($p->status == 'menunggu_diambil')

                                    <span class="bg-orange-100 text-orange-700 px-3 py-1 rounded-full text-xs font-bold">
                                        Tunggu Diambil
                                    </span>

                                @elseif($p->status == 'dipinjam')

                                    <span class="bg-blue-100 text-blue-700 px-3 py-1 rounded-full text-xs font-bold">
                                        Sedang Dipinjam
                                    </span>

                                @elseif($p->status == 'dikembalikan')

                                    <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-xs font-bold">
                                        Selesai
                                    </span>

                                @elseif($p->status == 'terlambat')

                                    <span class="bg-red-100 text-red-700 px-3 py-1 rounded-full text-xs font-bold">
                                        Terlambat
                                    </span>

                                @elseif($p->status == 'dibatalkan')

                                    <span class="bg-gray-100 text-gray-700 px-3 py-1 rounded-full text-xs font-bold">
                                        Dibatalkan
                                    </span>

                                @else

                                    <span class="bg-gray-100 text-gray-700 px-3 py-1 rounded-full text-xs font-bold">
                                        {{ $p->status }}
                                    </span>

                                @endif

                            </td>


                            <!-- AKSI -->
                            <td class="p-4 text-center">

                                @if($p->status == 'menunggu_diambil')

                                    <a href="{{ route('siswa.peminjaman.qr', $p->id) }}"
                                       class="inline-block bg-[#6C5DD3] text-white px-3 py-1.5 rounded-lg text-sm font-semibold hover:bg-[#5a4cb1] shadow-sm transition-all mr-1">

                                        <i class="fa-solid fa-qrcode mr-1"></i>
                                        QR

                                    </a>


                                    <form action="{{ route('siswa.peminjaman.batalkan', $p->id) }}"
                                          method="POST"
                                          class="inline"
                                          onsubmit="return confirm('Apakah Anda yakin ingin membatalkan peminjaman ini?');">

                                        @csrf
                                        @method('PATCH')

                                        <button type="submit"
                                                class="bg-red-500 text-white px-3 py-1.5 rounded-lg text-sm font-semibold hover:bg-red-600 shadow-sm transition-all">

                                            Batal

                                        </button>

                                    </form>


                                @elseif($p->status == 'dipinjam' || $p->status == 'terlambat')

                                    <a href="{{ route('siswa.peminjaman.qr_kembali', $p->id) }}"
                                       class="inline-block bg-orange-500 text-white px-4 py-2 rounded-xl text-sm font-semibold hover:bg-orange-600 shadow-sm transition-all">

                                        <i class="fa-solid fa-rotate-left mr-1"></i>
                                        Kembalikan

                                    </a>

                                @else

                                    <span class="text-gray-400 text-sm">
                                        -
                                    </span>

                                @endif

                            </td>

                        </tr>


                    @empty

                        <tr>

                            <td colspan="5" class="p-10 text-center text-gray-500">

                                <i class="fa-solid fa-clock-rotate-left text-4xl text-gray-300 mb-3"></i>

                                <p>
                                    Belum ada riwayat peminjaman.
                                </p>

                            </td>

                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </div>


    <!-- ==========================================
         PAGINATION
    =========================================== -->

    <div class="mt-6">

        {{ $peminjamans->links() }}

    </div>

@endsection
