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
        <div class="title">Laporan Data Usaha Ekonomi Produktif</div>
        <div class="title">Dinas Sosial PPPA Kabupaten Cilacap</div>
        <div class="address"> Jl. Bromo Timur No.13, Sidakaya Dua, Sidakaya, Kec. Cilacap Sel., Kabupaten Cilacap, Jawa Tengah 53223</div>
    </div>
    
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Usaha</th>
                <th>Nama Pemilik</th>
                <th>Nama Ibu Kandung</th>
                <th>NIK</th>
                <th>No. KK</th>
                <th>No. WA</th>
                <th>Kategori Produk</th>
                <th>Alamat</th>
                <th>Kecamatan</th>
                <th>Desa</th>
                <th>Tahun Realisasi</th>
                <th>Sumber Anggaran</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach($data as $index => $item)
            <tr>
                <td class="text-center">{{ $index + 1 }}</td>
                <td>{{ $item->nama_usaha }}</td>
                <td>{{ $item->nama_lengkap }}</td>
                <td>{{ $item->nama_ibu_kandung }}</td> 
                <td>{{ $item->nik }}</td> 
                <td>{{ $item->no_kk }}</td> 
                <td>{{ $item->no_wa }}</td> 
                <td>{{ $item->kategori_produk }}</td> 
                <td>{{ $item->alamat_lengkap }}</td> 
                <td>{{ $item->kecamatan_usaha }}</td>
                <td>{{ $item->desa_kelurahan_usaha }}</td>
                <td>{{ $item->tahun_realisasi }}</td>
                <td>{{ $item->sumber_anggaran }}</td>
                <td>{{ ucfirst($item->status_perkembangan) }}</td>
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