<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use ZipArchive;
use Illuminate\Support\Facades\File;

class UpdateController extends Controller
{
    // URL server pusat milikmu (simulasi)
    protected $updateServer = 'https://update.perusahaanmu.com/versi.json';

    public function index()
    {
        // Cek versi saat ini (bisa disimpan di config atau database)
        $currentVersion = config('app.version', '1.0.0'); 
        return view('admin.update.index', compact('currentVersion'));
    }

    public function checkUpdate()
    {
        try {
            // Ambil data versi terbaru dari server
            $response = Http::get($this->updateServer);
            $latestData = $response->json();

            $currentVersion = config('app.version', '1.0.0');

            if (version_compare($latestData['version'], $currentVersion, '>')) {
                return response()->json([
                    'status' => 'available',
                    'data' => $latestData
                ]);
            }

            return response()->json(['status' => 'up_to_date']);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()]);
        }
    }

    public function installUpdate(Request $request)
    {
        // 1. Download File Zip dari server pusat
        $downloadUrl = $request->download_url;
        $zipFile = storage_path('app/update.zip');
        
        file_put_contents($zipFile, file_get_contents($downloadUrl));

        // 2. Ekstrak File Zip
        $zip = new ZipArchive;
        if ($zip->open($zipFile) === TRUE) {
            // Ekstrak ke folder root Laravel (hati-hati dengan folder vendor dan .env)
            // PENTING: Pastikan zip tidak menimpa file .env atau folder storage!
            $zip->extractTo(base_path()); 
            $zip->close();
        }

        // 3. Hapus file zip setelah diekstrak
        unlink($zipFile);

        // 4. Update config versi di .env (jika perlu) atau database
        // (Butuh logika tambahan untuk mengubah nilai APP_VERSION di .env)

        // 5. Bersihkan Cache Laravel
        \Artisan::call('optimize:clear');

        return response()->json(['status' => 'success', 'message' => 'Aplikasi berhasil diupdate!']);
    }
}