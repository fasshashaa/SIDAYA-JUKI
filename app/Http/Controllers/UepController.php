<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Uep;

class UepController extends Controller
{
public function show($id)
{
    // Mengambil data UEP beserta relasi ke penerima manfaat
    $uep = Uep::with('penerimaManfaat')->findOrFail($id);
    return view('uep.show', compact('uep'));
}
    public function edit($id)
{
    $uep = Uep::findOrFail($id);
    
    // Pastikan variabel ini ada dan berisi data dari model PenerimaManfaat
    $penerimaManfaats = \App\Models\PenerimaManfaat::all(); 

    return view('uep.edit', compact('uep', 'penerimaManfaats'));
}

    public function update(Request $request, $id)
{
    $validated = $request->validate([
      'penerima_manfaat_id' => 'nullable|integer',
            'nama_usaha' => 'required|string|max:255',
            'nik' => 'required|numeric|digits:16',
            'no_kk' => 'required|numeric|digits:16',
            'nama_lengkap' => 'required|string|max:255',
            'nama_ibu_kandung' => 'required|string|max:255',
            'no_wa' => 'required|string|max:20',
            'kecamatan_usaha' => 'required|string',
            'desa_kelurahan_usaha' => 'required|string',
            'alamat_lengkap' => 'required|string',
            'kategori_produk' => 'required|string',
            'status_perkembangan' => 'required|in:rintisan,berkembang,mandiri',
            'tahun_realisasi' => 'required|digits:4',
            'sumber_anggaran' => 'required|string',
            'status_verifikasi'    => 'required|in:pending,disetujui,ditolak',
    ]);

    $uep = Uep::findOrFail($id);
    $uep = Uep::findOrFail($id);
    $uep->update($validated); // Hanya update field yang divalidasi

    return redirect()->route('uep.index')->with('success', 'Data berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $uep = Uep::findOrFail($id);
        $uep->delete();
        return redirect()->route('uep.index')->with('success', 'Data berhasil dihapus!');
    }
    /**
     * Menampilkan Halaman Daftar UEP
     * URL: /uep (Route: uep.index)
     */
    public function index()
    {
        $ueps = Uep::with('penerimaManfaat')->get();
        // Mengambil data dari tabel ueps (bisa diganti relasi model nanti jika sudah siap)
        $ueps = DB::table('ueps')->orderBy('created_at', 'desc')->get();
        $ueps = \App\Models\Uep::latest()->get();

        // Mengarahkan ke file resources/views/uep/index.blade.php
        return view('uep.index', compact('ueps'));
    }

    /**
     * Menampilkan Form Tambah Data UEP
     * URL: /uep/create (Route: uep.create)
     */
public function create()
{
    // Mengambil semua data PM
    $penerimaManfaats = \App\Models\PenerimaManfaat::all();
    return view('uep.create', compact('penerimaManfaats'));
}

    /**
     * Menyimpan Data Baru UEP
     */
    public function store(Request $request)
{
    
    // dd($request->all()); // Debug: Tampilkan semua data yang dikirimkan
try {
        $kube = \App\Models\Uep::create([
            'nama_usaha' => $request->nama_usaha,
            'penerima_manfaat_id' => $request->penerima_manfaat_id ?? null,
            'nik' => $request->nik,
            'no_kk' => $request->no_kk,
            'nama_lengkap' => $request->nama_lengkap,
            'nama_ibu_kandung' => $request->nama_ibu_kandung,
            'no_wa' => $request->no_wa,
            'kecamatan_usaha' => $request->kecamatan_usaha,
            'desa_kelurahan_usaha' => $request->desa_kelurahan_usaha,
            'alamat_lengkap' => $request->alamat_lengkap,
            'kategori_produk' => $request->kategori_produk,
           'status_usaha' => $request->status_usaha,
            'status_perkembangan' => $request->status_perkembangan,
            'tahun_realisasi' => $request->tahun_realisasi,
            'sumber_anggaran' => $request->sumber_anggaran,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

      
        return redirect()->route('uep.index')->with('success', 'Data UEP Berhasil Disimpan!');
    

    } catch (\Exception $e) {
        return back()->withErrors(['error' => 'Gagal menyimpan: ' . $e->getMessage()]);
    }
}
   
    public function getDesa($kecamatan)
{
    // Sesuaikan data ini dengan daftar desa di kecamatan Anda
    $data = [
        'Cilacap Tengah' => ['Sidanegara', 'Donan', 'Tambakreja', 'Lomanis'],
        'Cilacap Utara' => ['Kebonmanis', 'Gombolharjo', 'Karangtalun', 'Martasinga'],
        'Cilacap Selatan' => ['Tegalkamulyan', 'Tegalreja', 'Sidakaya'],
        'Adipala' => ['Adipala', 'Adireja', 'Karanganyar'],
        'Majenang' => ['Majenang', 'Jenang', 'Padangjaya'],
    ];

    return response()->json($data[$kecamatan] ?? []);
}
  public function getDesaByKecamatan($kecamatanNama)
    {
        $desas = DB::table('wilayah_desas')
                   ->where('kecamatan_nama', $kecamatanNama)
                   ->orderBy('nama_desa', 'asc')
                   ->pluck('nama_desa');

        return response()->json($desas);
    }
}