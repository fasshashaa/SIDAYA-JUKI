<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use ZipArchive;

class SystemMaintenanceController extends Controller
{
    private string $backupFolder = 'backups'; // relatif terhadap storage/app

    public function index()
    {
        $folderPath = storage_path("app/{$this->backupFolder}");

        $backups = collect(is_dir($folderPath) ? scandir($folderPath) : [])
            ->filter(fn ($file) => str_ends_with($file, '.zip'))
            ->map(function ($file) use ($folderPath) {
                return [
                    'name' => $file,
                    'size' => $this->formatBytes(filesize("{$folderPath}/{$file}")),
                    // TAMBAHKAN setTimezone(config('app.timezone')) DI SINI:
                    'date' => Carbon::createFromTimestamp(filemtime("{$folderPath}/{$file}"))
                                ->setTimezone(config('app.timezone'))
                                ->format('d M Y H:i'),
                ];
            })
            ->sortByDesc('date')
            ->values();

        $isDownForMaintenance = file_exists(storage_path('framework/custom_maintenance.json'));

        return view('superadmin.system.index', compact('backups', 'isDownForMaintenance'));
    }

    public function backupNow()
    {
        set_time_limit(300);

        $timestamp = now()->format('Y-m-d_His');
        $folder = storage_path("app/{$this->backupFolder}");

        if (!is_dir($folder)) {
            mkdir($folder, 0755, true);
        }

        $sqlFile = "{$folder}/db_{$timestamp}.sql";
        $zipFile = "{$folder}/backup_{$timestamp}.zip";

        // 1. Dump database
        $db = config('database.connections.mysql');
        $mysqldumpPath = env('MYSQLDUMP_PATH', 'mysqldump');

        $command = sprintf(
            '%s --user=%s --password=%s --host=%s --port=%s %s > %s 2>&1',
            escapeshellarg($mysqldumpPath),
            escapeshellarg($db['username']),
            escapeshellarg($db['password']),
            escapeshellarg($db['host']),
            escapeshellarg($db['port']),
            escapeshellarg($db['database']),
            escapeshellarg($sqlFile)
        );

        exec($command, $output, $exitCode);

        if ($exitCode !== 0 || !file_exists($sqlFile)) {
            Log::error('Backup gagal: mysqldump error', ['output' => $output]);
            return back()->with('error', 'Gagal membuat dump database. Cek MYSQLDUMP_PATH di .env.');
        }

        // 2. Kompres dump SQL + folder uploads jadi satu zip
        $zip = new ZipArchive();
        if ($zip->open($zipFile, ZipArchive::CREATE) !== true) {
            return back()->with('error', 'Gagal membuat file zip backup.');
        }

        $zip->addFile($sqlFile, "database/db_{$timestamp}.sql");

        $uploadsPath = storage_path('app/public');
        if (is_dir($uploadsPath)) {
            $this->addFolderToZip($zip, $uploadsPath, 'uploads');
        }

        $zip->close();
        @unlink($sqlFile); // hapus dump mentah, sudah ada di dalam zip

        Log::info('Backup berhasil dibuat', [
            'file' => basename($zipFile),
            'by' => auth()->user()->email ?? 'unknown',
        ]);

        return back()->with('success', 'Backup berhasil dibuat: ' . basename($zipFile));
    }

    public function download(string $filename)
    {
        $this->validateFilename($filename);

        $path = storage_path("app/{$this->backupFolder}/{$filename}");

        abort_unless(file_exists($path), 404, 'File backup tidak ditemukan.');

        return response()->download($path);
    }

    public function delete(string $filename)
    {
        $this->validateFilename($filename);

        $path = storage_path("app/{$this->backupFolder}/{$filename}");

        if (file_exists($path)) {
            unlink($path);
            Log::info('Backup dihapus', ['file' => $filename, 'by' => auth()->user()->email ?? 'unknown']);
            return back()->with('success', 'Backup berhasil dihapus.');
        }

        return back()->with('error', 'File backup tidak ditemukan.');
    }

    public function maintenanceOn(Request $request)
    {
        $request->validate([
            'message' => 'nullable|string|max:255',
        ]);

        $maintenanceFile = storage_path('framework/custom_maintenance.json');

        // Simpan status maintenance dan pesan kustom ke dalam file json
        $data = [
            'is_maintenance' => true,
            'message' => $request->input('message', 'Sistem sedang dalam pemeliharaan. Mohon coba beberapa saat lagi.'),
            'activated_at' => now()->toDateTimeString(),
        ];

        file_put_contents($maintenanceFile, json_encode($data));

        Log::warning('Maintenance mode berbasis Role diaktifkan', ['by' => auth()->user()->email ?? 'unknown']);

        return back()->with('success', 'Mode pemeliharaan diaktifkan untuk Pelanggan/User/Admin. SuperAdmin tetap dapat mengakses sistem.');
    }

    public function maintenanceOff()
    {
        $maintenanceFile = storage_path('framework/custom_maintenance.json');

        // Hapus file json untuk membuat sistem online kembali bagi semua orang
        if (file_exists($maintenanceFile)) {
            unlink($maintenanceFile);
        }

        Log::warning('Maintenance mode dinonaktifkan', ['by' => auth()->user()->email ?? 'unknown']);

        return back()->with('success', 'Sistem kembali online untuk semua pengguna.');
    }

    private function addFolderToZip(ZipArchive $zip, string $folder, string $zipFolderName): void
    {
        $files = new \RecursiveIteratorIterator(
            new \RecursiveDirectoryIterator($folder, \RecursiveDirectoryIterator::SKIP_DOTS)
        );

        foreach ($files as $file) {
            if ($file->isFile()) {
                $filePath = $file->getRealPath();
                $relativePath = $zipFolderName . '/' . substr($filePath, strlen($folder) + 1);
                $zip->addFile($filePath, $relativePath);
            }
        }
    }

    private function validateFilename(string $filename): void
    {
        abort_if(
            str_contains($filename, '..') || str_contains($filename, '/') || !str_ends_with($filename, '.zip'),
            400,
            'Nama file tidak valid.'
        );
    }

    private function formatBytes(int $bytes): string
    {
        $units = ['B', 'KB', 'MB', 'GB'];
        $i = 0;
        while ($bytes >= 1024 && $i < count($units) - 1) {
            $bytes /= 1024;
            $i++;
        }
        return round($bytes, 2) . ' ' . $units[$i];
    }
}