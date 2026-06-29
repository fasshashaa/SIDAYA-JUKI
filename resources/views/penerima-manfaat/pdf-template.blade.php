<!DOCTYPE html>
<html>
<head>
    <title>Data Penerima Manfaat SIDAYA</title>
    <style>
        body { font-family: sans-serif; font-size: 14px; line-height: 1.6; }
        .header { text-align: center; margin-bottom: 30px; border-bottom: 2px solid #000; padding-bottom: 10px; }
        .table-data { width: 100%; border-collapse: collapse; }
        .table-data td { padding: 8px; vertical-align: top; }
        .label { width: 30%; font-weight: bold; }
    </style>
</head>
<body>
    <div class="header">
        <h2>SISTEM INFORMASI SIDAYA</h2>
        <p>Dokumentasi Data Penerima Manfaat Usaha Ekonomi Produktif</p>
    </div>

    <table class="table-data">
        <tr>
            <td class="label">Nama Lengkap</td>
            <td>: {{ $penerima->nama_lengkap }}</td>
        </tr>
        <tr>
            <td class="label">NIK</td>
            <!-- Tampilkan NIK utuh di cetakan resmi PDF internal admin (tidak dimasking) -->
            <td>: {{ $penerima->nik }}</td> 
        </tr>
        <tr>
            <td class="label">Wilayah Kecamatan</td>
            <td>: {{ $penerima->kecamatan }}</td>
        </tr>
        <tr>
            <td class="label">Desa / Kelurahan</td>
            <td>: {{ $penerima->desa }}</td>
        </tr>
        <tr>
            <td class="label">Nomor WhatsApp</td>
            <td>: {{ $penerima->no_wa ?? 'Tidak Ada' }}</td>
        </tr>
    </table>
</body>
</html>