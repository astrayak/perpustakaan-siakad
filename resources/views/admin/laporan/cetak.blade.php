<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Cetak Laporan</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style> @media print { .no-print { display: none; } body { background: white; } } </style>
</head>
<body class="bg-gray-100 p-8">
    <div class="max-w-4xl mx-auto bg-white p-8 shadow-md">
        <div class="text-center mb-8 border-b pb-4">
            <h1 class="text-2xl font-bold">LAPORAN PERPUSTAKAAN</h1>
            <p class="text-gray-600">Jenis Laporan: {{ strtoupper($jenis) }}</p>
        </div>

        <table class="w-full border-collapse text-sm">
            @if($jenis == 'buku')
                <thead class="bg-gray-200"><tr><th class="border p-2">Judul</th><th class="border p-2">Kategori</th><th class="border p-2">Stok</th></tr></thead>
                <tbody>@foreach($data as $d) <tr><td class="border p-2">{{ $d->judul }}</td><td class="border p-2">{{ $d->kategori->nama_kategori }}</td><td class="border p-2">{{ $d->stok_total }}</td></tr> @endforeach</tbody>
            @elseif($jenis == 'pendapatan')
                <thead class="bg-gray-200"><tr><th class="border p-2">Tanggal</th><th class="border p-2">Siswa</th><th class="border p-2">Denda Dibayar</th></tr></thead>
                <tbody>@foreach($data as $d) <tr><td class="border p-2">{{ $d->tanggal_kembali }}</td><td class="border p-2">{{ $d->user->name }}</td><td class="border p-2">Rp {{ number_format($d->denda, 0, ',', '.') }}</td></tr> @endforeach</tbody>
            @endif
        </table>

        <div class="mt-8 text-right no-print">
            <button onclick="window.print()" class="bg-[#6C5DD3] text-white px-6 py-2 rounded shadow">Cetak Sekarang</button>
        </div>
    </div>
</body>
</html>