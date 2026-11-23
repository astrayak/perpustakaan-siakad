@extends('layouts.admin')

@section('title', 'Update Sistem')

@section('content')
    <div class="bg-white rounded-3xl p-8 shadow-sm border border-gray-100 max-w-2xl mx-auto mt-10">
        <div class="text-center mb-8">
            <div class="w-24 h-24 bg-indigo-50 rounded-full flex items-center justify-center mx-auto mb-4">
                <i class="fa-solid fa-cloud-arrow-down text-5xl text-[#6C5DD3]"></i>
            </div>
            <h2 class="text-2xl font-bold text-gray-800">Pembaruan Sistem</h2>
            <p class="text-gray-500 mt-2">Versi saat ini: <span class="font-bold text-gray-800">{{ $currentVersion }}</span></p>
        </div>

        <div id="update-status" class="mb-6 text-center text-gray-600 bg-gray-50 p-4 rounded-xl border border-gray-100">
            Klik tombol di bawah untuk mengecek pembaruan terbaru.
        </div>

        <button id="btn-check" onclick="cekUpdate()" class="w-full bg-[#6C5DD3] hover:bg-[#5a4cb1] text-white font-bold py-3 rounded-xl shadow-lg transition-all flex justify-center items-center gap-2">
            <i class="fa-solid fa-magnifying-glass"></i> Cek Pembaruan
        </button>

        <button id="btn-install" onclick="installUpdate()" class="w-full bg-green-500 hover:bg-green-600 text-white font-bold py-3 rounded-xl shadow-lg transition-all hidden mt-4 flex justify-center items-center gap-2">
            <i class="fa-solid fa-download"></i> Unduh & Pasang Pembaruan
        </button>
    </div>
@endsection

@push('scripts')
<script>
    let updateData = null;

    function cekUpdate() {
        const btn = document.getElementById('btn-check');
        const statusDiv = document.getElementById('update-status');
        
        btn.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i> Mengecek...';
        btn.disabled = true;

        // Simulasi delay jaringan
        setTimeout(() => {
            fetch("{{ route('admin.update.check') }}")
                .then(res => res.json())
                .then(data => {
                    btn.innerHTML = '<i class="fa-solid fa-magnifying-glass"></i> Cek Pembaruan Lagi';
                    btn.disabled = false;

                    if (data.status === 'available') {
                        updateData = data.data;
                        statusDiv.innerHTML = `
                            <div class="bg-yellow-50 border border-yellow-200 p-4 rounded-xl text-left">
                                <p class="font-bold text-yellow-800 mb-1"><i class="fa-solid fa-star"></i> Pembaruan Tersedia (v${data.data.version})</p>
                                <p class="text-sm text-yellow-700 mb-2">Tanggal Rilis: ${data.data.release_date}</p>
                                <p class="text-sm text-yellow-700"><b>Catatan Rilis:</b> ${data.data.changelog}</p>
                            </div>
                        `;
                        document.getElementById('btn-install').classList.remove('hidden');
                    } else {
                        statusDiv.innerHTML = `<span class="text-green-600 font-bold"><i class="fa-solid fa-check-circle"></i> Aplikasi sudah versi terbaru.</span>`;
                    }
                });
        }, 1000); // delay 1 detik
    }

    function installUpdate() {
        if(!updateData) return;
        
        // Konfirmasi menggunakan SweetAlert
        Swal.fire({
            title: 'Mulai Pembaruan?',
            text: "Website tidak dapat diakses sementara selama proses update.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#6C5DD3',
            cancelButtonColor: '#9ca3af',
            confirmButtonText: 'Ya, Update Sekarang!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                // Tampilkan loading
                Swal.fire({
                    title: 'Menginstall Update...',
                    text: 'Mohon tunggu, jangan tutup browser ini.',
                    allowOutsideClick: false,
                    didOpen: () => { Swal.showLoading() }
                });

                fetch("{{ route('admin.update.install') }}", {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({ download_url: updateData.download_url })
                })
                .then(res => res.json())
                .then(data => {
                    if(data.status === 'success') {
                        Swal.fire('Berhasil!', data.message, 'success').then(() => {
                            window.location.reload();
                        });
                    } else {
                        Swal.fire('Gagal', 'Terjadi kesalahan saat menginstall update.', 'error');
                    }
                });
            }
        });
    }
</script>
@endpush