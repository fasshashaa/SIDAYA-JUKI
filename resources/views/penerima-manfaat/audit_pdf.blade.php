<!DOCTYPE html>
<html>
<head>
    <title>Laporan Audit Trail Logs</title>
    <style>
        body { font-family: sans-serif; font-size: 11px; color: #333; }
        .header { text-align: center; margin-bottom: 20px; border-bottom: 2px solid #000; padding-bottom: 10px; }
        .header h2 { margin: 0; padding: 0; color: #1a365d; }
        .header p { margin: 5px 0 0 0; font-size: 12px; color: #4a5568; }
        .meta-info { margin-bottom: 15px; font-size: 10px; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th { bg-color: #2d3748; color: #ffffff; padding: 8px; text-align: left; font-weight: bold; border: 1px solid #cbd5e0; }
        td { padding: 6px 8px; border: 1px solid #cbd5e0; vertical-align: top; }
        tr:nth-child(even) { background-color: #f7fafc; }
        .badge { padding: 2px 6px; border-radius: 4px; font-weight: bold; font-size: 9px; text-align: center; display: inline-block; }
        .badge-update { background-color: #feebc8; color: #c05621; }
        .badge-delete { background-color: #fed7d7; color: #9b2c2c; }
        .badge-create { background-color: #c6f6d5; color: #22543d; }
        .footer { position: fixed; bottom: 0; width: 100%; text-align: right; font-size: 8px; color: #718096; border-top: 1px solid #e2e8f0; padding-top: 5px; }
    </style>
</head>
<body>

    <div class="header">
        <h2>SIDAYA CILACAP - AUDIT TRAIL REKOR</h2>
        <p>Dokumen Kepatuhan Keamanan Informasi (ISO 27001 - Kontrol A.8.15)</p>
    </div>

    <div class="meta-info">
        <strong>Tanggal Cetak:</strong> {{ \Carbon\Carbon::now()->translatedFormat('d F Y H:i:s') }} WIB <br>
        <strong>Otoritas Pengunduh:</strong> {{ auth()->user()->name }} ({{ auth()->user()->role }})<br>
        <strong>Status Integritas:</strong> Terproteksi Sistem (Anti-Tampering Aktif)
    </div>

    <table>
        <thead>
            <tr>
                <th style="width: 15%;">Waktu & IP</th>
                <th style="width: 20%;">Pengguna</th>
                <th style="width: 10%;">Event</th>
                <th style="width: 15%;">Modul & ID</th>
                <th style="width: 40%;">Ringkasan Perubahan</th>
            </tr>
        </thead>
        <tbody>
            @foreach($logs as $log)
                <tr>
                    <td>
                        <strong>{{ $log->created_at->format('d/m/Y H:i:s') }}</strong><br>
                        <span style="color: #718096;">{{ $log->ip_address }}</span>
                    </td>
                    <td>
                        <strong>{{ $log->user ? $log->user->name : 'Sistem / Anonim' }}</strong><br>
                        <span style="color: #718096;">{{ $log->user ? $log->user->role : '-' }}</span>
                    </td>
                    <td>
                        <span class="badge badge-{{ strtolower($log->activity) }}">
                            {{ strtoupper($log->activity) }}
                        </span>
                    </td>
                    <td>
                        {{ class_basename($log->model_type) }}<br>
                        <span style="color: #4a5568;">ID: #{{ $log->model_id }}</span>
                    </td>
                    <td>
                        @if($log->activity == 'UPDATE' && is_array($log->after_changes))
                            <span style="color: #2b6cb0; font-weight: bold;">Mengubah field:</span> 
                            {{ implode(', ', array_keys($log->after_changes)) }}
                        @elseif($log->activity == 'DELETE')
                            <span style="color: #9b2c2c;">Seluruh manifest data dihapus dari database.</span>
                        @else
                            <span style="color: #22543d;">Input rekaman data baru ke sistem.</span>
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        Halaman otomatis digenerasi oleh Sistem SIDAYA Cilacap Kepatuhan ISO 27001. Dokumen Rahasia Negara.
    </div>

</body>
</html>