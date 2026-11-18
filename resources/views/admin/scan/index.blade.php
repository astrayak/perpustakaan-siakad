@extends('layouts.admin')

@section('title', 'Scan QR Peminjaman')

@section('content')
    <div class="max-w-2xl mx-auto">
        <div class="bg-white p-6 rounded-lg shadow">
            <h3 class="text-lg font-semibold mb-4 text-gray-700">Arahkan Kamera ke QR Code Siswa</h3>
            
            <!-- Area Kamera -->
            <div id="reader" class="w-full bg-black rounded-lg overflow-hidden"></div>
            
            <!-- Form Manual (Jika kamera error) -->
            <div class="mt-6 border-t pt-4">
                <p class="text-sm text-gray-500 mb-2">Atau masukkan token QR secara manual:</p>
                <form id="manualForm" class="flex gap-2">
                    <input type="text" id="manualToken" class="flex-1 border p-2 rounded focus:outline-none focus:ring-2 focus:ring-indigo-500" placeholder="Paste token QR di sini...">
                    <button type="submit" class="bg-gray-800 text-white px-4 py-2 rounded hover:bg-gray-900">Proses</button>
                </form>
            </div>

            <!-- Hasil Scan -->
            <div id="result" class="mt-6 hidden p-4 rounded-lg"></div>
        </div>
    </div>
@endsection

@push('scripts')
<!-- Library HTML5 QR Code Scanner -->
<script src="https://unpkg.com/html5-qrcode" type="text/javascript"></script>
<script>
    const html5QrCode = new Html5Qrcode("reader");
    const qrConfig = { fps: 10, qrbox: { width: 250, height: 250 } };

    // Callback saat QR berhasil discan
    function onScanSuccess(decodedText, decodedResult) {
        html5QrCode.pause(); // Pause kamera sementara
        prosesQR(decodedText);
    }

    // Mulai Kamera
    html5QrCode.start({ facingMode: "environment" }, qrConfig, onScanSuccess)
        .catch(err => {
            console.error("Gagal start kamera: ", err);
            document.getElementById('reader').innerHTML = '<p class="p-4 text-red-500">Kamera gagal dibuka. Pastikan izin diberikan atau gunakan input manual.</p>';
        });

    // Form Manual Submit
    document.getElementById('manualForm').addEventListener('submit', function(e) {
        e.preventDefault();
        const token = document.getElementById('manualToken').value;
        if(token) prosesQR(token);
    });

    // Fungsi kirim ke server
    function prosesQR(token) {
        const resultDiv = document.getElementById('result');
        resultDiv.className = 'mt-6 p-4 rounded-lg bg-gray-100 text-gray-700';
        resultDiv.innerHTML = 'Memproses...';
        resultDiv.classList.remove('hidden');

        fetch("{{ route('admin.scan.proses') }}", {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ qr_token: token })
        })
        .then(res => res.json())
        .then(data => {
            if(data.success) {
                resultDiv.className = 'mt-6 p-4 rounded-lg bg-green-100 text-green-800 border border-green-300 font-semibold';
                resultDiv.innerHTML = '✅ ' + data.message;
            } else {
                resultDiv.className = 'mt-6 p-4 rounded-lg bg-red-100 text-red-800 border border-red-300 font-semibold';
                resultDiv.innerHTML = '❌ ' + data.message;
            }
        })
        .catch(err => {
            resultDiv.className = 'mt-6 p-4 rounded-lg bg-red-100 text-red-800';
            resultDiv.innerHTML = 'Terjadi kesalahan sistem.';
        })
        .finally(() => {
            setTimeout(() => { html5QrCode.resume(); }, 3000); // Lanjut kamera setelah 3 detik
        });
    }
</script>
@endpush