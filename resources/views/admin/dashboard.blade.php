@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')
    
    <!-- Banner Selamat Datang -->
    <div class="bg-gradient-to-r from-[#6C5DD3] to-[#8F82E2] rounded-3xl p-8 text-white mb-8 relative overflow-hidden shadow-lg flex justify-between items-center">
        <div class="relative z-10 md:w-2/3">
            <h2 class="text-3xl font-bold mb-2">Halo, Admin! 👋</h2>
            <p class="text-white/80">Selamat datang kembali di Sistem Perpustakaan. Berikut adalah ringkasan data hari ini.</p>
        </div>
        <i class="fa-solid fa-book-bookmark absolute right-10 -bottom-4 text-9xl text-white/10 z-0"></i>
    </div>

    <!-- NOTIFIKASI REQUEST PASSWORD -->
    @if($passwordRequests->count() > 0)
        <div class="bg-orange-50 border-l-4 border-orange-500 p-5 rounded-2xl mb-8 shadow-sm flex items-start gap-4">
            <div class="bg-orange-500 text-white p-2 rounded-full mt-1">
                <i class="fa-solid fa-bell animate-bounce"></i>
            </div>
            <div>
                <h4 class="font-bold text-orange-800 text-lg mb-1">Ada {{ $passwordRequests->count() }} Permintaan Lupa Password!</h4>
                <ul class="list-disc list-inside text-sm text-orange-700 space-y-1">
                    @foreach($passwordRequests as $req)
                        <li>NIS/Email: <b>{{ $req->nis }}</b> ({{ $req->alasan ?? 'Tanpa alasan' }}) - <a href="{{ route('admin.siswa.index') }}" class="underline font-bold hover:text-orange-900">Proses di Data Siswa</a></li>
                    @endforeach
                </ul>
            </div>
        </div>
    @endif

    <!-- Kartu Statistik (Atas) -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <!-- Total Buku -->
        <div class="bg-gradient-to-br from-[#6C5DD3] to-[#8F82E2] rounded-2xl p-6 text-white shadow-md relative overflow-hidden">
            <div class="flex justify-between items-start mb-4">
                <div class="bg-white/20 p-3 rounded-xl backdrop-blur-sm"><i class="fa-solid fa-book text-2xl"></i></div>
                <span class="text-xs bg-white/20 px-2 py-1 rounded-full">Total</span>
            </div>
            <h3 class="text-4xl font-bold mb-1">{{ $totalBuku }}</h3>
            <p class="text-white/80 font-medium">Buku Terdaftar</p>
        </div>

        <!-- Total Siswa -->
        <div class="bg-gradient-to-br from-[#FFB319] to-[#FFCE56] rounded-2xl p-6 text-white shadow-md relative overflow-hidden">
            <div class="flex justify-between items-start mb-4">
                <div class="bg-white/20 p-3 rounded-xl backdrop-blur-sm"><i class="fa-solid fa-users text-2xl"></i></div>
                <span class="text-xs bg-white/20 px-2 py-1 rounded-full">Siswa</span>
            </div>
            <h3 class="text-4xl font-bold mb-1">{{ $totalSiswa }}</h3>
            <p class="text-white/80 font-medium">Siswa Aktif</p>
        </div>

        <!-- Menunggu Diambil -->
        <div class="bg-gradient-to-br from-[#FF7A59] to-[#FF9D85] rounded-2xl p-6 text-white shadow-md relative overflow-hidden">
            <div class="flex justify-between items-start mb-4">
                <div class="bg-white/20 p-3 rounded-xl backdrop-blur-sm"><i class="fa-solid fa-clock text-2xl"></i></div>
                <span class="text-xs bg-white/20 px-2 py-1 rounded-full">Antrean</span>
            </div>
            <h3 class="text-4xl font-bold mb-1">{{ $menungguDiambil }}</h3>
            <p class="text-white/80 font-medium">Menunggu Diambil</p>
        </div>

        <!-- Sedang Dipinjam -->
        <div class="bg-gradient-to-br from-[#00C6FF] to-[#00E0FF] rounded-2xl p-6 text-white shadow-md relative overflow-hidden">
            <div class="flex justify-between items-start mb-4">
                <div class="bg-white/20 p-3 rounded-xl backdrop-blur-sm"><i class="fa-solid fa-hand-holding-hand text-2xl"></i></div>
                <span class="text-xs bg-white/20 px-2 py-1 rounded-full">Aktif</span>
            </div>
            <h3 class="text-4xl font-bold mb-1">{{ $sedangDipinjam }}</h3>
            <p class="text-white/80 font-medium">Sedang Dipinjam</p>
        </div>
    </div>

    <!-- AREA GRAFIK (2 Atas, 2 Bawah) -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
        
        <!-- Grafik 1: Top 5 Buku -->
        <div class="bg-white rounded-3xl p-6 shadow-sm border border-gray-100">
            <h3 class="text-lg font-bold text-gray-800 mb-4"><i class="fa-solid fa-chart-bar text-[#6C5DD3] mr-2"></i> Top 5 Buku Sering Dipinjam</h3>
            <div class="relative h-72 w-full">
                <canvas id="chartBuku"></canvas>
            </div>
        </div>

        <!-- Grafik 2: Top 5 Siswa -->
        <div class="bg-white rounded-3xl p-6 shadow-sm border border-gray-100">
            <h3 class="text-lg font-bold text-gray-800 mb-4"><i class="fa-solid fa-user-graduate text-[#FFB319] mr-2"></i> Siswa Paling Sering Meminjam</h3>
            <div class="relative h-72 w-full">
                <canvas id="chartSiswa"></canvas>
            </div>
        </div>

        <!-- Grafik 3: Peminjaman 5 Tahun Terakhir (Bar Chart) -->
        <div class="bg-white rounded-3xl p-6 shadow-sm border border-gray-100">
            <h3 class="text-lg font-bold text-gray-800 mb-4"><i class="fa-solid fa-chart-line text-[#00C6FF] mr-2"></i> Tren Peminjaman 5 Tahun Terakhir</h3>
            <div class="relative h-72 w-full">
                <canvas id="chartTahun"></canvas>
            </div>
        </div>

        <!-- Grafik 4: Status Peminjaman (Doughnut Chart) -->
        <div class="bg-white rounded-3xl p-6 shadow-sm border border-gray-100">
            <h3 class="text-lg font-bold text-gray-800 mb-4"><i class="fa-solid fa-chart-pie text-[#FF7A59] mr-2"></i> Status Peminjaman Saat Ini</h3>
            <div class="relative h-72 w-full flex justify-center">
                <canvas id="chartStatus"></canvas>
            </div>
        </div>

    </div>

    <!-- AREA LOG LOGIN TERBARU (2 BARIS x 5 KOLOM) -->
    <div class="mt-8">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-lg font-bold text-gray-800"><i class="fa-solid fa-users-viewfinder text-[#6C5DD3] mr-2"></i> 10 Aktivitas Login Terbaru</h3>
            <a href="{{ route('admin.log.index') }}" class="text-sm font-semibold text-[#6C5DD3] hover:underline">Lihat Semua</a>
        </div>
        
        <!-- Grid 5 Kolom -->
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-4">
            @foreach($recentLogins as $log)
                <div class="bg-white rounded-2xl p-4 shadow-sm border border-gray-100 flex flex-col items-center text-center hover:shadow-md transition-shadow relative overflow-hidden group">
                    
                    <!-- Garis Warna Atas -->
                    <div class="absolute top-0 left-0 w-full h-1 {{ $log->role == 'admin' ? 'bg-[#6C5DD3]' : 'bg-[#FFB319]' }}"></div>

                    <!-- FOTO / INISIAL -->
                    <div class="w-14 h-14 mt-2 mb-3 rounded-full flex items-center justify-center text-white font-bold text-xl shadow-inner
                        {{ $log->role == 'admin' ? 'bg-gradient-to-br from-[#6C5DD3] to-[#8F82E2]' : 'bg-gradient-to-br from-[#FFB319] to-[#FFCE56]' }}">
                        {{ substr($log->name, 0, 1) }}
                    </div>

                    <!-- NAMA & ROLE -->
                    <h4 class="font-bold text-gray-800 text-sm leading-tight truncate w-full" title="{{ $log->name }}">{{ $log->name }}</h4>
                    <span class="text-[10px] font-bold px-2 py-0.5 rounded-full mt-1 mb-2
                        {{ $log->role == 'admin' ? 'bg-indigo-50 text-indigo-600' : 'bg-yellow-50 text-yellow-600' }}">
                        {{ strtoupper($log->role) }}
                    </span>

                    <!-- WAKTU LOGIN -->
                    <div class="mt-auto bg-gray-50 w-full py-2 rounded-xl text-xs text-gray-500 border border-gray-100 flex flex-col items-center justify-center gap-1 group-hover:bg-white transition-colors">
                        <span class="font-semibold text-gray-700"><i class="fa-regular fa-clock mr-1"></i> {{ $log->login_at->format('H:i') }}</span>
                        <span class="text-[10px]">{{ $log->login_at->diffForHumans() }}</span>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

@endsection

@push('scripts')
<!-- Panggil Library Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // 1. GRAFIK BUKU
        const ctxBuku = document.getElementById('chartBuku').getContext('2d');
        new Chart(ctxBuku, {
            type: 'bar',
            data: {
                labels: {!! json_encode($topBuku->pluck('buku.judul')) !!},
                datasets: [{
                    label: 'Total Dipinjam',
                    data: {!! json_encode($topBuku->pluck('total')) !!},
                    backgroundColor: '#6C5DD3',
                    borderRadius: 8
                }]
            },
            options: { responsive: true, maintainAspectRatio: false, plugins: { legend: { display: false } } }
        });

        // 2. GRAFIK SISWA (TYPO SUDAH DIPERBAIKI)
        const ctxSiswa = document.getElementById('chartSiswa').getContext('2d');
        new Chart(ctxSiswa, {
            type: 'bar',
            data: {
                labels: {!! json_encode($topSiswa->pluck('user.name')) !!},
                datasets: [{
                    label: 'Total Meminjam',
                    data: {!! json_encode($topSiswa->pluck('total')) !!},
                    backgroundColor: '#FFB319',
                    borderRadius: 8
                }]
            },
            options: { responsive: true, maintainAspectRatio: false, plugins: { legend: { display: false } } }
        });

        // 3. GRAFIK TAHUNAN
        const ctxTahun = document.getElementById('chartTahun').getContext('2d');
        new Chart(ctxTahun, {
            type: 'line',
            data: {
                labels: {!! json_encode($labelsTahun) !!},
                datasets: [{
                    label: 'Peminjaman',
                    data: {!! json_encode($dataTahun) !!},
                    borderColor: '#00C6FF',
                    backgroundColor: 'rgba(0, 198, 255, 0.1)',
                    fill: true,
                    tension: 0.4,
                    pointBackgroundColor: '#00C6FF',
                    pointRadius: 5
                }]
            },
            options: { responsive: true, maintainAspectRatio: false }
        });

        // 4. GRAFIK STATUS (Doughnut)
        const ctxStatus = document.getElementById('chartStatus').getContext('2d');
        new Chart(ctxStatus, {
            type: 'doughnut',
            data: {
                labels: ['Menunggu', 'Dipinjam', 'Dikembalikan'],
                datasets: [{
                    data: [
                        {{ $menungguDiambil }}, 
                        {{ $sedangDipinjam }}, 
                        {{ \App\Models\Peminjaman::where('status', 'dikembalikan')->count() }}
                    ],
                    backgroundColor: ['#FFB319', '#00C6FF', '#10B981'],
                    borderWidth: 0,
                    hoverOffset: 4
                }]
            },
            options: { responsive: true, maintainAspectRatio: false, cutout: '70%' }
        });
    });
</script>
@endpush