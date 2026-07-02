<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <style>
        body { font-family: 'Helvetica', 'Arial', sans-serif; font-size: 11px; color: #333; }
        
        /* Kop Surat */
        .header { text-align: center; border-bottom: 2px solid #000; padding-bottom: 10px; margin-bottom: 20px; }
        .title { font-size: 16px; font-weight: bold; text-transform: uppercase; margin: 0; }
        .address { font-size: 9px; margin-top: 5px; }

        /* Tabel */
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th { background-color: #f8f9fa; border: 1px solid #dee2e6; padding: 8px; text-align: center; font-size: 10px; }
        td { border: 1px solid #dee2e6; padding: 6px; font-size: 10px; }
        tr:nth-child(even) { background-color: #fcfcfc; }

        /* Tanda Tangan */
        .footer { margin-top: 30px; width: 100%; }
        .signature-box { float: right; width: 180px; text-align: center; }
    </style>
</head>
<body>

    <div class="header">
        <div class="title">Laporan Data Kelompok Usaha Bersama</div>
        <div class="title">Dinas Sosial PPPA Kabupaten Cilacap</div>
        <div class="address"> Jl. Bromo Timur No.13, Sidakaya Dua, Sidakaya, Kec. Cilacap Sel., Kabupaten Cilacap, Jawa Tengah 53223</div>
    </div>
    
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Kelompok</th>
                <th>Ketua</th>
                <th>Jenis Usaha</th>
                <th>No Telp</th>
                <th>Kecamatan</th>
                <th>Desa</th>
                <th>Alamat</th>
                <th>Anggota</th>
                <th>Tahun</th>
                <th>Anggaran</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach($data as $index => $item)
            <tr>
                <td class="text-center">{{ $index + 1 }}</td>
                <td>{{ $item->nama_kelompok_kube }}</td>
                <td>{{ $item->ketuaPenerimaManfaat->nama_lengkap ?? '-' }}</td>
                <td>{{ $item->jenis_usaha_kube }}</td>
                <td>{{ $item->no_telp_kube }}</td>
                <td>{{ $item->kecamatan_kube }}</td>
                <td>{{ $item->desa_kube }}</td>
                <td>{{ $item->alamat_lengkap_kube }}</td>
                <td class="text-center">{{ $item->jumlah_anggota }}</td>
                <td class="text-center">{{ $item->tahun_realisasi }}</td>
                <td>{{ $item->sumber_anggaran }}</td>
                <td>{{ ucfirst($item->status_verifikasi) }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
  <div class="footer">
        <div class="signature-box">
            <p>Cilacap, {{ date('d F Y') }}</p>
            <br><br><br>
            <p><strong>( _______________________ )</strong></p>
            <p>Kepala Dinas</p>
        </div>
    </div>

</body>
</html>